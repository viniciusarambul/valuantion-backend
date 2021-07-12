<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigurationValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuration_values', function (Blueprint $table) {
            $table->id();
            $table->string('ativo_livre');
            $table->string('equity');
            $table->string('risco_brasil');
            $table->string('taxa_selic');
            $table->string('beta');
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
        Schema::dropIfExists('configuration_values');
    }
}
