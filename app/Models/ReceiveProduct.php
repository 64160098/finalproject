<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ReceiveProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'product_name',
        'quantity_products_received',
        'unit',
        'cost_unit',
        'total'
    ];

    public function product() {
        return $this->hasMany(Product::class, 'code', 'id');
    }

    public function inventory() {
        return $this->hasOne(Inventory::class, 'receive_product_id');
    }

}
