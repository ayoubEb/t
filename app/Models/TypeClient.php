<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TypeClient extends Model
{

  use HasFactory, LogsActivity , SoftDeletes;
  protected $table   = "type_clients";
  protected $guarded = [];
  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()
      ->useLogName('type_client')
      ->logAll(["nom","statut"])
      ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
  }
}
