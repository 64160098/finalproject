<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'product_name',
        'quuantity_products_sold'
    ];

    public function product() {
        return $this->hasMany(Product::class, 'code', 'id');
    }
}
