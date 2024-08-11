<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Carbon\Carbon;

class OrderList extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'code', 'product_name', 'quantity_products_order', 'unit', 'cost_unit', 'total', 'created_at'
    ];

    public function toSearchableArray()
    {
        return [
            'code' => $this->code,
            'product_name' => $this->product_name,
            'created_at' => $this->created_at ? Carbon::parse($this->created_at)->translatedFormat('d M Y') : null,
        ];
    }
}
