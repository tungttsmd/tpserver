<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class Component extends Model
{
    use HasRoles, HasPermissions, HasFactory;
    protected $fillable = ['serial_number', 'name', 'category_id', 'vendor_id', 'location_id', 'condition_id', 'status_id', 'manufacturer_id', 'note', 'warranty_start', 'warranty_end', 'stockin_at'];
    public $timestamps = false;
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
    public function condition()
    {
        return $this->belongsTo(Condition::class, 'condition_id');
    }
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
