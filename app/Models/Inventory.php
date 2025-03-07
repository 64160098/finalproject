<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'amount',
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');  // แก้ไขให้ใช้ belongsTo และเชื่อมโยงกับ product_id
    }

    public function receiveproduct() {
        return $this->belongsTo(ReceiveProduct::class, 'receive_product_id');
    }
}
