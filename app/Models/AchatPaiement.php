<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AchatPaiement extends Model
{
    protected $table = "achat_paiements";
    protected $guarded = [];
    use SoftDeletes , LogsActivity , HasFactory;

    // protected static $logAttributes = ['cheque'];


    /**
     * Get all of the cheques for the AchatPaiement
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cheque(): HasOne
    {
        return $this->hasOne(AchatCheque::class);
    }

    /**
     * Get the founrnisseur that owns the AchatPaiement
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fournisseur(): BelongsTo
    {
        return $this->belongsTo(Fournisseur::class, 'fournisseur_id');
    }
    /**
     * Get the founrnisseur that owns the AchatPaiement
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ligne(): BelongsTo
    {
        return $this->belongsTo(LigneAchat::class, 'ligne_achat_id');
    }


    public function getActivitylogOptions(): LogOptions
    {
      return LogOptions::defaults()
        ->useLogName('achat_paiement')
        ->logOnly(["numero_operation",'date_paiement','num','type_paiement','status',"payer","date_paiement"])
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
    }
}
