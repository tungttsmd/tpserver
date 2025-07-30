@props([
    'data' => [],
    'columns' => [],
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
                            <x-table-action :component-id="$value->id" :route="session('route')['filter'] ?? null" />
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
