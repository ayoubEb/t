<?php

use App\Models\LigneRapport;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRapportCrmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('rapport_crms', function (Blueprint $table) {
        $table->id();
        $table->foreignIdFor(LigneRapport::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
        $table->string("identifiant")->nullable();
        $table->string("name")->nullable();
        $table->date("jour")->nullable();
        $table->double("montant")->default(0);
        $table->double("payer")->default(0);
        $table->double("reste")->default(0);
        $table->enum("affecter",["fournisseur","client"])->nullable();
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
        Schema::dropIfExists('rapport_crms');
    }
}
