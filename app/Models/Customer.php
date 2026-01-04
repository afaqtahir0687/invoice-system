<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name', 'company_name', 'email', 'phone', 'address', 'city', 'zip', 'country', 'tax_id', 'is_active'
    ];

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
