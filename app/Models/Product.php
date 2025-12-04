<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'category_id',
        'brand',
        'purchase_price',
        'selling_price',
        'quantity',
        'reorder_level',
        'barcode',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class, 'product_id');
    }

    public function returns()
    {
        return $this->hasMany(Returns::class, 'product_id');
    }
}
