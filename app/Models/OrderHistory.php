<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Carbon\Carbon;

class OrderHistory extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'code',
        'product_name',
        'quantity_products_received',
        'unit',
        'cost_unit',
        'total',
        'created_at',
    ];

    public function toSearchableArray()
    {
        return [
            'code' => $this->code,
            'product_name' => $this->product_name,
            'created_at' => $this->created_at ? Carbon::parse($this->created_at)->translatedFormat('d M Y') : null,
        ];
    }

        // ความสัมพันธ์กับ ReceiveProduct
        public function receiveProduct() {
            return $this->belongsTo(ReceiveProduct::class, 'order_id', 'id'); // เปลี่ยน 'order_id' และ 'id' ตามที่เหมาะสม
        }
    
        // ความสัมพันธ์กับ SupplierInformation
        public function supplier() {
            return $this->belongsTo(SupplierInformation::class, 'supplier_id', 'id'); // ถ้ามี supplier_id ใน order history
        }
    
        // ความสัมพันธ์กับ EmployeeInformation
        public function employee() {
            return $this->belongsTo(EmployeeInformation::class, 'employee_id', 'id'); // ถ้ามี employee_id ใน order history
        }
}
