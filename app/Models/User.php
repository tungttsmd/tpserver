<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasPermissions;

    protected $fillable = ['username', 'password'];
    protected $hidden = ['password', 'remember_token'];
    public $timestamps = false;
    public function canEditPassword(): bool
    {
        return $this->id === auth()->id() || auth()->user()?->hasPermissionTo('edit_users_password');
    }

    public function canEditUser(): bool
    {
        return $this->id === auth()->id() || auth()->user()?->hasPermissionTo('edit_users');
    }
}
