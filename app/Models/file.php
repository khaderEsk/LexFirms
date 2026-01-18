<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';
    protected $fillable = [
        'legal_case_id',
        'original_name',
        'path',
        'lawyer_id'
    ];

    public function cases()
    {
        return $this->belongsTo(LegalCase::class, 'legal_case_id');
    }


    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id');
    }
}
