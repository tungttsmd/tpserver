<div class="tp-server layouts table-responsive shadow-sm rounded p-0">
    <div class="tpserver components table">
        <div style="max-height: 58vh; width: 1px;">
            <table class="text-center align-middle custom-table">
                <thead>
                    <tr>
                        <th>Hành động</th>
                        @foreach ($data['columns'] as $field)
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
                    @foreach ($data['components'] as $component)
                        <tr>
                            <td>@include(
                                'livewire.elements.components.' . (session('route')['filter'] ?? null) . '-action',
                                ['component_id' => 2]
                            )</td>
                            @foreach ($data['columns'] as $field)
                                <td>
                                    @php $relationship = rtrim($field, '_id') @endphp
                                    @if (in_array($relationship, $data['relationships']))
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
    </div>
</div>


