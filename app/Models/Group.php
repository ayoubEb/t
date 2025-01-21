<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Group extends Model
{
  use HasFactory , SoftDeletes , LogsActivity;
  protected $table   = "groups";
  protected $guarded = [];
  protected $casts = [
    'request_date' => 'datetime:Y-m-d',
];
  /**
   * Get all of the clients for the Group
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function clients(): HasMany
  {
      return $this->hasMany(Client::class, 'group_id', 'id');
  }

  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()
        ->useLogName('groupe')
        ->logAll(["nom" , "remise" , "statut"])
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
  }
}
