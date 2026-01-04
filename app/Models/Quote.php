<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = [
        'quote_number', 'quote_date', 'due_date', 'reference', 'customer_id', 'subtotal', 'total_tax', 'total_discount', 'shipping', 'grand_total', 'status', 'notes'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(QuoteItem::class);
    }
}
