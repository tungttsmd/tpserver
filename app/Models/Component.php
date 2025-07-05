<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class Component extends Model
{
    use HasRoles, HasPermissions, HasFactory;
    protected $fillable = ['serial_number', 'category', 'vendor', 'location', 'condition', 'status', 'description', 'exported_at'];

}
