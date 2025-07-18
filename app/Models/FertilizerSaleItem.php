<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FertilizerSaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'fertilizer_sale_id',
        'fertilizer_id',
        'quantity_grams',
        'unit_price',
        'line_total',
    ];

    public function sale()
    {
        return $this->belongsTo(FertilizerSale::class, 'fertilizer_sale_id');
    }

    public function fertilizer()
    {
        return $this->belongsTo(Fertilizer::class);
    }
}
