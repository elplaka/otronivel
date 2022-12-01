<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ciclo;
use App\Models\BoletosRemesa;
use App\Models\Escuela;
use App\Models\Estudiante;


class ApoyoAsignado extends Model
{
    use HasFactory;

    protected $table = "apoyos_asignados";

    protected $fillable = [
        'id_remesa',
        'id_ciclo',
        'id_estudiante',
        'monto',
        'entregados',
    ]; 

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'id_estudiante');
    }

    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class);
    }

    public function boleto_remesa()
    {
        return $this->belongsTo(BoletosRemesa::class, 'id_remesa');
    }

    public function escuela()
    {
        return $this->belongsTo(Escuela::class, 'cve_escuela');
    }

    
}
