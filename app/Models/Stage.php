<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $fillable = [
        'legal_case_id',
        'subject',
        'date',
        'note',
        'before_update_subject',
        'before_update_note',
        'before_update_date'
    ];

    public function cases()
    {
        return $this->belongsTo(LegalCase::class, 'legal_case_id');
    }
    public function lawyers()
    {
        return $this->belongsToMany(Lawyer::class, 'stage_lawyer');
    }
}
