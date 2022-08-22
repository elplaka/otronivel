<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Mail;
use App\Mail\EstudiantesMailable;
use App\Mail\EstudiantesFolioMailable;
use App\Models\Estudiante;
use App\Http\Middleware\ChecaTipoUsuario;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/estudiantes/formulario1', [EstudianteController::class, 'formulario1'])->name('estudiantes.formulario1');
    Route::post('/estudiantes/formulario1', [EstudianteController::class, 'formulario1Post'])->name('estudiantes.formulario1.post');    
});

Route::get('/estudiantes/forget', [EstudianteController::class, 'forget'])->name('estudiantes.forget');

Route::get('/', function () {
    return redirect()->route('estudiantes.forget');
});



Route::get('/estudiantes/formulario2', [EstudianteController::class, 'formulario2'])->name('estudiantes.formulario2');
Route::post('/estudiantes/formulario2', [EstudianteController::class, 'formulario2Post'])->name('estudiantes.formulario2.post');

Route::get('/estudiantes/formulario3', [EstudianteController::class, 'formulario3'])->name('estudiantes.formulario3');
Route::post('/estudiantes/formulario3', [EstudianteController::class, 'formulario3Post'])->name('estudiantes.formulario3.post');

Route::get('/estudiantes/formulario4', [EstudianteController::class, 'formulario4'])->name('estudiantes.formulario4');
Route::post('/estudiantes/formulario4', [EstudianteController::class, 'formulario4Post'])->name('estudiantes.formulario4.post');

Route::get('/estudiantes/formulario-final/{id_hex}', [EstudianteController::class, 'formulario_final'])->name('estudiantes.formulario_final');
Route::post('/estudiantes/formulario-final', [EstudianteController::class, 'formulario_final_post'])->name('estudiantes.formulario_final.post');

// Route::get('/estudiantes/formulario_enviado', [EstudianteController::class, 'formulario_enviado'])->name('estudiantes.formulario_enviado');

Route::get('/estudiantes/folios_enviados/{folios}', [EstudianteController::class, 'folios_enviados'])->name('estudiantes.folios_enviados');

Route::get('/estudiantes/registro_pdf/', [EstudianteController::class, 'registro_pdf'])->name('estudiantes.registro_pdf');
Route::get('/estudiantes/registro_pdf/{id_hex}', [EstudianteController::class, 'registro_pdf_post'])->name('estudiantes.registro_pdf_post');

Route::get('/registro/{id_hex}', [EstudianteController::class, 'registro'])->name('estudiantes.registro');

Route::get('/estudiantes/mail_confirmacion/{id_estudiante}', function($id_estudiante){
    $correo = new EstudiantesMailable($id_estudiante);

    $estudiante = Estudiante::where('id', $id_estudiante)->first();
    if($estudiante->count() > 0)
    {
        $email = $estudiante->email;
        Mail::to($email)->send($correo);
        return redirect()->route('estudiantes.formulario_enviado');
    }
    else return view('estudiantes/operacion_invalida');
})->name('estudiantes.mail_confirmacion');

// Route::get('/estudiantes/mail_folio/', function(){
//     //$estudiantes = Estudiante::all();

//     $estudiantes = Estudiante::whereBetween('id', [1,4])->get();

//     //dd($estudiantes);
//     $folios = '';

//     foreach ($estudiantes as $estudiante)
//     {
//         $id_estudiante = $estudiante->id;
//         $correo = new EstudiantesFolioMailable($id_estudiante);
//         $estudiante = Estudiante::where('id', $id_estudiante)->first();
//         if($estudiante->count() > 0)
//         {
//             $email = $estudiante->email;
//             Mail::to($email)->send($correo);
//             $folios = $folios . ',' . $email;
//         }
//     }
//     return redirect()->route('estudiantes.folios_enviados', $folios);
// })->name('estudiantes.mail_folio');

Route::get('/estudiantes/index', [EstudianteController::class, 'index'])->name('estudiantes.index');
Route::get('/estudiantes/edit/{id}', [EstudianteController::class, 'edit'])->name('estudiantes.edit');
Route::post('/estudiantes/update/{id}', [EstudianteController::class, 'update'])->name('estudiantes.update');
Route::get('/estudiantes/edit_status/{id}', [EstudianteController::class, 'edit_status'])->name('estudiantes.edit_status');
Route::post('/estudiantes/update_status/{id}', [EstudianteController::class, 'update_status'])->name('estudiantes.update_status');
Route::get('/estudiantes/edit_se/{id}', [EstudianteController::class, 'edit_socioeconomicos'])->name('estudiantes.edit_se');
Route::post('/estudiantes/censar/{id}', [EstudianteController::class, 'censar'])->name('estudiantes.censar');
Route::get('/estudiantes/reporte_pdf/', [EstudianteController::class, 'pdf'])->name('estudiantes.pdf');

Route::resource('usuarios', UsuarioController::class);

// Route::get('/estudiantes', function () {
// })->middleware(ChecaTipoUsuario::class);

// Route::post('/estudiantes', [App\Http\Controllers\EstudianteController::class, 'store'])->name('estudiantes.store');

// Route::get('/estudiantes/createStep1', [App\Http\Controllers\EstudianteController::class, 'createStep1'])->name('estudiantes.createStep1');
// Route::post('/estudiantes/createStep1', [App\Http\Controllers\EstudianteController::class, 'postCreateStep1'])->name('estudiantes.postCreateStep1');
