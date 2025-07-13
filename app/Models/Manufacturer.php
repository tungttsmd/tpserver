<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    public $timestamps = false;

    protected $table = 'manufacturers';

    protected $fillable = ['name'];
}