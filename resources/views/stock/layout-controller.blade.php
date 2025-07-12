<div class="p-2"> 
    @if ($viewRender === 'components.table.index')
        <livewire:component-table table="component-index" />
    @elseif ($viewRender === 'component-stock')
        <livewire:component-table table="component-stock" />
    @elseif ($viewRender === 'component-export')
        <livewire:component-table table="component-export" />
    @elseif ($viewRender === 'component-form-create')
        <livewire:component-form form="component-form-create" />
    @elseif ($viewRender === 'component-form-scan')
        <livewire:component-form form="component-form-scan" />
    @elseif ($viewRender === 'component-edit')
        <livewire:component-form form="component-edit" />
    @elseif ($viewRender === 'component-export-confirm')
        <livewire:component-form form="component-export-confirm" />
    @elseif ($viewRender === 'component-show')
        <livewire:component-show show="component-show" />
    @else
        <p>Không tìm thấy view</p>
    @endif
</div>
