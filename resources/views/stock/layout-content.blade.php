<div >
    @if ($currentView === 'component-index')
        <livewire:component-table table="component-index" />
    @elseif ($currentView === 'component-stock')
        <livewire:component-table table="component-stock" />
    @elseif ($currentView === 'component-export')
        <livewire:component-table table="component-export" />
    @elseif ($currentView === 'component-form-create')
        <livewire:component-form form="component-form-create" />
    @elseif ($currentView === 'component-form-scan')
        <livewire:component-form form="component-form-scan" />
    @elseif ($currentView === 'component-edit')
        <livewire:component-form form="component-edit" />
    @elseif ($currentView === 'component-export-confirm')
        <livewire:component-form form="component-export-confirm" />
    @elseif ($currentView === 'component-show')
        <livewire:component-show show="component-show" />
    @else
        <p>Không tìm thấy view</p>
    @endif
</div>
