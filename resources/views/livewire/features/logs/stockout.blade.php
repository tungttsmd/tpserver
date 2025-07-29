<div class="tpserver components table p-4 w-full overflow-">
    @php
        $columns = [
            ['label' => '#', 'value' => fn($log) => $log->component->id ?? '---', 'maxWidth' => '80px'],
            [
                'label' => 'Ngày xuất kho',
                'value' => fn($log) => \Carbon\Carbon::parse($log->stockout_at)->format('d/m/Y'),
                'maxWidth' => '120px',
                'isStrong' => true,
            ],
            [
                'label' => 'Serial number',
                'value' => fn($log) => $log->component->serial_number ?? '---',
                'maxWidth' => '150px',
            ],
            [
                'label' => 'Tên linh kiện',
                'value' => fn($log) => $log->component->name ?? '---',
                'maxWidth' => '200px',
            ],
            [
                'label' => 'Người thao tác',
                'value' => fn($log) => ($log->user->alias ?? '---') . ' (' . ($log->user->username ?? '---') . ')',
                'maxWidth' => '180px',
            ],
            ['label' => 'Thao tác', 'value' => fn($log) => $log->action->note ?? '---', 'maxWidth' => '150px'],
            ['label' => 'Nhà cung cấp', 'value' => fn($log) => $log->vendor->name ?? '---', 'maxWidth' => '150px'],
            ['label' => 'Khách hàng', 'value' => fn($log) => $log->customer->name ?? '---', 'maxWidth' => '150px'],
            ['label' => 'Vị trí', 'value' => fn($log) => $log->location->name ?? '---', 'maxWidth' => '150px'],
            ['label' => 'Ghi chú', 'value' => fn($log) => $log->note ?? '---', 'maxWidth' => '250px'],
            [
                'label' => 'Thực hiện lúc',
                'value' => fn($log) => $log->created_at->format('d/m/Y H:i'),
                'maxWidth' => '150px',
            ],
        ];
    @endphp
    <div class="overflow-auto max-h-[80vh]">
        <table class="custom-table min-w-full border border-gray-200 text-sm text-[#553686]">
            <thead class="text-[#553686] font-semibold">
                <tr style="position: relative">
                    <x-table-th>ID linh kiện</x-table-th>
                    <x-table-th>Xuất kho</x-table-th>
                    <x-table-th>Thu hồi</x-table-th>
                    <x-table-th>Serial number</x-table-th>
                    <x-table-th>Tên linh kiện</x-table-th>
                    <x-table-th>Người thao tác</x-table-th>
                    <x-table-th>Thao tác</x-table-th>
                    <x-table-th>Nhà cung cấp</x-table-th>
                    <x-table-th>Khách hàng</x-table-th>
                    <x-table-th>Vị trí</x-table-th>
                    <x-table-th>Ghi chú</x-table-th>
                    <x-table-th>Thực hiện</x-table-th>
                </tr>
            </thead>
            <tbody>
                @foreach ($componentLogs as $index => $log)
                    <tr class="even:bg-gray-50 hover:bg-gray-100 text-[#553686]">
                        <x-table-td :title="$log->component->id ?? '---'">
                            <strong>{{ $log->component->id ?? '---' }}</strong>
                        </x-table-td>
                        <x-table-td :title="\Carbon\Carbon::parse($log->stockout_at)->format('d/m/Y')" max="120px">
                            <strong>{{ \Carbon\Carbon::parse($log->stockout_at)->format('d/m/Y') }}</strong>
                        </x-table-td>
                        <x-table-td :title="\Carbon\Carbon::parse($log->stockreturn_at)->format('d/m/Y')" max="120px">
                            <strong>{{ \Carbon\Carbon::parse($log->stockreturn_at)->format('d/m/Y') }}</strong>
                        </x-table-td>

                        <x-table-td :title="$log->component->serial_number ?? '---'" max="150px">
                            {{ $log->component->serial_number ?? '---' }}
                        </x-table-td>

                        <x-table-td :title="$log->component->name ?? '---'" max="200px">
                            {{ $log->component->name ?? '---' }}
                        </x-table-td>

                        <x-table-td :title="($log->user->alias ?? '---') . ' (' . ($log->user->username ?? '---') . ')'"
                            max="180px">
                            {{ $log->user->alias ?? '---' }} ({{ $log->user->username ?? '---' }})
                        </x-table-td>

                        <x-table-td :title="$log->action->note ?? '---'" max="150px">
                            {{ $log->action->note ?? '---' }}
                        </x-table-td>

                        <x-table-td :title="$log->vendor->name ?? '---'" max="150px">
                            {{ $log->vendor->name ?? '---' }}
                        </x-table-td>

                        <x-table-td :title="$log->customer->name ?? '---'" max="150px">
                            {{ $log->customer->name ?? '---' }}
                        </x-table-td>

                        <x-table-td :title="$log->location->name ?? '---'" max="150px">
                            {{ $log->location->name ?? '---' }}
                        </x-table-td>

                        <x-table-td :title="$log->note ?? '---'" max="250px">
                            {{ $log->note ?? '---' }}
                        </x-table-td>

                        <x-table-td :title="$log->created_at->format('d/m/Y H:i')" max="150px">
                            {{ $log->created_at->format('d/m/Y H:i') }}
                        </x-table-td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $componentLogs->links('livewire.elements.components.paginator') }}
    </div>

    {{-- Component style --}}
    <link rel="stylesheet" href="{{ asset('css/components/index.css') }}">
</div>
