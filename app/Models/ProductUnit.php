<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class ProductUnit extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'id',
        'unit',
    ];

    public function products() {
        return $this->hasMany(Product::class, 'product_unit_id');
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'unit' => $this->unit,
        ];
    }
}
