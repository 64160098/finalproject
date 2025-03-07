<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Carbon\Carbon;

class DailySale extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'total_earning',
        'Scan_to_pay',
        'cash',
        'sale_date',
        'reporter_name',
    ];

    public function toSearchableArray()
    {
        return [
            'sale_date' => $this->sale_date ? Carbon::parse($this->sale_date)->translatedFormat('d M Y') : null,
            'employee_id' => $this->reporter_name,
        ];
    }

    public function employee()
    {
        return $this->belongsTo(EmployeeInformation::class, 'employee_id');
    }
}
