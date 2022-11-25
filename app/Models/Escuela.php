<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Estudiante;
use App\Models\BoletosTanto;


class Escuela extends Model
{
    use HasFactory;

    protected $primaryKey = 'cve_escuela';

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class);
    }

    public function boletos_tantos()
    {
        return $this->hasMany(BoletosTanto::class);
    }
}
