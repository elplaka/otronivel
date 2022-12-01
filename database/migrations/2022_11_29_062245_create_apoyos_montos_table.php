<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apoyos_montos', function (Blueprint $table) {
            $table->unique(['id_remesa', 'id_ciclo', 'cve_ciudad_escuela', 'cve_escuela'], 'apoyos_montos_pk');
            $table->integer('id_remesa')->unsigned(); 
            $table->integer('id_ciclo');
            $table->integer('cve_ciudad_escuela')->unsigned();
            $table->integer('cve_escuela')->unsigned();
            $table->integer('monto');            
            $table->timestamps();
            
            $table->foreign('id_ciclo')
            ->references('id_ciclo')
            ->on('ciclos')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            
            $table->foreign('id_remesa')
            ->references('id_remesa')
            ->on('boletos_remesas')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('cve_ciudad_escuela')
            ->references('cve_ciudad')
            ->on('ciudades')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('cve_escuela')
            ->references('cve_escuela')
            ->on('escuelas')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apoyos_montos');
    }
};
