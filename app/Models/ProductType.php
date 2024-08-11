<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class ProductType extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'id',
        'product_type',
    ];

    public function products() {
        return $this->hasMany(Product::class, 'product_type_id');
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'product_type' => $this->product_type,
        ];
    }
}
