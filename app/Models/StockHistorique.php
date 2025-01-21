<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockHistorique extends Model
{
    use HasFactory;
    protected $table = "stock_historiques";
    protected $guarded = [];
    use SoftDeletes;
    /**
     * Get the stock that owns the StockHistorique
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class, 'stock_id');
    }
}
