<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ciclo;

class BoletosPaquete extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_paquete';
    protected $table = "boletos_paquetes";

    protected $fillable = [
        'folio_inicial',
        'folio_final',
        'ult_folio_asignado',
        'folios_disponibles'
    ]; 
    
    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class);
    }
}
