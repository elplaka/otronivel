<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ciclo;
use App\Models\BoletosRemesa;
use App\Models\Escuela;
use App\Models\Estudiante;

class BoletosTanto extends Model
{
    use HasFactory;

    
    protected $table = "boletos_tantos";
    protected $uniqueKey = ['id_remesa', 'cve_escuela'];

    protected $fillable = [
        'id_remesa',
        'cve_escuela',
        'cantidad_folios',
    ]; 
    
    public function boleto_remesa()
    {
        return $this->belongsTo(BoletosRemesa::class, 'id_remesa');
    }

    public function escuela()
    {
        return $this->belongsTo(Escuela::class, 'cve_escuela', 'cve_escuela');
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'cve_escuela', 'cve_escuela');
    }
}
