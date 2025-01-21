<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ConditionPaiement extends Model
{
    use HasFactory,SoftDeletes, LogsActivity;
    protected $table = "condition_paiements";
    protected $guarded = [];

  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()
      ->useLogName('condition_paiement')
      ->logAll()
      ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
  }
}
