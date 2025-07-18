<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tea extends Model
{
   protected $fillable = ['tea_grade', 'buy_price', 'selling_price','date','total_weight', 'status'];


    // RELATIONSHIP: A tea has many suppliers
    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }


    public function reduceStock($amount)
{
    $amount = round($amount, 2);
    $this->total_weight = round($this->total_weight - $amount, 2);

    if ($this->total_weight < 0) {
        throw new \Exception("Tea stock can't go below zero.");
    }

    $this->save();
}



}
