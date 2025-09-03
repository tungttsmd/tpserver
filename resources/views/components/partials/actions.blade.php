@props([
    'value' => 'x-atoms.table.td :value',
    'class' => '',
    'recordId' => null,
    'filter' => null,
])

<td class="px-4 py-3 text-sm text-gray-900 whitespace-nowrap text-center {{ $class }}" title="{{ $value }}">
    @switch($filter)
        @case('current-stock')
            <x-partials.actions.current-stock :record-id="$recordId" />
        @break

        @case('current-stockout')
            <x-partials.actions.current-stockout :record-id="$recordId" />
        @break

        @case('customers')
            <x-partials.actions.customers :record-id="$recordId" />
        @break

        @case('locations')
            <x-partials.actions.locations :record-id="$recordId" />
        @break

        @case('vendors')
            <x-partials.actions.vendors :record-id="$recordId" />
        @break

        @default
            <span>--</span>
    @endswitch
</td>
