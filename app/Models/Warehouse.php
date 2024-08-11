<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Warehouse extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'id',
        'name',
        'address',
        'warehouse_total_area',
        'warehouse_available_area',
        'warehouse_width',
        'warehouse_length',
        'warehouse_height',
        'warehouse_area_type',
        'status',
    ];

    public function zones() {
        return $this->hasMany(Zone::class);
    }

    public function product() {
        return $this->hasMany(Product::class);
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
        ];
    }
}
