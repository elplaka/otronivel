<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Estudiante;
use App\Models\BoletosPaquete;
use App\Models\BoletosRemesa;
use App\Models\BoletosTanto;


class Ciclo extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_ciclo';

    public function estudiantes()
    {
        return $this->hasMany(EStudiante::class);
    } 

    public function paquetes()
    {
        return $this->hasMany(BoletosPaquete::class);
    }    
    
    public function remesas()
    {
        return $this->hasMany(BoletosRemesa::class);
    }

    public function tantos()
    {
        return $this->hasMany(BoletosTanto::class);
    }

    
}
