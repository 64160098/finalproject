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
        'id',
        'supplier_name',
        'supplier_customer_name',
        'supplier_product',
        'supplier_contact_number',
        'supplier_email',
    ];

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'supplier_name' => $this->supplier_name,
            'supplier_customer_name' => $this->supplier_customer_name,
            'supplier_product' => $this->supplier_product,
            'supplier_contact_number' => $this->supplier_contact_number,
            'supplier_email' => $this->supplier_email,
        ];
    }

    public function orders()
    {
        return $this->hasMany(Ordernow::class, 'supplier_id');
    }
    
}
