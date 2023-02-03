<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Localidad;
use App\Models\DatoSocioeconomico;
use App\Models\Escuela;
use App\Models\Ciudad;
use App\Models\StatusEstudiante;
use App\Models\BoletoAsignado;

class Estudiante extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'primer_apellido',     
        'segundo_apellido',   
        'curp', 
        'rfc',
        'fecha_nac',               
        'celular',            
        'email',               
        'cve_localidad_origen',
        'cve_localidad_actual',
        'cve_ciudad_escuela', 
        'cve_escuela',        
        'cve_turno_escuela',  
        'carrera',             
        'ano_escolar',         
        'promedio',            
        'img_curp',            
        'img_acta_nac',        
        'img_comprobante_dom', 
        'img_identificacion',  
        'img_kardex',
        'img_constancia',
        'cve_status'
    ];  


    public function socioeconomico()
    {
        return $this->hasOne(DatoSocioeconomico::class, 'id_estudiante');
    }

    public function localidad_origen()
    {
        return $this->belongsTo(Localidad::class, 'cve_localidad_origen');
    }

    public function localidad_actual()
    {
        return $this->belongsTo(Localidad::class, 'cve_localidad_actual');
    }

    public function escuela()
    {
        return $this->belongsTo(Escuela::class, 'cve_escuela');
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'cve_ciudad_escuela');
    }

    public function turno()
    {
        return $this->belongsTo(Turno::class, 'cve_turno_escuela');
    }

    public function status()
    {
        return $this->belongsTo(StatusEstudiante::class, 'cve_status');
    }

    public function boletos_asignados()
    {
        return $this->hasMany(BoletoAsignado::class, 'id_estudiante');
    }

}
