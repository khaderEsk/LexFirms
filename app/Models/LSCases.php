<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LSCases extends Model
{
    protected $fillable = [
        'discountName',
        'type',
        'unit',
        'cort',
        'caseNumber'
    ];
}
