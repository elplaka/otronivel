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
        Schema::create('boletos_tantos', function (Blueprint $table) {
            $table->unique(['id_remesa', 'id_ciclo','cve_escuela']);
            $table->integer('id_remesa')->unsigned(); 
            $table->integer('id_ciclo');
            $table->integer('cve_escuela')->unsigned();
            $table->integer('cantidad_folios');            
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
        Schema::dropIfExists('boletos_tantos');
    }
};
