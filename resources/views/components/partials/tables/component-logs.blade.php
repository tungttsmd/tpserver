@props(['list' => []])

<div>
    <div class="max-h-[64vh] overflow-auto">
        <table class="min-w-full divide-y">
            <thead class="bg-gray-50 dark:bg-gray-800 sticky top-0 z-16">
                <tr style="position: relative">
                    <x-atoms.table.th header="Hành động" />
                    <x-atoms.table.th header="Khởi tạo" />
                    <x-atoms.table.th header="Xuất kho" />
                    <x-atoms.table.th header="Thu hồi" />
                    <x-atoms.table.th header="Serial number" />
                    <x-atoms.table.th header="Tên linh kiện" />
                    <x-atoms.table.th header="Người thao tác" />
                    <x-atoms.table.th header="Thao tác" />
                    <x-atoms.table.th header="Nhà cung cấp" />
                    <x-atoms.table.th header="Khách hàng" />
                    <x-atoms.table.th header="Vị trí" />
                    <x-atoms.table.th header="Ghi chú" />
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($list as $value)
                    @php
                        $td = [
                            'id' => $value->component->id,
                            'created_at' => $value->created_at->format('d/m/Y H:i'),
                            'stockout_at' => filled($value->stockout_at)
                                ? \Carbon\Carbon::parse($value->stockout_at)->format('d/m/Y')
                                : '---',
                            'stockreturn_at' => filled($value->stockreturn_at)
                                ? \Carbon\Carbon::parse($value->stockreturn_at)->format('d/m/Y')
                                : '---',
                            'serial_number' => $value->component->serial_number ?? '---',
                            'name' => $value->component->name ?? '---',
                            'username' =>
                                ($value->user->alias ?? '---') . ' (' . ($value->user->username ?? '---') . ')',
                            'action' => $value->action->note ?? '---',
                            'vendor' => $value->vendor->name ?? '---',
                            'customer' => $value->customer->name ?? '---',
                            'location' => $value->location->name ?? '---',
                            'note' => $value->note ?? '---',
                        ];

                        // Xác định class text dựa trên action_id
                        if ($value->action_id === 39) {
                            $class = 'text-danger';
                        } elseif ($value->action_id === 15) {
                            $class = 'text-primary';
                        } else {
                            $class = 'text-success';
                        }
                    @endphp

                    <tr class="even:bg-gray-50 hover:bg-gray-100">
                        <x-partials.actions.component-logs :value="$td['id']" :class="$class" />
                        <x-atoms.table.td :value="$td['created_at']" :class="$class" />
                        <x-atoms.table.td :value="$td['stockout_at']" :class="$class" />
                        <x-atoms.table.td :value="$td['stockreturn_at']" :class="$class" />
                        <x-atoms.table.td :value="$td['serial_number']" :class="$class" />
                        <x-atoms.table.td :value="$td['name']" :class="$class" />
                        <x-atoms.table.td :value="$td['username']" :class="$class" />
                        <x-atoms.table.td :value="$td['action']" :class="$class" />
                        <x-atoms.table.td :value="$td['vendor']" :class="$class" />
                        <x-atoms.table.td :value="$td['customer']" :class="$class" />
                        <x-atoms.table.td :value="$td['location']" :class="$class" />
                        <x-atoms.table.td :value="$td['note']" :class="$class" />
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
