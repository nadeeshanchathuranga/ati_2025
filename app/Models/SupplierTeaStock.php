<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierTeaStock extends Model
{
     protected $table = 'supplier_tea_stock';
    protected $fillable = ['supplier_id', 'tea_weight', 'date'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
