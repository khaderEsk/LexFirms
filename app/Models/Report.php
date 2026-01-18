<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'legal_case_id',
        'description'
    ];

    public function cases()
    {
        return $this->belongsTo(LegalCase::class, 'id');
    }
}
