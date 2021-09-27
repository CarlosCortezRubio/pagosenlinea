<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Solicitud;
use App\User;
use App\Http\Requests\RegisterFormRequest;
use App\Http\Requests\Auth\CreatePasswordFormRequest;
use App\Traits\Tables;
use App\Mail\MensajeConfirmacion;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use Hash;

class RegisterController extends Controller
{
    use Tables;

   public function __construct() {
      $this->middleware('guest');
   }

   public function index()
   {
      $tDocumentos=$this->getTables('01','%','S')->where('abre_tabl_det', '<>', 'RUC');

      return view('auth.register', ['tDocumentos'=>$tDocumentos]);
   }

   public function store(Request $request)
   {
      // Valida si ya existe una cuenta de usuario
      $usuario = User::where('tdocumento', $request->get('tipo_docu_sol'))
                     ->where('ndocumento', $request->get('nume_docu_sol'))
                     ->first();

      if ($usuario) {
         return redirect()->route('register')
                ->with('message', 'user_exists')
                ->with('email', $usuario->email);

      } else {
         // Valida si ya existe una solicitud con el mismo documento de identidad
         $solicitud = Solicitud::where('tipo_docu_sol', $request->get('tipo_docu_sol'))
                              ->where('nume_docu_sol', $request->get('nume_docu_sol'))
                              ->first();

         if ($solicitud) {
            // Elimina la solicitud anterior en caso que haya expirado
            if (empty($solicitud->fech_expi_sol) || $solicitud->fech_expi_sol < Carbon::now()) {
               $solicitud->delete();

            } else {
               $this->enviarMensaje($solicitud->mail_soli_sol, $solicitud->link_conf_sol);

               return redirect()->route('register')
                        ->with('message', 'solicitud_exists')
                        ->with('email', $solicitud->mail_soli_sol)
                        ->with('expire', date('H:i', strtotime($solicitud->fech_expi_sol)).' del '.
                                         date('d/m/Y', strtotime($solicitud->fech_expi_sol)));
            }

         } else {
            // Valida si ya existe una solicitud con el mismo correo
            $solicitud = Solicitud::where('mail_soli_sol', $request->get('mail_soli_sol'))
                                    ->first();

            if ($solicitud) {
               return redirect()->route('register')
                        ->with('message', 'email_exists')
                        ->with('email', $solicitud->mail_soli_sol);
            }
         }
      }

      // Registra la solicitud
      $solicitud = new Solicitud;
      $solicitud->tipo_docu_sol = $request->get('tipo_docu_sol');
      $solicitud->nume_docu_sol = $request->get('nume_docu_sol');
      $solicitud->apel_pate_sol = trim(strtoupper($request->get('apel_pate_sol')));
      $solicitud->apel_mate_sol = trim(strtoupper($request->get('apel_mate_sol')));
      $solicitud->nomb_pers_sol = trim(strtoupper($request->get('nomb_pers_sol')));
      $solicitud->telf_celu_sol = $request->get('telf_celu_sol');
      $solicitud->mail_soli_sol = $request->get('mail_soli_sol');
      $enlace = $this->getEnlaceConfirmacion($request->get('tipo_docu_sol'),
                                                $request->get('nume_docu_sol'));
      $solicitud->link_conf_sol = $enlace;
      $solicitud->fech_expi_sol = Carbon::now()->addHour();
      $solicitud->esta_soli_sol = 'P';
      $solicitud->fech_regi_sol = Carbon::now();
      $solicitud->term_regi_aud = $request->getClientIp();
      $solicitud->save();
      $this->enviarMensaje($request->get('mail_soli_sol'), $enlace);

      return redirect()->route('register')
            ->with('message', 'success')
            ->with('expire', date('H:i', strtotime($solicitud->fech_expi_sol)).' del '.
                             date('d/m/Y', strtotime($solicitud->fech_expi_sol)));

   }

   public function getEnlaceConfirmacion($tipoDoc, $numeDoc)
   {
      return URL::temporarySignedRoute('register.credenciales', Carbon::now()->addHour(), [
         't' => $tipoDoc,
         'n' => $numeDoc
      ]);
   }

   public function enviarMensaje($correo, $enlace)
   {
      Mail::to($correo)->send(new MensajeConfirmacion($enlace));
      return 'mensaje enviado';
   }

   public function generarCredenciales(Request $request)
   {
      if ($request) {
         if (!$request->hasValidSignature()) {
            return view('auth.mensaje-expired');
         } else {

            // Valida si ya existe una cuenta de usuario
            $usuario = User::where('tdocumento', $request->get('t'))
                           ->where('ndocumento', $request->get('n'))
                           ->first();

            if ($usuario) {
               return redirect()->route('register')
               ->with('message', 'user_exists')
               ->with('email', $usuario->email);

            } else {
               $solicitud = Solicitud::where('tipo_docu_sol', $request->get('t'))
                                    ->where('nume_docu_sol', $request->get('n'))
                                    ->first();
               return view('auth.createpassword', ['solicitud'=>$solicitud]);
            }
         }
      }
   }

   public function guardarCredenciales(CreatePasswordFormRequest $request){

      $solicitud = Solicitud::where('tipo_docu_sol', $request->get('tipo_docu'))
                                  ->where('nume_docu_sol', $request->get('nume_docu'))
                                  ->first();
      $solicitud->esta_soli_sol = 'C';
      $solicitud->update();

      $email = $solicitud->mail_soli_sol;
      $contrasena = Hash::make($request->get('password'));

      // Crea usuario
      $user = new User;
      $user->tdocumento = $request->get('tipo_docu');
      $user->ndocumento = $request->get('nume_docu');
      $user->email      = $email;
      $user->password   = $contrasena;
      $user->created_at = Carbon::now();
      $user->save();
     
      return view('auth.login');
   }
}
