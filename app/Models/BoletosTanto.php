<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ciclo;
use App\Models\BoletosRemesa;
use App\Models\Escuela;

class BoletosTanto extends Model
{
    use HasFactory;

    
    protected $table = "boletos_tantos";
    //protected $primaryKey = 'id_remesa';
    protected $uniqueKey = ['id_remesa', 'id_ciclo', 'cve_escuela'];

    protected $fillable = [
        'id_remesa',
        'id_ciclo',
        'cve_escuela',
        'cantidad_folios',
    ]; 
    
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
