<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
   protected $fillable = ['sales_id', 'tea_id', 'quantity'];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sales_id');
    }

    public function tea()
    {
        return $this->belongsTo(Tea::class);
    }
}
