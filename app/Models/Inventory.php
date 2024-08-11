<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'product_name',
        'amount'
    ];

    public function product() {
        return $this->hasMany(Product::class, 'code', 'id');
    }

    public function receiveproduct() {
        return $this->belongsTo(ReceiveProduct::class, 'receive_product_id');
    }
}
