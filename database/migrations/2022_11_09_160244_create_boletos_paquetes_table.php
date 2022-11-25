<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boletos_paquetes', function (Blueprint $table) {
            $table->unique(['id_paquete','id_ciclo']);
            $table->increments('id_paquete'); 
            $table->integer('id_ciclo');
            $table->bigInteger('folio_inicial');
            $table->bigInteger('folio_final');
            $table->integer('ult_folio_asignado');
            $table->integer('folios_disponibles');
            $table->dropPrimary("id_paquete");
         
            $table->timestamps();

            $table->foreign('id_ciclo')
            ->references('id_ciclo')
            ->on('ciclos')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });

        // DB::statement('ALTER TABLE boletos_paquetes MODIFY id_paquete INTEGER NOT NULL AUTO_INCREMENT');


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boletos_paquetes');
    }
};
