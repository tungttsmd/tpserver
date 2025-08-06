@props([
    'columns' => ['columns 1', 'columns 2'],
    'list' => [
        ['columns 1' => 'x-partials.table 1', 'columns 2' => 'x-partials.table 2'],
        ['columns 1' => 'x-partials.table 1', 'columns 2' => 'x-partials.table 2'],
    ],
    'sort' => null,
    'dir' => null,
    'actions' => null,
])

<div class="filament-tables max-h-[64vh] overflow-auto">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-800 sticky top-0 z-16">
            <tr>
                @if ($actions)
                    <x-atoms.table.th header="Hành động" />
                @endif

                @foreach ($columns as $column)
                    <x-atoms.table.th :header="$column" :sort="$sort" :dir="$dir" />
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
            @if (collect($list)->isEmpty())
                <tr class="border-b w-full">
                    <x-atoms.table.th header="Không tìm thấy dữ liệu" :sort="$sort" :dir="$dir" />
                </tr>
            @else
                @foreach (collect($list) as $record)
                    <tr>
                        @if ($actions)
                            <x-partials.actions header="Hành động" :record-id="data_get($record, 'id')" />
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
