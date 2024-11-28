<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class image extends Model
{

    protected $fillable = [
        'user_id',
        'image',
        'mata_data',
        'ip_address',
        'browser',
        'description'
    ];
}
