<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number', 'invoice_date', 'due_date', 'customer_id', 'subtotal', 'total_tax', 'total_discount', 'shipping', 'grand_total', 'amount_paid', 'balance_due', 'status', 'notes', 'terms', 'signature'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
