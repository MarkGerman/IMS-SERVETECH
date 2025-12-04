<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'customer_id',
        'return_date',
        'reason',
        'total_refund_amount',
        'status',
        'approved_by',
        'created_by',
    ];

    protected $casts = [
        'return_date' => 'datetime',
    ];

    /**
     * Get the sale associated with the return.
     * dev by Techlink360
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    /**
     * Get the customer associated with the return.
     * dev by Techlink360
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get the user who created the return.
     * dev by Techlink360
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who approved the return.
     * dev by Techlink360
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the return items for the return.
     * dev by Techlink360
     */
    public function returnItems()
    {
        return $this->hasMany(ReturnItem::class, 'return_id');
    }
}
