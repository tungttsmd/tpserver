<?php

namespace App\Http\Controllers;

use App\Exports\UserLogsExport;
use App\Models\Component;
use App\Models\UserLog;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserLogController extends Controller
{
    public function index()
    {
        $logs = UserLog::orderBy('created_at', 'desc')->get();
        return view('logs.index', compact('logs'));
    }
    public function download(Request $request)
    {
        $type = $request->get('type', 'xlsx');
        $filename = 'tpserver_logs_' . now()->format('Ymd_His') . '.' . $type;

        $format = match ($type) {
            'csv' => \Maatwebsite\Excel\Excel::CSV,
            'xls' => \Maatwebsite\Excel\Excel::XLS,
            'ods' => \Maatwebsite\Excel\Excel::ODS,
            'html' => \Maatwebsite\Excel\Excel::HTML,
            'pdf' => \Maatwebsite\Excel\Excel::DOMPDF,
            default => \Maatwebsite\Excel\Excel::XLSX,
        };

        return Excel::download(new UserLogsExport, $filename, $format);
    }
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        //
    }
}
