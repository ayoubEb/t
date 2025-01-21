<?php

use App\Models\Client;
use App\Models\Facture;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturePaiementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facture_paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Facture::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Client::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string("numero_operation")->nullable()->unique();
            $table->string("num")->nullable()->unique();
            $table->string("type_paiement")->nullable();
            $table->string("statut")->nullable();
            $table->text("note")->nullable();
            $table->double("payer")->nullable();
            $table->date("date_paiement")->nullable();
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
        Schema::dropIfExists('facture_paiements');
    }
}
