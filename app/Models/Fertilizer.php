<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fertilizer extends Model
{
    protected $fillable = ['name', 'stock', 'price', 'date', 'status'];


}
