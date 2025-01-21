<?php

use App\Models\AchatPaiement;
use App\Models\Bank;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAchatChequesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achat_cheques', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(AchatPaiement::class)->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string("numero")->nullable();
            $table->string("banque")->nullable();
            $table->date("date_enquisement")->nullable();
            $table->date("date_cheque")->nullable();
            $table->datetime("deleted_at")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('achat_cheques');
    }
}
