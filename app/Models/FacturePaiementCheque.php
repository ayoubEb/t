<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class FacturePaiementCheque extends Model
{
    use HasFactory ,SoftDeletes , LogsActivity;
    protected $table = "facture_paiement_cheques";
    protected $guarded =  [];
    /**
     * Get the paiement that owns the FacturePaiementCheque
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paiement(): BelongsTo
    {
        return $this->belongsTo(FacturePaiement::class, 'facture_paiement_id');
    }
    /**
     * Get the bancaire that owns the FacturePaiementCheque
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }



    public function getActivitylogOptions(): LogOptions
    {
      return LogOptions::defaults()
        ->useLogName('facture_cheque')
        ->logOnly(["numero",'banque','date_enquisement',"date_cheque"])
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
    }


}
