<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FactureLivraison extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "facture_livraisons";
    protected $guarded = [];
    /**
     * Get the livraison that owns the factureLivraison
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function livraison(): BelongsTo
    {
      return $this->belongsTo(Livraison::class, 'livraison_id', 'id');
    }
    /**
     * Get the livraison that owns the factureLivraison
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function facture(): BelongsTo
    {
      return $this->belongsTo(Facture::class, 'facture_id', 'id');
    }
}
