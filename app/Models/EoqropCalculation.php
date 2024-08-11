<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EoqropCalculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'product_id ',
        'warehouse_id ',
        'zone_id ',
        'demand',
        'order_cost',
        'holding_cost',
        'daily_usage_rate',
        'lead_time',
        'eoq',
        'rop',
    ];
}
