<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Caracteristique extends Model
{
  use HasFactory , SoftDeletes , LogsActivity;
  protected $table = "caracteristiques";
  protected $guarded = [];

  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()
        ->useLogName('caractéristique')
        ->logOnly(["nom"])
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
  }
}
