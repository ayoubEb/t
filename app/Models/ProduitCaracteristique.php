<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProduitCaracteristique extends Model
{
    use HasFactory;
    protected $table = "produit_caracteristiques";
    protected $guarded = [];
    use SoftDeletes;

    /**
     * Get the produit that owns the ProduitCaracteristique
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

}
