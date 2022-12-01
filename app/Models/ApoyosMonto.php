<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ciclo;
use App\Models\BoletosRemesa;
use App\Models\Escuela;
use App\Models\Ciudad;

class ApoyosMonto extends Model
{
    use HasFactory;

    protected $table = "apoyos_montos";
    protected $uniqueKey = ['id_remesa', 'id_ciclo', 'cve_ciudad_escuela', 'cve_escuela'];

    protected $fillable = [
        'id_remesa',
        'id_ciclo',
        'cve_ciudad_escuela',
        'cve_escuela',
        'monto',
    ]; 
    
    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class);
    }

    public function boleto_remesa()
    {
        return $this->belongsTo(BoletosRemesa::class, 'id_remesa');
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'cve_ciudad');
    }

    public function escuela()
    {
        return $this->belongsTo(Escuela::class, 'cve_escuela');
    }
}
