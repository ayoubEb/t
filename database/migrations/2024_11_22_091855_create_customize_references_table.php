<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomizeReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customize_references', function (Blueprint $table) {
            $table->id();
            $table->string('champ')->nullable();
            $table->string("valeur")->nullable();
            $table->boolean("check_exists")->nullable();
            $table->string("affecter")->nullable();
            $table->string("operation")->nullable();
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
        Schema::dropIfExists('customize_references');
    }
}
