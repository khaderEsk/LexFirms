<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class fileClient extends Model
{
    protected $fillable = [
        'client_id',
        'type',
        'file'
    ];
    public function client (){
        return $this->belongsTo(Client::class);
    }
}
