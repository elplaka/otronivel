<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
