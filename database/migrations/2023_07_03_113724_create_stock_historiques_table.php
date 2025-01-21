<?php

use App\Models\Stock;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockHistoriquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_historiques', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Stock::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string("fonction")->nullable();
            $table->integer("quantite")->nullable();
            $table->date("date_mouvement")->nullable();
            $table->datetime("deleted_at")->nullable();
            $table->string("description")->nullable();
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
        Schema::dropIfExists('stock_historiques');
    }
}
