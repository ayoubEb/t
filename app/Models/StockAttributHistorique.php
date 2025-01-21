<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockAttributHistorique extends Model
{
    use HasFactory;
    protected $table   = "stock_attribut_historiques";
    protected $guarded = [];
}
