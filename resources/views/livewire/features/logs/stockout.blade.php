    <div class="p-4 w-full">
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

        <table class="min-w-full border border-gray-200 text-sm text-[#553686]">
            <thead class="bg-gray-100 text-[#553686] font-semibold">
                <tr>
                    <th class="px-3 py-2 border border-gray-200 text-left">#</th>
                    <th class="px-3 py-2 border border-gray-200 text-left">Ngày xuất kho</th>
                    <th class="px-3 py-2 border border-gray-200 text-left">Serial number</th>
                    <th class="px-3 py-2 border border-gray-200 text-left">Tên linh kiện</th>
                    <th class="px-3 py-2 border border-gray-200 text-left">Người thao tác</th>
                    <th class="px-3 py-2 border border-gray-200 text-left">Thao tác</th>
                    <th class="px-3 py-2 border border-gray-200 text-left">Nhà cung cấp</th>
                    <th class="px-3 py-2 border border-gray-200 text-left">Khách hàng</th>
                    <th class="px-3 py-2 border border-gray-200 text-left">Vị trí</th>
                    <th class="px-3 py-2 border border-gray-200 text-left">Ghi chú</th>
                    <th class="px-3 py-2 border border-gray-200 text-left">Thực hiện lúc</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($componentLogs as $index => $log)
                    <tr class="even:bg-gray-50 hover:bg-gray-100 text-[#553686]">
                        <td class="px-3 py-2 border border-gray-200 text-left whitespace-nowrap overflow-hidden text-ellipsis max-w-[80px]"
                            title="{{ $log->component->id ?? '---' }}">
                            {{ $log->component->id ?? '---' }}
                        </td>
                        <td class="px-3 py-2 border border-gray-200 text-left whitespace-nowrap overflow-hidden text-ellipsis max-w-[120px]"
                            title="{{ \Carbon\Carbon::parse($log->stockout_at)->format('d/m/Y') }}">
                            <strong>{{ \Carbon\Carbon::parse($log->stockout_at)->format('d/m/Y') }}</strong>
                        </td>
                        <td class="px-3 py-2 border border-gray-200 text-left whitespace-nowrap overflow-hidden text-ellipsis max-w-[150px]"
                            title="{{ $log->component->serial_number ?? '---' }}">
                            {{ $log->component->serial_number ?? '---' }}
                        </td>
                        <td class="px-3 py-2 border border-gray-200 text-left whitespace-nowrap overflow-hidden text-ellipsis max-w-[200px]"
                            title="{{ $log->component->name ?? '---' }}">
                            {{ $log->component->name ?? '---' }}
                        </td>
                        <td class="px-3 py-2 border border-gray-200 text-left whitespace-nowrap overflow-hidden text-ellipsis max-w-[180px]"
                            title="{{ $log->user->alias ?? '---' }} ({{ $log->user->username ?? '---' }})">
                            {{ $log->user->alias ?? '---' }} ({{ $log->user->username ?? '---' }})
                        </td>
                        <td class="px-3 py-2 border border-gray-200 text-left whitespace-nowrap overflow-hidden text-ellipsis max-w-[150px]"
                            title="{{ $log->action->note ?? '---' }}">
                            {{ $log->action->note ?? '---' }}
                        </td>
                        <td class="px-3 py-2 border border-gray-200 text-left whitespace-nowrap overflow-hidden text-ellipsis max-w-[150px]"
                            title="{{ $log->vendor->name ?? '---' }}">
                            {{ $log->vendor->name ?? '---' }}
                        </td>
                        <td class="px-3 py-2 border border-gray-200 text-left whitespace-nowrap overflow-hidden text-ellipsis max-w-[150px]"
                            title="{{ $log->customer->name ?? '---' }}">
                            {{ $log->customer->name ?? '---' }}
                        </td>
                        <td class="px-3 py-2 border border-gray-200 text-left whitespace-nowrap overflow-hidden text-ellipsis max-w-[150px]"
                            title="{{ $log->location->name ?? '---' }}">
                            {{ $log->location->name ?? '---' }}
                        </td>
                        <td class="px-3 py-2 border border-gray-200 text-left whitespace-nowrap overflow-hidden text-ellipsis max-w-[250px]"
                            title="{{ $log->note ?? '---' }}">
                            {{ $log->note ?? '---' }}
                        </td>
                        <td class="px-3 py-2 border border-gray-200 text-left whitespace-nowrap overflow-hidden text-ellipsis max-w-[150px]"
                            title="{{ $log->created_at->format('d/m/Y H:i') }}">
                            {{ $log->created_at->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $componentLogs->links('livewire.elements.components.paginator') }}
        </div>

        {{-- Component style --}}
        <link rel="stylesheet" href="{{ asset('css/components/index.css') }}">
    </div>
