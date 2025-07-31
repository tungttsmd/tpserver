@props([
    // $tableName: customers.index, components.current-stock....
    // $data: Customer::paginate(...), Component::paginate(...)
    // $columns: schema table columns customers, components...
    'controller' => $controller ?? null,
    'action' => $action ?? 'index',
    'tableActionSet' => 'table.actions.button-set.'. $controller . '.'.$action, // table.actions.button-set.customers.index example
    'data' => $data ?? [],
    'columns' => $columns ?? [],
    'relationships' => [],
    'sort' => null,
    'dir' => null,
])

<div class="tp-server layouts table-responsive shadow-sm rounded p-0">
    <div class="tpserver components table">
        <div style="max-height: 68vh; width: 1px;">
            <table class="text-center align-middle custom-table">
                <thead>
                    <tr>
                        <th>Hành động</th>
                        @foreach ($columns as $field)
                            <x-table-column-sort :field="$field" :sort="$sort" :dir="$dir" />
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $value)
                        <tr>
                            <td>hello {{ $tableActionSet }}</td>
                            <x-{{ $tableActionSet }} :record-id="$value->id" :route="session('route')['filter'] ?? null" />
                                {{-- Lỗi tại anh ở đây laravel có hỗ trợ khưa này đâu --}}
                            @foreach ($columns as $field)
                                <x-table-data :relationships="$relationships" :value="$value" :field="$field" />
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
