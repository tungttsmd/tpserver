<?php

namespace App\Http\Controllers;

use App\Exports\ComponentsExport;
use Illuminate\Http\Request;
use App\Models\Component;
use App\Models\Log;
use App\Models\UserLog;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ComponentController extends Controller
{
    public function index(Request $request)
    {
        $query = Component::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('serial_number', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }


        // SORT
        $sort = $request->input('sort', 'id');
        $dir = $request->input('dir', 'desc');
        $allowedSorts = ['category', 'serial_number', 'condition', 'location', 'status', 'id']; // tránh SQL Injection

        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, $dir);
        }

        $perPage = $request->input('perPage', 20); // mặc định 20
        $components = $query->paginate($perPage)->withQueryString();

        return view('components.index', compact('components'));
    }
    public function create()
    {
        return view('components.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'serial_number' => 'required|string|max:255|unique:components,serial_number',
            'category' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'condition' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        try {
            $component = Component::create([
                'serial_number' => $request->serial_number,
                'category' => $request->category,
                'location' => $request->location,
                'condition' => $request->condition,
                'status' => $request->status,
                'description' => $request->description,
            ]);

            UserLog::create([
                'action' => 'Thêm mới',
                'user' => Auth::user()->username ?? 'unknown',
                'note' => Auth::user()->username . " đã thêm mới $request->category " . "[$request->serial_number]"
            ]);

            $link_qr = "https://api.qrserver.com/v1/create-qr-code/?data={$request->serial_number}";

            return redirect()->route('components.create')->with([
                'successData' => [
                    'serial_number' => $request->serial_number,
                    'category' => $request->category,
                    'condition' => $request->condition,
                    'status' => $request->status,
                    'location' => $request->location,
                    'description' => $request->description,
                    'link_qr' => $link_qr
                ]
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Serial number đã tồn tại hoặc đã xảy ra lỗi!']);
        }
    }
    public function show(Component $component)
    {
        $link_qr = "https://api.qrserver.com/v1/create-qr-code/?data={$component->serial_number}";
        return view('components.show', compact('component', 'link_qr'));
    }

    public function edit(Component $component)
    {
        return view('components.edit', compact('component'));
    }

    public function update(Request $request, Component $component)
    {
        $validated = $request->validate([
            'serial_number' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'condition' => 'required|string|max:255',
            'description' => 'nullable|string',
            // 'status'      => 'required|string|max:255',
        ]);

        $component->fill($validated);

        if (!$component->isDirty()) {
            return redirect()
                ->route('components.show', $component->id)
                ->with('info', 'Thông tin không có thay đổi.');
        }

        $component->save();

        UserLog::create([
            'action' => 'Cập nhật',
            'user' => Auth::user()->username ?? 'unknown',
            'note' => Auth::user()->username . " đã thay đổi thông tin $component->category [$component->serial_number]"
        ]);

        return redirect()
            ->route('components.show', $component->id)
            ->with('success', 'Đã cập nhật thành công.');
    }

    public function destroy(Component $component)
    {
        $component->delete();
        UserLog::create([
            'action' => 'Xoá dữ liệu',
            'user' => Auth::user()->username ?? 'unknown',
            'note' => Auth::user()->username . " đã xoá linh kiện $component->category [$component->serial_number]"
        ]);
        return redirect()->route('components.index')
            ->with('success', "Đã xoá [$component->serial_number] thành công");
    }
    public function stock()
    {
        $components = Component::where('status', 'Sẵn kho')
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('components.stock', compact('components'));
    }
    public function export()
    {
        $components = Component::where('status', 'Xuất kho')
            ->orderBy('exported_at', 'desc')
            ->get();
        return view('components.export', compact('components'));
    }

    public function exportpost(Component $component)
    {
        if ($component->status !== 'Sẵn kho') {
            return redirect()->route('components.index')
                ->with('error', "Chỉ có linh kiện đang 'Sẵn kho' mới được xuất kho.");
        }

        $component->status = 'Xuất kho';
        $component->exported_at = now();
        $component->save();

        UserLog::create([
            'action' => 'Xuất kho',
            'user' => Auth::user()->username ?? 'unknown',
            'note' => Auth::user()->username . " xác nhận xuất kho $component->category [$component->serial_number]"
        ]);

        return redirect()->route('components.index')
            ->with('success', "Xuất kho $component->category [$component->serial_number] thành công!");
    }

    public function exportConfirm(Component $component)
    {
        $link_qr = "https://api.qrserver.com/v1/create-qr-code/?data={$component->serial_number}";
        return view('components.export-confirm', compact('component', 'link_qr'));
    }


    public function recallpost(Component $component)
    {
        if ($component->status !== 'Xuất kho') {
            return redirect()->route('components.index')
                ->with('error', "Chỉ có linh kiện đang 'Xuất kho' mới được thu hồi.");
        }

        $component->status = 'Sẵn kho';
        $component->recalled_at = now();
        $component->updated_at = now();
        $component->save();

        UserLog::create([
            'action' => 'Thu hồi',
            'user' => Auth::user()->username ?? 'unknown',
            'note' => Auth::user()->username . " xác nhận thu hồi $component->category [$component->serial_number]"
        ]);

        return redirect()->route('components.index')
            ->with('success', "Thu hồi $component->category [$component->serial_number] thành công!");
    }


    public function download(Request $request)
    {
        $type = $request->get('type', 'xlsx');
        $filename = 'tpserver_components_' . now()->format('Ymd_His') . '.' . $type;

        $format = match ($type) {
            'csv' => \Maatwebsite\Excel\Excel::CSV,
            'xls' => \Maatwebsite\Excel\Excel::XLS,
            'ods' => \Maatwebsite\Excel\Excel::ODS,
            'html' => \Maatwebsite\Excel\Excel::HTML,
            'pdf' => \Maatwebsite\Excel\Excel::DOMPDF,
            default => \Maatwebsite\Excel\Excel::XLSX,
        };

        return Excel::download(new ComponentsExport, $filename, $format);
    }

    public function scan()
    {
        return view(view: 'components.scan');
    }
    public function scanpost(Request $request)
    {
        $request->validate([
            'serial_number' => 'required|string|max:255',
        ]);

        $component = Component::where('serial_number', $request->input('serial_number'))->first();

        if (!$component) {
            return redirect()->back()->with('info', 'Không tìm thấy linh kiện có mã: ' . $request->input('serial_number'));
        }

        $link_qr = 'https://api.qrserver.com/v1/create-qr-code/?data=' . urlencode($component->serial_number);

        $serial = $request->input('serial_number');

        return view('components.show', [
            'component' => $component,
            'link_qr' => $link_qr,
        ])->with('success', 'Thông tin linh kiện: ' . $serial);
    }

}
