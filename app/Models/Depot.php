<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Depot extends Model
{
  use HasFactory,SoftDeletes,LogsActivity;
  protected $table = "depots";
  protected $guarded = [];
  /**
   * Get all of the suivi for the Depot
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function stockDepot(): HasMany
  {
      return $this->hasMany(StockDepot::class, 'depot_id', 'id');
  }

  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()
        ->useLogName('depot')
        ->logAll(["num_depot", "adresse" , "quantite","disponible","entre","sortie"])
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
  }
}
