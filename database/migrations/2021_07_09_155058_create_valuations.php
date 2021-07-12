<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValuations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valuations', function (Blueprint $table) {
            $table->id();
            $table->string('nome_pessoa');
            $table->string('nome_empresa');
            $table->string('email');
            $table->string('receita_atual');
            $table->string('projecao_receita');
            $table->string('receita_ano_1');
            $table->string('receita_ano_2');
            $table->string('receita_ano_3');
            $table->string('receita_ano_4');
            $table->string('receita_ano_5');
            $table->string('custos_diretos');
            $table->string('custos_fixos');
            $table->string('ebitda_atual')->nullable();
            $table->string('ebitda_ano_1')->nullable();
            $table->string('ebitda_ano_2')->nullable();
            $table->string('ebitda_ano_3')->nullable();
            $table->string('ebitda_ano_4')->nullable();
            $table->string('ebitda_ano_5')->nullable();
            $table->string('perpetuidade_ano_1')->nullable();
            $table->string('perpetuidade_ano_2')->nullable();
            $table->string('perpetuidade_ano_3')->nullable();
            $table->string('perpetuidade_ano_4')->nullable();
            $table->string('perpetuidade_ano_5')->nullable();
            $table->string('perpetuidade_final')->nullable();
            $table->string('margem_ebitda')->nullable();
            $table->string('resultado')->nullable();
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
        Schema::dropIfExists('valuations');
    }
}
