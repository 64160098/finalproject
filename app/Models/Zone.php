<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Zone extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'id',
        'warehouse_id',
        'product_id',
        'name',
        'zone_width',
        'zone_length',
        'zone_height',
        'zone_volume',
        'zone_status',
    ];

    public function warehouse() {
        return $this->belongsTo(Warehouse::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    // เพิ่มความสัมพันธ์กับ EoqropCalculation
    public function eoqropCalculations() {
        return $this->hasMany(EoqropCalculation::class, 'zone_id');
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'product_id' => $this->product_id,
            'warehouse_id' => $this->warehouse_id,
            'zone_status' => $this->zone_status,
        ];
    }
    
}
