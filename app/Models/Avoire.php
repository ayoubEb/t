<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Avoire extends Model
{
    use HasFactory;
    protected $table = "avoires";
    protected $guarded = [];
    use SoftDeletes;

    /**
     * Get the facture that owns the FactureRetour
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function facture_produit(): BelongsTo
    {
        return $this->belongsTo(FactureProduit::class, 'facture_produit_id');
    }
    /**
     * Get the facture that owns the FactureRetour
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ligne(): BelongsTo
    {
        return $this->belongsTo(LigneAvoire::class, 'ligne_avoire_id');
    }
}
