<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduitFiche extends Model
{
    use HasFactory;
    protected $table = "produit_fiches";
    protected $guarded = [];
}
