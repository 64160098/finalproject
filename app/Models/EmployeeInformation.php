<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class EmployeeInformation extends Model
{
    use HasFactory;
    use Searchable;

    protected $table = 'employee_information';
    protected $primaryKey = 'id';
    protected $fillable = [
        'employee_firstname', 
        'employee_lastname', 
        'employee_contact_number', 
        'employee_email', 
        'employee_status'
        ];

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'employee_firstname' => $this->employee_firstname,
            'employee_lastname' => $this->employee_lastname,
            'employee_contact_number' => $this->employee_contact_number,
            'employee_email' => $this->employee_email,
            'employee_status' => $this->employee_status,
        ];
    }

    public function orders()
    {
        return $this->hasMany(Ordernow::class, 'employee_id');
    }

    public function productsalereport() {
        return $this->hasMany(ProductSaleReport::class, 'employee_id');
    }

    public function inventoryreport() {
        return $this->hasMany(InventoryReport::class, 'employee_id');
    }

    public function admininventoryreport() {
        return $this->hasMany(AdminInventoryReport::class, 'employee_id');
    }

    public function dailysale() {
        return $this->hasMany(DailySale::class, 'employee_id');
    }
}
