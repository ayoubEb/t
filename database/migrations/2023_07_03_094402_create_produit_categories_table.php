<?php

use App\Models\Categorie;
use App\Models\Produit;
use App\Models\SousCategorie;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduitCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produit_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Produit::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Categorie::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('produit_categories');
    }
}
