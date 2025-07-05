<div class="container p-2 max-w-full">
    {{-- Bộ lọc --}}
    @include('livewire.partials.component-table-filter')

    {{-- Thông báo --}}
    @include('livewire.partials.component-table-alert')

    {{-- Bảng dữ liệu --}}
    <div class="table-responsive shadow-sm rounded" style="max-height: 65vh; overflow-y: auto;">
        <table class="table table-bordered text-center align-middle custom-table">
            <thead>
                <tr>
                    @if ($view_table_action_buttons)
                        <th>Hành động</th>
                    @endif

                    @foreach ($columns as $field)
                        <th wire:click="sortBy('{{ $field }}')"
                            style="cursor: pointer; user-select: none;width: {{ $columnWidths[$field] ?? 'auto' }};">
                            {{ $field }}
                            @if ($sort === $field)
                                <i class="fas fa-sort-amount-{{ $dir === 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($components as $component)
                    <tr>

                        @if ($view_table_action_buttons)
                            <td>
                                @include($view_table_action_buttons)
                            </td>
                        @endif
                        @foreach ($columns as $field)
                            <td>
                                @php $relationship = rtrim($field, '_id') @endphp
                                @if (in_array($relationship, $relationships))
                                    {{ optional($component->$relationship)->name ?? '-' }}
                                @else
                                    {{ $component->$field }}
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3 d-flex justify-content-center">
        {{ $components->links('livewire.pagination.custom-paginator') }}
    </div>

    <style>
        .custom-table {
            border-collapse: collapse;
            width: 100%;
        }

        /* Header */
        .custom-table thead th {
            position: sticky;
            top: 0;
            background-color: #4b6cb7;
            color: white;
            z-index: 10;
            white-space: nowrap;
            vertical-align: middle;
            border: 1px solid #dee2e6;
            padding: 8px 12px;
        }

        /* Body cells */
        .custom-table tbody td {
            background-color: #fff;
            border: 1px solid #dee2e6;
            color: #212529;
            white-space: nowrap;
            vertical-align: middle;
            padding: 8px 12px;
        }

        /* Hover effect */
        .custom-table tbody tr:hover td {
            background-color: #f8f9fa;
        }
    </style>
</div>
