<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FactureRetour extends Model
{
    use HasFactory;
    protected $table = "facture_retours";
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
        return $this->belongsTo(LigneFactureRetour::class, 'ligne_facture_retour_id');
    }
    // /**
    //  * Get the facture that owns the FactureRetour
    //  *
    //  * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    //  */
    // public function facture_produit(): BelongsTo
    // {
    //     return $this->belongsTo(FactureProduit::class, 'facture_produit_id');
    // }
}
