<?php

use App\Models\LigneAchat;
use App\Models\LigneRapport;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRapportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rapports', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(LigneRapport::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string("raison_sociale")->nullable();
            $table->string("identifiant")->nullable();
            $table->string("reference")->nullable();
            $table->date("jour")->nullable();
            $table->double("net_payer")->nullable();
            $table->double("montant")->nullable();
            $table->double("payer")->nullable();
            $table->double("reste")->nullable();
            $table->string("affecter")->nullable();
            $table->string("status")->nullable();
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
        Schema::dropIfExists('rapports');
    }
}
