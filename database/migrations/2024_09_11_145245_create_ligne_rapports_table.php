<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLigneRapportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ligne_rapports', function (Blueprint $table) {
            $table->id();
            $table->string("num")->nullable();
            $table->double("montant_vente")->default(0);
            $table->double("payer_vente")->default(0);
            $table->double("reste_vente")->default(0);
            $table->double("montant_achat")->default(0);
            $table->double("payer_achat")->default(0);
            $table->double("reste_achat")->default(0);
            $table->string("mois")->nullable();
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
        Schema::dropIfExists('ligne_rapports');
    }
}
