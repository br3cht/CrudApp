<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Cliente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up(){
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome' ,50);
            $table->string('sobrenome', 50);
            $table->string('sexo', 2);
            $table->date('datanascimento');
            $table->string('email', 50)->unique();
            $table->string('telefone', 11)->unique();

            $table->string('cidade', 50);
            $table->string('UF', 3);
            $table->string('endereco', 50);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::drop('clientes');
    }
}
