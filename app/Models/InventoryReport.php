<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class InventoryReport extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'inventory_report_data',
        'employee_id ',
        'total_inventory_value',
        'transaction_date',
    ];

    public function product() {
        return $this->hasMany(Product::class, 'product_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(EmployeeInformation::class, 'employee_id');
    }

    protected $casts = [
        'inventory_report_data' => 'array', // แปลง JSON เป็น Array
    ];

    public function toSearchableArray()
    {
        return [
            'transaction_date' => $this->transaction_date,
            'employee_id' => $this->employee_id,
        ];
    }
}
