<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cause extends Model
{
    protected $fillable = [
        'nameClient',
        'type',
        'executers',
        'subject',
        'ratio',
        'status',
    ];
}
