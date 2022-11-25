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
        Schema::create('boletos_remesas', function (Blueprint $table) {
            $table->unique(['id_remesa','id_ciclo']);
            $table->increments('id_remesa'); 
            $table->integer('id_ciclo');
            $table->date('fecha');
            $table->string('descripcion', 50);
            $table->boolean('realizada')->default(0);
            $table->dropPrimary("id_remesa");
            $table->timestamps();

            $table->foreign('id_ciclo')
            ->references('id_ciclo')
            ->on('ciclos')
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
        Schema::dropIfExists('boletos_remesas');
    }
};
