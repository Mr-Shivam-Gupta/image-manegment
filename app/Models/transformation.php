<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transformation extends Model
{
    protected $fillable = [
        'image_id',
        'image',
        'transformate',
        'ip_address',
        'browser',
    ];
}
