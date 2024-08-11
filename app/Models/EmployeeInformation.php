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
    protected $fillable = ['employee_id', 
        'firstname', 
        'lastname', 
        'contact_number', 
        'email', 'status', 
        'image' => 'default_value',
        ];

    public function toSearchableArray()
    {
        return [
            'employee_id' => $this->employee_id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'contact_number' => $this->contact_number,
            'status' => $this->status,
        ];
    }
}
