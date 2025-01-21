<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
class Categorie extends Model
{
    use HasFactory , HasRoles , SoftDeletes , LogsActivity;
    protected $table="categories";
    protected $guarded = [];
    // protected $dates = ["deleted_at"];


    /**
     * Get all of the sous_categorie for the Categorie
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sous(): HasMany
    {
      return $this->hasMany(SousCategorie::class);
    }
    // public function produit()
    // {
    //   return $this->hasOne(Produit::class);
    // }

    public function getActivitylogOptions(): LogOptions
    {
      return LogOptions::defaults()
          ->useLogName('categorie')
          ->logAll(["nom","description","image"])
          ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
    }
  }
