<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'product_name',
        'product_type_id',
        'product_unit_id',
        'product_width',
        'product_length',
        'product_height',
        'product_volume',
        'price',
    ];

    public function receiveproduct() {
        return $this->belongsTo(ReceiveProduct::class);
    }

    public function orderproduct() {
        return $this->belongsTo(OrderProducts::class);
    }

    public function inventory() {
        return $this->belongsTo(Inventory::class);
    }

    public function productsalereport() {
        return $this->belongsTo(ProductSaleReport::class);
    }

    public function zones() {
        return $this->hasMany(Zone::class);
    }

    // ความสัมพันธ์กับ ProductType
    public function productType() {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }

    // ความสัมพันธ์กับ ProductUnit
    public function productUnit() {
        return $this->belongsTo(ProductUnit::class, 'product_unit_id');
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'product_name' => $this->product_name,
            'product_type' => $this->product_type,
            'unit' => $this->unit,
        ];
    }
}
