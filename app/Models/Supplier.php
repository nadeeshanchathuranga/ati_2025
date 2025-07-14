<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'tea_id',
        'register_id',
        'supplier_name',
        'address',
        'phone_number',
        'tea_weight',
        'tea_income',
        'collect_date_time',
        'status',
    ];

     public function tea()
    {
        return $this->belongsTo(Tea::class);
    }

      public function supplierTeaStock()
    {
        return $this->hasMany(SupplierTeaStock::class);
    }


    
}
