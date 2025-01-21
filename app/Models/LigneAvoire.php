<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class LigneAvoire extends Model
{
    use HasFactory,SoftDeletes , LogsActivity;
    protected $table = "ligne_avoires";
    protected $guarded = [];
    /**
     * Get all of the facture_retour for the LigneFactureRetour
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function avoires(): HasMany
    {
        return $this->hasMany(Avoire::class);
    }

    /**
     * Get the facture that owns the LigneFactureRetour
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function facture(): BelongsTo
    {
        return $this->belongsTo(Facture::class, 'facture_id');
        // Hello bro 
    }

    public function getActivitylogOptions(): LogOptions
    {
      return LogOptions::defaults()
        ->useLogName('ligne_avoire')
        ->logAll()
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
    }
}
