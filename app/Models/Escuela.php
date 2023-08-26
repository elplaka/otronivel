<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Estudiante;
use App\Models\BoletosTanto;
use App\Models\ApoyosMonto;


// class Escuela extends Model
// {
//     use HasFactory;

//     protected $primaryKey = 'cve_escuela';

//     public function estudiantes()
//     {
//         return $this->hasMany(Estudiante::class);
//     }

//     public function boleto_tanto()
//     {
//         return $this->belongsTo(BoletosTanto::class, 'cve_escuela'); 
//     }
// }

class Escuela extends Model
{
    use HasFactory;

    protected $primaryKey = 'cve_escuela';

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'cve_escuela', 'cve_escuela');
    }

    public function boleto_tanto()
    {
        return $this->hasOne(BoletosTanto::class, 'cve_escuela', 'cve_escuela');
    }

    public function apoyo_monto()
    {
        return $this->hasOne(ApoyosMonto::class, 'cve_escuela', 'cve_escuela');
    }

}



   // public function boletos_tantos()
    // {
    //     return $this->hasMany(BoletosTanto::class);
    // }