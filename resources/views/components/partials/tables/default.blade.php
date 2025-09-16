@props([
    'columns' => [],
    'headers' => null,
    'list' => [],
    'sort' => null,
    'dir' => null,
    'filter' => null,
])

<div class="overflow-x-auto max-w-full">
    <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-800 sticky top-0 z-16">
            @php
                $headers = $headers ?? $columns;
                if (empty($columns) && !empty($list)) {
                    $columns = array_keys((array) $list[0]);
                    $headers = $headers ?? $columns;
                }
            @endphp
            <tr>
                @if ($filter)
                    <x-atoms.table.th header="Hành động" />
                @endif

                @foreach ($headers as $header)
                    <x-atoms.table.th :header="$header" :sort="$sort" :dir="$dir" />
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
            @if (collect($list)->isEmpty())
                <tr class="border-b w-full even:bg-gray-50 hover:bg-gray-100">
                    <x-atoms.table.th header="Không tìm thấy dữ liệu" :sort="$sort" :dir="$dir" />
                </tr>
            @else
                @foreach (collect($list) as $record)
                    <tr class="even:bg-gray-50 hover:bg-gray-100">
                        @if ($filter)
                            <x-partials.actions :filter="$filter" header="Hành động" :record-id="data_get($record, 'ID')" />
                        @endif
                        @foreach ($columns as $column)
                            <x-atoms.table.td :value="data_get($record, $column)" />

                        @endforeach
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

</div>
