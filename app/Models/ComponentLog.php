<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class ComponentLog extends Model
{
    use HasFactory, HasRoles, HasPermissions;
    protected $fillable = ['component_id', 'action_id', 'user_id', 'customer_id', 'vendor_id', 'stockout_at', 'note'];
    public function component()
    {
        return $this->belongsTo(\App\Models\Component::class);
    }
    public function action()
    {
        return $this->belongsTo(\App\Models\ActionLog::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function vendor()
    {
        return $this->belongsTo(\App\Models\Vendor::class);
    }

    public function customer()
    {
        return $this->belongsTo(\App\Models\Customer::class);
    }
}
