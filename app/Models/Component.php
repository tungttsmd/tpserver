<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class Component extends Model
{
    use HasRoles,HasPermissions ;
    protected $fillable = ['serial_number', 'category', 'location', 'condition', 'status', 'description', 'exported_at'];
}
