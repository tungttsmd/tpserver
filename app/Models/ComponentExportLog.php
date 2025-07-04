<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentExportLog extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'serial_number', 'export_reason'];

}
