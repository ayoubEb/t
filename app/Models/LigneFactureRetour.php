<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LigneFactureRetour extends Model
{
    use HasFactory;
    protected $table = "ligne_facture_retours";
    protected $guarded = [];
    /**
     * Get all of the facture_retour for the LigneFactureRetour
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function facture_retours(): HasMany
    {
        return $this->hasMany(FactureRetour::class);
    }

    /**
     * Get the facture that owns the LigneFactureRetour
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function facture(): BelongsTo
    {
        return $this->belongsTo(Facture::class, 'facture_id');
    }
}
