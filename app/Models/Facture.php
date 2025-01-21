<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;

class Facture extends Model
{
  use HasFactory;
  protected $table='factures';
  protected $guarded = [];
  use SoftDeletes;



  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()
        ->useLogName('facture')
        ->logOnly([
          "num" ,
          "statut" ,
          "num_devis",
          "num_preforma",
          "ht",
          "ttc",
          "ht_tva",
          "taux_tva",
          "remise",
          "remise_ht",
          "condition_paiements",
          "date_facture",
          "dateCreation",
          "payer",
          "mois",
          "reste",
          "commentaire",
          "etat_retour",
          "net_payer",
          "net_credit",
          "nbrProduits",
          "nbrRertours",
          "qteRetours",
          "qteProduits"
          ])
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
  }


    public function client(){
      return $this->belongsTo(Client::class, 'client_id')->withTrashed();
    }

    /**
     * Get the user associated with the Facture
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function paiements(): HasMany
    {
        return $this->hasMany(FacturePaiement::class, 'facture_id');
    }

    /**
     * Get the user associated with the Facture
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function produits(): HasMany
    {
        return $this->hasMany(FactureProduit::class);
    }


    /**
     * Get the entreprise that owns the Facture
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entreprise(): BelongsTo
    {
        return $this->belongsTo(Entreprise::class, 'entreprise_id');
    }


}
