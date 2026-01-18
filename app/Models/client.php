<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'fileId',
    ];
    public function fileClient()
    {
        return $this->hasMany(fileClient::class);
    }
    public function cases()
    {
        return $this->belongsToMany(LegalCase::class);
    }
}
