@php
    $relationship = rtrim($field, '_id');
@endphp
<td>

    @if (in_array($relationship, $relationships))
        {{ optional($value->$relationship)->name ?? '-' }}
    @else
        {{ $value->$field }}
    @endif

</td>
