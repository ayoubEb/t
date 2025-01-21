<?php

use App\Models\Bank;
use App\Models\FacturePaiement;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturePaiementChequesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facture_paiement_cheques', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(FacturePaiement::class)->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Bank::class)->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string("numero")->nullable()->unique();
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
        Schema::dropIfExists('facture_paiement_cheques');
    }
}
