<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApoyoController;
use App\Http\Controllers\BoletoController;
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

// Route::middleware(['auth'])->group(function () {
    Route::get('/estudiantes/formulario1', [EstudianteController::class, 'formulario1'])->name('estudiantes.formulario1')->middleware('admin.user');;
    Route::post('/estudiantes/formulario1', [EstudianteController::class, 'formulario1Post'])->name('estudiantes.formulario1.post')->middleware('admin.user');    
// });

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

Route::get('/estudiantes/formulario_enviado', [EstudianteController::class, 'formulario_enviado'])->name('estudiantes.formulario_enviado');

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
Route::get('/estudiantes/edit/{id}', [EstudianteController::class, 'edit'])->name('estudiantes.edit')->middleware('admin.user');
Route::post('/estudiantes/update/{id}', [EstudianteController::class, 'update'])->name('estudiantes.update')->middleware('editor.user');
Route::get('/estudiantes/edit_status/{id}', [EstudianteController::class, 'edit_status'])->name('estudiantes.edit_status')->middleware('editor.user');
Route::post('/estudiantes/update_status/{id}', [EstudianteController::class, 'update_status'])->name('estudiantes.update_status')->middleware('editor.user');
Route::get('/estudiantes/edit_se/{id}', [EstudianteController::class, 'edit_socioeconomicos'])->name('estudiantes.edit_se')->middleware('editor.user');
Route::post('/estudiantes/censar/{id}', [EstudianteController::class, 'censar'])->name('estudiantes.censar')->middleware('editor.user');
Route::get('/estudiantes/reporte_pdf/', [EstudianteController::class, 'pdf'])->name('estudiantes.pdf');
Route::get('/estudiantes/download-zip/{id}', [EstudianteController::class, 'download_zip'])->name('estudiantes.download-zip');

Route::resource('usuarios', UsuarioController::class);

Route::get('/boletos/paquetes-index', [BoletoController::class, 'paquetes_index'])->name('boletos.paquetes-index')->middleware('admin.user');
Route::get('/boletos/paquetes-nuevo', [BoletoController::class, 'paquetes_nuevo'])->name('boletos.paquetes-nuevo')->middleware('admin.user');
Route::post('/boletos/paquetes-crea', [BoletoController::class, 'paquetes_crea'])->name('boletos.paquetes-crea')->middleware('admin.user');
Route::get('/boletos/paquetes-editar/{id}', [BoletoController::class, 'paquetes_editar'])->name('boletos.paquetes-editar')->middleware('admin.user');
Route::post('/boletos/paquetes-actualizar/{id}', [BoletoController::class, 'paquetes_actualizar'])->name('boletos.paquetes-actualizar')->middleware('admin.user');

Route::get('/boletos/remesas-index', [BoletoController::class, 'remesas_index'])->name('boletos.remesas-index')->middleware('admin.user');
Route::get('/boletos/remesas-nuevo', [BoletoController::class, 'remesas_nuevo'])->name('boletos.remesas-nuevo')->middleware('admin.user');
Route::post('/boletos/remesas-crea', [BoletoController::class, 'remesas_crea'])->name('boletos.remesas-crea')->middleware('admin.user');
Route::get('/boletos/remesas-editar/{id}', [BoletoController::class, 'remesas_editar'])->name('boletos.remesas-editar')->middleware('admin.user');
Route::post('/boletos/remesas-actualizar/{id}', [BoletoController::class, 'remesas_actualizar'])->name('boletos.remesas-actualizar')->middleware('admin.user');

Route::get('/boletos/tantos-index', [BoletoController::class, 'tantos_index'])->name('boletos.tantos-index')->middleware('admin.user');
Route::get('/boletos/tantos-nuevos', [BoletoController::class, 'tantos_nuevos'])->name('boletos.tantos-nuevos')->middleware('admin.user');
Route::get('/boletos/tantos-nuevo-uno/{cve_escuela}', [BoletoController::class, 'tantos_nuevo_uno'])->name('boletos.tantos-nuevo-uno')->middleware('admin.user');
Route::post('/boletos/tantos-crea', [BoletoController::class, 'tantos_crea'])->name('boletos.tantos-crea')->middleware('admin.user');
Route::post('/boletos/tantos-crea-uno', [BoletoController::class, 'tantos_crea_uno'])->name('boletos.tantos-crea-uno')->middleware('admin.user');
Route::get('/boletos/tantos-editar/{id_remesa}/{cve_escuela}', [BoletoController::class, 'tantos_editar'])->name('boletos.tantos-editar')->middleware('admin.user');
Route::post('/boletos/tantos-actualizar/{id_remesa}/{cve_escuela}', [BoletoController::class, 'tantos_actualizar'])->name('boletos.tantos-actualizar')->middleware('admin.user');
Route::get('/boletos/asignacion-nueva', [BoletoController::class, 'asignacion_nueva'])->name('boletos.asignacion-nueva')->middleware('responsable.user');
Route::post('/boletos/asignacion-crea/{id_remesa}', [BoletoController::class, 'asignacion_crea'])->name('boletos.asignacion-crea')->middleware('admin.user');
Route::get('/boletos/asignacion-pdf/', [BoletoController::class, 'asignacion_pdf'])->name('boletos.asignacion-pdf')->middleware('responsable.user');
Route::get('/boletos/asignacion-borra/{id_remesa}/{id_estudiante}', [BoletoController::class, 'asignacion_borra'])->name('boletos.asignacion-borra')->middleware('admin.user');
Route::get('/boletos/asignados/{id_remesa}', [BoletoController::class, 'asignados'])->name('boletos.asignados')->middleware('admin.user');

Route::get('/apoyos/montos-index', [ApoyoController::class, 'montos_index'])->name('apoyos.montos-index')->middleware('admin.user');
Route::get('/apoyos/montos-nuevos', [ApoyoController::class, 'montos_nuevos'])->name('apoyos.montos-nuevos')->middleware('admin.user');
Route::get('/apoyos/montos-nuevo-uno/{id_remesa}/{cve_ciudad_escuela}/{cve_escuela}', [ApoyoController::class, 'montos_nuevo_uno'])->name('apoyos.montos-nuevo-uno')->middleware('admin.user');
Route::post('/apoyos/montos-crea-uno', [ApoyoController::class, 'montos_crea_uno'])->name('apoyos.montos-crea-uno');
Route::post('/apoyos/montos-crea', [ApoyoController::class, 'montos_crea'])->name('apoyos.montos-crea')->middleware('admin.user');
Route::get('/apoyos/monto-editar/{id_remesa}/{cve_ciudad_escuela}/{cve_escuela}', [ApoyoController::class, 'monto_editar'])->name('apoyos.monto-editar')->middleware('admin.user');
Route::post('/apoyos/monto-actualizar/{id_remesa}/{cve_ciudad_escuela}/{cve_escuela}', [ApoyoController::class, 'monto_actualizar'])->name('apoyos.monto-actualizar')->middleware('admin.user');
Route::get('/apoyos/asignacion', [ApoyoController::class, 'asignacion'])->name('apoyos.asignacion')->middleware('responsable.user')->middleware('responsable.user');
Route::post('/apoyos/asignacion-crea/{id_remesa}', [ApoyoController::class, 'asignacion_crea'])->name('apoyos.asignacion-crea')->middleware('admin.user');
Route::get('/apoyos/asignacion-borra/{id_remesa}/{id_estudiante}', [ApoyoController::class, 'asignacion_borra'])->name('apoyos.asignacion-borra')->middleware('admin.user');
Route::get('/apoyos/asignacion-pdf/', [ApoyoController::class, 'asignacion_pdf'])->name('apoyos.asignacion-pdf')->middleware('responsable.user');

// Route::get('/estudiantes', function () {
// })->middleware(ChecaTipoUsuario::class);

// Route::post('/estudiantes', [App\Http\Controllers\EstudianteController::class, 'store'])->name('estudiantes.store');

// Route::get('/estudiantes/createStep1', [App\Http\Controllers\EstudianteController::class, 'createStep1'])->name('estudiantes.createStep1');
// Route::post('/estudiantes/createStep1', [App\Http\Controllers\EstudianteController::class, 'postCreateStep1'])->name('estudiantes.postCreateStep1');
