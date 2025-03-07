<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Carbon\Carbon;

class AdminInventoryReport extends Model
{
    use HasFactory;
    use Searchable;
    
    public function toSearchableArray()
    {
        return [
            'code' => $this->code,
            'product_name' => $this->product_name,
            'created_at' => $this->created_at ? Carbon::parse($this->created_at)->translatedFormat('d M Y') : null,
        ];
    }

    public function employee()
    {
        return $this->belongsTo(EmployeeInformation::class, 'employee_id');
    }
}
