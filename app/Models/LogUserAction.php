<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class LogUserAction extends Model
{
    use HasFactory, HasRoles, HasPermissions;
    protected $fillable = ['action_id', 'user_id', 'note'];
    public function action()
    {
        return $this->belongsTo(Action::class, 'action_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
