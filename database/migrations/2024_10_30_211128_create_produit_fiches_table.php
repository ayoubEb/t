<?php

use App\Models\Produit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduitFichesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produit_fiches', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Produit::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string("title")->nullable();
            $table->text("description")->nullable();
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
        Schema::dropIfExists('produit_fiches');
    }
}
