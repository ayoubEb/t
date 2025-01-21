<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;

// use Spatie\Activitylog\Traits\LogsActivity;

class LigneAchat extends Model
{
    protected $table = "ligne_achats";
    protected $guarded = [];
    use HasFactory,SoftDeletes,LogsActivity;
    /**
     * Get all of the achats for the LigneAchat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function achats(): HasMany
    {
        return $this->hasMany(Achat::class);
    }

    /**
     * Get the fournisseur that owns the LigneAchat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fournisseur(): BelongsTo
    {
        return $this->belongsTo(Fournisseur::class, 'fournisseur_id')->withTrashed();
    }

    /**
     * Get the fournisseur that owns the LigneAchat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entreprise(): BelongsTo
    {
        return $this->belongsTo(Entreprise::class, 'entreprise_id');
    }

    /**
     * Get all of the paiements for the LigneAchat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paiements(): HasMany
    {
        return $this->hasMany(AchatPaiement::class);
    }


    public function getActivitylogOptions(): LogOptions
    {
      return LogOptions::defaults()
        ->useLogName('ligne_achat')
        ->logOnly(["num_achat",'status','ht','ttc','net_payer',"taux_tva","nombre_achats","date_achat","dateCreation","payer","mt_tva","reste","mois"])
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
    }
}
