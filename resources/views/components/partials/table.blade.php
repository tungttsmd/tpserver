@props([
    'columns' => ['columns 1', 'columns 2'],
    'list' => [
        ['columns 1' => 'x-partials.table 1', 'columns 2' => 'x-partials.table 2'],
        ['columns 1' => 'x-partials.table 1', 'columns 2' => 'x-partials.table 2'],
    ],
])

<div class="filament-tables max-h-[64vh] overflow-auto">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-800 sticky top-0 z-16">
            <tr>
                @foreach ($columns as $column)
                    <x-atoms.table.th :header="$column" />
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
            @foreach (collect($list) as $record)
                <tr>
                    @foreach ($columns as $column)
                        <x-atoms.table.td :value="data_get($record, $column)" />
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
