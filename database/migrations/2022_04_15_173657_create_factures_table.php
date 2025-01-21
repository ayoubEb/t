<?php

use App\Models\Client;
use App\Models\Entreprise;
use App\Models\Group;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
  */
  public function up()
  {
    Schema::create('factures', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(Client::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
      $table->foreignIdFor(Entreprise::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
      $table->string('num')->unique()->nullable();
      $table->string('statut')->nullable();
      $table->string('num_devis')->nullable()->unique();
      $table->string('num_preforma')->nullable()->unique();
      $table->string('num_facture')->nullable()->unique();
      $table->double('ht')->default(0);
      $table->double('ttc')->default(0);
      $table->double('ht_tva')->default(0);
      $table->double('taux_tva')->default(0);
      $table->double('remise')->default(0);
      $table->double('remise_ht')->default(0);
      $table->double('remise_ttc')->default(0);
      $table->date('date_facture')->nullable();
      $table->date('dateCreation')->nullable();
      $table->double('payer')->default(0);
      $table->double('reste')->default(0);
      $table->string("mois")->default(0);
      $table->text("commentaire")->nullable();
      $table->double("net_payer")->default(0);
      $table->integer("nbrProduits")->default(0);
      $table->integer("qteProduits")->default(0);
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
    Schema::dropIfExists('factures');
  }
}
