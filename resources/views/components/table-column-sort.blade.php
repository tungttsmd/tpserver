<th wire:click="sortBy('{{ $field }}')" style="cursor: pointer; user-select: none; width:auto;">
    {{ $field }}
    @if ($sort === $field)
        <i class="fas fa-sort-amount-{{ $dir === 'asc' ? 'up' : 'down' }}"></i>
    @else
        <i class="fas fa-sort"></i>
    @endif
</th>
