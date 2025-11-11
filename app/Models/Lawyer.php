<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lawyer extends Model
{
    protected $fillable = [
        'firstName',
        'seconedName',
        'Nickname',
        'PlaceBirth',
        'birthDate',
        'secretariat',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
