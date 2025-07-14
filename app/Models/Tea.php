<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tea extends Model
{
   protected $fillable = ['tea_grade', 'buy_price', 'selling_price','date', 'status'];


    // RELATIONSHIP: A tea has many suppliers
    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }
}
