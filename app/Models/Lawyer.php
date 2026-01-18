<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lawyer extends Model
{
    protected $table = 'lawyers';
    protected $fillable = [
        'user_id',
        'fullName',
        'seconedName',
        'motherName',
        'phone',
        'birthDate',
        'secretariat',
        'nationalNumer',
        'status',
        'joinDate',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function cases()
    {
        return $this->belongsToMany(LegalCase::class, 'case_lawyer', 'lawyer_id', 'legal_case_id');
    }

    public function stages()
    {
        return $this->belongsToMany(Stage::class, 'stage_lawyer');
    }


    public function files()
    {
        return $this->hasMany(File::class, 'lawyer_id');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'lawyer_id');
    }
}
