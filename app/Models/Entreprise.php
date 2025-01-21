<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Entreprise extends Model
{
    use HasFactory , LogsActivity;
    protected $table='entreprises';
    protected $guarded = [];
    use SoftDeletes;

    public function getActivitylogOptions(): LogOptions
    {
      return LogOptions::defaults()
        ->useLogName('entreprise')
        ->logOnly(["raison_sociale","logo","rc","if","patente","site","cnss","ville","adresse","email" , "code_postal","telephone","fix","description","ice"])
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
    }

}
