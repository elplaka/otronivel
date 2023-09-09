<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Estudiante;

class EstudianteXT extends Model
{
    use HasFactory;

    protected $table = 'estudiantes_xt';

    protected $primaryKey = ['id_ciclo', 'curp'];

    public $incrementing = false; // Indica que no se usará autoincremento en la clave primaria

    protected $fillable = [
        'id_ciclo',
        'curp'
    ]; 
    
    public function estudiante()
    {
        return Estudiante::where('id_ciclo', $this->id_ciclo)
        ->where('curp', $this->curp)
        ->select('id_ciclo', 'curp')
        ->first();
    }
}
