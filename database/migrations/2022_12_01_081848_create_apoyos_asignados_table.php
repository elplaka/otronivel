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
        Schema::create('apoyos_asignados', function (Blueprint $table) {
            $table->unique(['id_remesa','id_ciclo','id_estudiante'],'apoyos_asignados_pk');
            $table->integer('id_remesa')->unsigned(); 
            $table->integer('id_ciclo');
            $table->bigInteger('id_estudiante')->unsigned();
            $table->bigInteger('monto');
            $table->boolean('entregado')->default(0);
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

            $table->foreign('id_estudiante')
            ->references('id')
            ->on('estudiantes')
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
        Schema::dropIfExists('apoyos_asignados');
    }
};
