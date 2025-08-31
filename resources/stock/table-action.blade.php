@php
    $routeName = $route ?? 'index';
    $view = 'components.table-action-' . $routeName;
@endphp

<td>
    @includeIf($view, ['component_id' => $componentId])
</td>
