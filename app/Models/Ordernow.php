<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Ordernow extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'id',
        'order_date',
        'supplier_id', 
        'products', // แก้ไขจาก 'order_items' เป็น 'products'
        'employee_id', 
        'total_price', 
    ];    

    protected $primaryKey = 'id';
    public $incrementing = false; // UUID ไม่ใช่แบบ auto-increment
    protected $keyType = 'string'; // ชนิดของ Primary Key

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid(); // กำหนด UUID ใหม่
            }
        });
    }

    protected $casts = [
        'products' => 'array',
    ];

    public function toSearchableArray() {
        return [
            'id' => $this->id,
            'order_date' => $this->order_date,
            'supplier_id' => $this->supplier_id,
            'employee_id' => $this->employee_id,
        ];
    }

    public function supplier()
    {
        return $this->belongsTo(SupplierInformation::class, 'supplier_id');
    }

    public function employee()
    {
        return $this->belongsTo(EmployeeInformation::class, 'employee_id');
    }

    public function receiveProducts()
    {
        return $this->hasMany(ReceiveProduct::class, 'order_id', 'id');
    }

}
