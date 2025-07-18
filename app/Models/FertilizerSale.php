<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FertilizerSale extends Model
{
      use HasFactory;

    protected $fillable = [
        'supplier_id',
        'supplier_income',
        'total_cost',
    ];

    public function items()
    {
        return $this->hasMany(FertilizerSaleItem::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
