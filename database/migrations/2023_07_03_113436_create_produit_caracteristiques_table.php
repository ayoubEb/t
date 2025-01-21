<?php

use App\Models\Caracteristique;
use App\Models\Produit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduitCaracteristiquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produit_caracteristiques', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Produit::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Caracteristique::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string("valeur")->nullable();
            $table->integer("quantite")->default(0);
            $table->double("prix_achat")->nullable();
            $table->double("prix_vente")->nullable();
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
        Schema::dropIfExists('produit_caracteristiques');
    }
}
