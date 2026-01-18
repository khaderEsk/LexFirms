<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalCase extends Model
{
    protected $fillable = [
        'client_id',
        'attribute',
        'second_party_name',
        'progress',
        'court',
        'department',
        'base_number',
        'name_case',
        'subject',
        'case_type',
        'dollar_price',
        'exchange_rate',
        'syrian_prices',
        'remaining_balance_of_payment',
        'remaining_balance_of_expenditure',
    ];

    public function lawyers()
    {
        return $this->belongsToMany(Lawyer::class, 'case_lawyer', 'legal_case_id', 'lawyer_id');
    }

    public function files()
    {
        return $this->hasMany(File::class, 'legal_case_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function stages()
    {
        return $this->hasMany(Stage::class, 'legal_case_id');
    }


    public function reports()
    {
        return $this->hasMany(Report::class, 'legal_case_id');
    }

    public function payment()
    {
        return $this->hasMany(Payment::class);
    }
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
