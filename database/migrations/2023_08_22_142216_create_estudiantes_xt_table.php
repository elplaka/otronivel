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
        Schema::create('estudiantes_xt', function (Blueprint $table) {
            $table->unsignedBigInteger('id_ciclo');
            $table->string('CURP', 18);
            $table->boolean('registrado')->default(false);
            $table->timestamps();
        
            // Definir la llave primaria compuesta
            $table->primary(['id_ciclo', 'CURP']);           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estudiantes_xt');
    }
};
