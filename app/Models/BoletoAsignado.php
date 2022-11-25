<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Estudiante;

class BoletoAsignado extends Model
{
    use HasFactory;

    protected $table = "boletos_asignados";

    protected $fillable = [
        'id_remesa',
        'id_paquete',
        'id_ciclo',
        'id_estudiante',
        'folio_inicial',
        'folio_final',
        'entregados',
    ]; 

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'id_estudiante');
    }


}
