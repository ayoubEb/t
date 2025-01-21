<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProduitCategorie extends Model
{
    use HasFactory;
    protected $table = "produit_categories";
    protected $guarded = [];
    use SoftDeletes;
    /**
     * Get the categorie that owns the ProduitCategorie
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }
    /**
     * Get the categorie that owns the ProduitCategorie
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sous_categorie(): BelongsTo
    {
        return $this->belongsTo(SousCategorie::class, 'categorie_id');
    }
}
