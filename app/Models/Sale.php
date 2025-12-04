<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_date',
        'customer_id',
        'total_amount',
        'amount_paid', // dev by Techlink360: Added amount_paid to fillable
        'change',      // dev by Techlink360: Added change to fillable
        'payment_method',
        'created_by',
    ];

    public function items()
    {
        return $this->hasMany(SaleItem::class, 'sale_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
