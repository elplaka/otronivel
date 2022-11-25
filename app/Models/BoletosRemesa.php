<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ciclo;
use App\Models\BoletosTanto;

class BoletosRemesa extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_remesa';
    protected $table = "boletos_remesas";

    protected $fillable = [
        'id_ciclo',
        'fecha',
        'descripcion',
        'realizada',
    ]; 
    
    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class);
    }

    public function boletos_tantos()
    {
        return $this->hasMany(BoletosTanto::class);
    }

    
}
