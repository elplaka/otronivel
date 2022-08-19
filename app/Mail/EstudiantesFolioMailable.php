<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Estudiante;
use App\Models\DatoSocioeconomico;

class EstudiantesFolioMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "INFORMACIÓN PARA LA ACTUALIZACIÓN DE REGISTRO :: ALIVIAN4TE";
    public $id_estudiante;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id_estudiante = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $id_estudiante = $this->id_estudiante;
        $estudiante = Estudiante::where('id', $id_estudiante)->first();
        return $this->view('estudiantes.confirmacion_folio', compact('estudiante'));
    }
}
