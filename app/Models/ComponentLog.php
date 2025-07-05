<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class ComponentLog extends Model
{
    use HasFactory, HasRoles, HasPermissions;
    protected $fillable = ['action_id', 'user_id', 'note'];
    public $timestamps = false;
}
