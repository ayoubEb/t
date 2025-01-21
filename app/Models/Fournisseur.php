<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Fournisseur extends Model
{
    use HasFactory;
    protected $table = "fournisseurs";
    protected $guarded = [];
    use SoftDeletes;

    /**
     * Get all of the ligne_achats for the Fournisseur
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ligne_achats(): HasMany
    {
        return $this->hasMany(LigneAchat::class, 'fournisseur_id',);
    }

    /**
     * Get all of the paiements for the Fournisseur
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paiements(): HasMany
    {
        return $this->hasMany(AchatPaiement::class, 'ligne_achat_id', 'id');
    }

}
