<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $fillable = [
        'legal_case_id',
        'img',
        'amount',
        'currency',
        'notes'
    ];
    public function case()
    {
        return $this->belongsTo(LegalCase::class, 'legal_case_id');
    }
}
