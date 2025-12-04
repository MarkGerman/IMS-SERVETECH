<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'return_id',
        'sale_item_id',
        'quantity',
        'approved_by',
        'return_date',
    ];

    /**
     * Get the return that the item belongs to.
     * dev by Techlink360
     */
    public function return()
    {
        return $this->belongsTo(Returns::class, 'return_id');
    }

    /**
     * Get the sale item that was returned.
     * dev by Techlink360
     */
    public function saleItem()
    {
        return $this->belongsTo(SaleItem::class);
    }

    /**
     * Get the user who approved the return.
     * dev by Techlink360
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
