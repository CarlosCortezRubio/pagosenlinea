<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use App\Models\Solicitud_Admision;
use App\Models\Pago;
use App\User;
use App\Mail\MensajeCredenciales;
use App\Mail\MensajeExonerado;
use App\Mail\MensajeRecibo;
use Carbon\Carbon;
use App\Http\Controllers\ReciboController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

// use hash_hmac;

class ListenerController extends Controller
{
   public function __construct() {
      $this->middleware('guest');
   }

   public function orbisNotification(Request $request)
   {
      $secretKey = config('app.ORBIS_SecretKey');
      $sigExternal = $request->headers->get('PE-Signature');
      $body = $request->all();
      $textBody ='{"eventType":"'.$body['eventType'].'","operationNumber":"'.$body['operationNumber'].'","data":{"cip":"'.$body['data']['cip'].'","currency":"'.$body['data']['currency'].'","amount":'.number_format($body['data']['amount'],2,".","").'}}';
	   $sig = hash_hmac('sha256', $textBody, $secretKey);

      if ($sig == $sigExternal) {
         // $pago = Pago::where('codi_movi_mov', $body['operationNumber'])
         //    ->where('codi_oper_mov', $body['data']['cip'])
         //    ->first();
         $pago = Pago::where('codi_oper_mov', $body['data']['cip'])
            ->first();
         if ($pago) {    
            $pago->esta_movi_mov = 'PA';
            $pago->fech_pago_mov = Carbon::now();
            $pago->codi_pago_mov = $body['operationNumber'];
            $pago->update();

            $proceso = DB::table("ad_proceso")->where("esta_proc_adm",'V')->first()->codi_proc_adm; //proceso vigente
			
            $solicitud = Solicitud_Admision::where('codi_oper_sol', $body['data']['cip'])
               ->where('tipo_docu_sol', $pago->tipo_docu_mov)
               ->where('nume_docu_sol', $pago->nume_docu_mov)
            ->where('codi_proc_adm', $proceso)
               ->first();
               $postulacion = DB::table("bdsigunm.ad_postulacion")
                           ->where("tipo_docu_per",$pago->tipo_docu_mov)
                           ->where("nume_docu_per",$pago->nume_docu_mov)
                           ->where("codi_proc_adm",$proceso)->first();
            if ($solicitud) { 
               //2022
               Log::info($postulacion->codi_post_pos);
               //return $postulacion->codi_post_pos;
               $reciboesponse=$this->apiRestRecibo($postulacion->codi_post_pos)->getStatusCode();
               return $reciboesponse;
               if ($reciboesponse=="200") {
                  $this->generarCredenciales($solicitud->mail_soli_sol, $solicitud->tipo_docu_sol, $solicitud->nume_docu_sol, $solicitud->codi_moda_mod);
               }else {
                  return response()->json(['error' => 'Invalid data'], $reciboesponse);
               }
               //
               $solicitud->esta_pago_sol = 'P';
               $solicitud->fech_pago_sol = Carbon::now();
               $solicitud->update();
               
            }
            
            return response()->json(['message' => 'Successful notification' ], 200);
         }

         return response()->json(['error' => 'Invalid data'], 400);
         
      } else {
         // Si falla devolvemos el mensaje de error
         // return response()->json(['error' => 'Invalid data','key' => $sig , 'textBody' => $textBody, 'sigExt' => $sigExternal ], 400);
		 return response()->json(['key' => $sig, 'sigExt' => $sigExternal], 400);
		 
         //return response()->json(['error' => 'Invalid data'], 400);
      }
   }

   public function generarCredenciales($email, $tipodocu, $numedocu, $modalidad)
   {
     
      // Valida si ya existe una cuenta de usuario
      $usuario = User::where('tdocumento', $tipodocu)
                     ->where('ndocumento', $numedocu)
                     ->first();
	
	  $contrasena = str_random(8);
     
      if ($usuario) {
		 // Actualiza datos
		 $usuario->password = Hash::make($contrasena);
		 $usuario->email    = $email;
		 $usuario->update();
		 
         //$contrasena = 'user_exists';
         //$email = $usuario->email;
		 
      } else {
         
         // Crea usuario
         $user = new User;
         $user->tdocumento = $tipodocu;
         $user->ndocumento = $numedocu;
         $user->email      = $email;
         $user->password   = Hash::make($contrasena);
         $user->created_at = Carbon::now();
         $user->save();
      }

      $enlace = 'http://admision.unm.edu.pe/login';//config('app.url_admision');

      if($modalidad == 'E'){
        $this->enviarMensajeExonerado($email);
      } else {
       $this->enviarMensaje($enlace, $email, $contrasena);
      }
	  
      return true;
      
   }

   public function enviarMensaje($enlace, $email, $contrasena)
   {
      Mail::to($email)->send(new MensajeCredenciales($enlace, $email, $contrasena));
      return 'mensaje enviado';
   }
   
   public function enviarMensajeExonerado($email)
   {
      Mail::to($email)->send(new MensajeExonerado($email));
      return 'mensaje enviado';
   }

   public function apiRestRecibo($codi_post_pos)//Request $request)
   {
      $param1 = $codi_post_pos;//$request->get('param1');
      $controller = new ReciboController();
           
      $response = $controller->reciboPostulante($param1);
      return $response;
      if($response['ok']){
         $enlace = URL::SignedRoute('viewPDF', ['p1' => $response['corr'], 'p2' => $response['sede']]);
         $this->enviarRecibo($enlace, $response['email']);
      } else {
         return response()->json(['message' => 'Error al generar el recibo','Error' => $response['error']], 500);
      }
           
      return response()->json(['message' => 'Generated receipt'], 200);
   }

   public function enviarRecibo($enlace, $email)
   {
      Mail::to($email)->send(new MensajeRecibo($enlace));
      return 'mensaje enviado';
   }

}
