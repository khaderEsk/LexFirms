<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'lawyer_id',
        'description',
        'amount',
        'date',
        'legal_case_id'
    ];

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id');
    }

    public function case()
    {
        return $this->belongsTo(LegalCase::class, 'legal_case_id');
    }
}
