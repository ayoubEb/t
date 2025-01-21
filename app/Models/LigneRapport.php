<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LigneRapport extends Model
{
    use HasFactory;
    protected $table = "ligne_rapports";
    protected $guarded = [];
    /**
     * Get all of the rapports for the LigneRapport
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rapports_buy_sell(): HasMany
    {
        return $this->hasMany(Rapport::class, 'ligne_rapport_id', 'id');
    }
    /**
     * Get all of the rapports for the LigneRapport
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rapports(): HasMany
    {
        return $this->hasMany(Rapport::class, 'ligne_rapport_id', 'id');
    }
}
