<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Estudiante;
use App\Models\Ciclo;
use App\Models\BoletosRemesa;
use App\Models\BoletosPaquete;

class BoletoAsignado extends Model
{
    use HasFactory;

    protected $table = "boletos_asignados";

    protected $fillable = [
        'id_remesa',
        'id_paquete',
        'id_partida',
        'id_estudiante',
        'folio_inicial',
        'folio_final',
        'entregados',
    ]; 

    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class);
    }

    public function boleto_remesa()
    {
        return $this->belongsTo(BoletosRemesa::class, 'id_remesa');
    }

    public function boleto_paquete()
    {
        return $this->belongsTo(BoletosPaquete::class, 'id_paquete');
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'id_estudiante', 'id');
    }

}
