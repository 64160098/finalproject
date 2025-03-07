<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class ProductSaleReport extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'products_sales',
        'employee_id',
        'total_sales',
    ];

    public function product() {
        return $this->hasMany(Product::class, 'product_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(EmployeeInformation::class, 'employee_id');
    }

    protected $casts = [
        'products_sales' => 'array', // แปลง JSON เป็น Array
    ];

    public function toSearchableArray()
    {
        return [
            'transaction_date' => $this->transaction_date,
            'employee_id' => $this->employee_id,
        ];
    }
}
