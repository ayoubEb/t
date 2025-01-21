<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AchatCheque extends Model
{
    protected $table = "achat_cheques";
    protected $guarded = [];
    use HasFactory , LogsActivity , SoftDeletes;

    /**
     * Get the bank that owns the AchatCheque
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
      return LogOptions::defaults()
        ->useLogName('achat_cheque')
        ->logOnly(["numero",'banque','date_enquisement',"date_cheque"])
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
    }
}
