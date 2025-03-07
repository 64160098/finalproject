<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Laravel\Scout\Searchable;

class ReceiveProduct extends Model
{
    use HasFactory;
    use Searchable;

    // ชื่อคอลัมน์ Primary Key
    protected $primaryKey = 'order_id'; // หรือคอลัมน์ที่ถูกต้อง

    protected $fillable = [
        'order_id',
        'products',
        'total_price',
        'received_date',
        'employee_id',
        'supplier_id',
    ];

    protected $casts = [
        'products' => 'array', // การแปลงฟิลด์ products เป็น array
        'received_date' => 'date',
    ];

    public function ordernow()
    {
        return $this->belongsTo(Ordernow::class, 'order_id', 'id');
    }

    public function product() {
        return $this->hasMany(Product::class, 'code', 'id');
    }

    public function inventory() {
        return $this->hasOne(Inventory::class, 'receive_product_id');
    }

    public function supplier()
    {
        return $this->belongsTo(SupplierInformation::class, 'supplier_id');
    }

    public function employee()
    {
        return $this->belongsTo(EmployeeInformation::class, 'employee_id');
    }

    public function toSearchableArray()
    {
        return [
            'order_id' => $this->order_id,
            'received_date' => $this->received_date,
            'supplier_id' => $this->supplier_id,
            'employee_id' => $this->employee_id,
        ];
    }

}
