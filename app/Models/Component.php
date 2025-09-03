<?php

namespace App\Models;

use App\Http\Controllers\ComponentExportLogController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class Component extends Model
{
    use HasRoles, HasPermissions, HasFactory;

    protected $fillable = ['serial_number', 'name', 'category_id', 'status_id', 'note', 'warranty_start', 'warranty_end', 'stockin_source', 'stockin_at'];
    protected $casts = [
        'stockin_at' => 'datetime',
        'warranty_start' => 'datetime',
        'warranty_end' => 'datetime',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
