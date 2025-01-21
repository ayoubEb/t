<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Client extends Model
{
    use HasFactory , LogsActivity;
    protected $table="clients";
    protected $guarded = [];
    use SoftDeletes;
    /**
     * Get all of the comments for the Client
       *
       * @return \Illuminate\Database\Eloquent\Relations\HasMany
       */
      public function factures()
      {
          return $this->hasMany(Facture::class);
      }

      public function group()
      {
        return $this->belongsTo(Group::class, 'group_id');
      }

      public function getActivitylogOptions(): LogOptions
      {
        return LogOptions::defaults()
          ->useLogName('client')
          ->logOnly(["identifiant","raison_sociale","group_id","responsable","adresse","ville","type_client","email","ice","if_client","rc","telephone","code_postal","activite","montant","payer","reste","montant_devis","maxMontantPayer"])
          ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
      }

}
