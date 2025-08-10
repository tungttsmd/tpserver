<?php

namespace App\Http\Livewire\Features\Vendors;

use App\Models\Vendor;
use Livewire\Component;

class VendorShowLivewire extends Component
{
    protected $listeners = ['routeRefreshCall' => '$refresh', 'setVendorId' => 'setVendorId'];

    public $dir, $sort, $vendorId;
    public function render()
    {
        $vendor = Vendor::find($this->vendorId);
        $suggestions = $this->suggestions();
        $data = [
            'vendor' => $vendor,
            'suggestions' => $suggestions,
        ];
        return view('livewire.features.vendors.show', $data);
    }
    public function suggestions()
    {
        return [];
    }
    public function setLocationId($vendorId){
        $this->vendorId = $vendorId;
    }
}
