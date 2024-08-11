<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSaleReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'product_name',
        'quantity_products_sale',
        'unit',
        'cost_unit',
        'total'
    ];

    public function product() {
        return $this->hasMany(Product::class, 'code', 'id');
    }
}
