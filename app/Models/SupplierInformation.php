<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class SupplierInformation extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'company_name',
        'customer_name',
        'about_product',
        'contact_number',
        'email',
    ];

    public function toSearchableArray()
    {
        return [
            'company_name' => $this->company_name,
            'customer_name' => $this->customer_name,
            'about_product' => $this->about_product,
            'contact_number' => $this->contact_number,
        ];
    }
}
