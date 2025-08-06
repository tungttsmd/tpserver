@props([
    'value' => 'x-atoms.table.td :value',
    'class' => '',
])
<td class="px-4 py-3 text-sm text-gray-900 whitespace-nowrap {{ $class }}" title="{{ $value }}">
    {{ $value }}</td>
