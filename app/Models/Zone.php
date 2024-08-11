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

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
        ];
    }
}
