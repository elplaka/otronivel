<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BoletosPaquete;
use App\Models\BoletosRemesa;
use App\Models\BoletosTanto;


class Ciclo extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_ciclo';

    public function boletos_paquetes()
    {
        return $this->hasMany(BoletosPaquete::class);
    }    
    
    public function boletos_remesas()
    {
        return $this->hasMany(BoletosRemesa::class);
    }

    public function boletos_tantos()
    {
        return $this->hasMany(BoletosTanto::class);
    }

    
}
