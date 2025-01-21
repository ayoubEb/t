<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Produit extends Model
{
    use HasFactory,LogsActivity;
    protected $table = "produits";
    protected $guarded = [];
    use SoftDeletes;

    /**
     * The categories that belong to the Produit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Categorie::class, 'produit_categories', 'produit_id', 'categorie_id')
        ->withPivot(['deleted_at'])
        ->wherePivot('deleted_at', NULL);
    }

    /**
     * The categories that belong to the Produit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sous_categories(): BelongsToMany
    {
        return $this->belongsToMany(SousCategorie::class, 'produit_sous_categories', 'produit_id', 'sous_categorie_id')
        ->withPivot(['deleted_at'])
        ->wherePivot('deleted_at', NULL);
    }


    /**
     * The roles that belong to the Produit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attributs(): BelongsToMany
    {
        return $this->belongsToMany(Caracteristique::class, 'produit_caracteristiques', 'produit_id', 'caracteristique_id')
        ->withPivot(["valeur","prix_achat","prix_vente","quantite","deleted_at","id as pro_cat_id"])
        ->wherePivot('deleted_at', NULL);
    }
    /**
     * Get all of the caracteristiques for the Produit
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function achats(): HasMany
    {
        return $this->hasMany(Achat::class);
    }
    /**
     * Get all of the caracteristiques for the Produit
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ventes(): HasMany
    {
        return $this->hasMany(FactureProduit::class);
    }
    /**
     * Get all of the caracteristiques for the Produit
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fiches(): HasMany
    {
        return $this->hasMany(ProduitFiche::class);
    }

    /**
     * Get the stock associated with the Produit
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function stock(): HasOne
    {
        return $this->hasOne(Stock::class, 'produit_id', 'id');
    }


    public function getActivitylogOptions(): LogOptions
    {
      return LogOptions::defaults()
          ->useLogName('produit')
          ->logOnly(["reference" , "designation" , "prix_vente","prix_achat","prix_revient","etat_stock","description","quantite","image"])
          ->setDescriptionForEvent(fn(string $eventName) => "opération : {$eventName}");
    }
  }

