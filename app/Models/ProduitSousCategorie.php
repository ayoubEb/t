<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProduitSousCategorie extends Model
{
    use HasFactory;
    protected $table = "produit_sous_categories";
    protected $guarded = [];
    use SoftDeletes;
    /**
     * Get the sous that owns the ProduitSousCategorie
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sous(): BelongsTo
    {
        return $this->belongsTo(SousCategorie::class, 'sous_categorie_id');
    }
}
