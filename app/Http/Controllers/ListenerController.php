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

            $proceso = '00002'; //proceso vigente
			
			$solicitud = Solicitud_Admision::where('codi_oper_sol', $body['data']['cip'])
            ->where('tipo_docu_sol', $pago->tipo_docu_mov)
            ->where('nume_docu_sol', $pago->nume_docu_mov)
			->where('codi_proc_adm', $proceso)
            ->first();
            if ($solicitud) { 
               $solicitud->esta_pago_sol = 'P';
               $solicitud->fech_pago_sol = Carbon::now();
               $solicitud->update();

               return $this->generarCredenciales($solicitud->mail_soli_sol, $solicitud->tipo_docu_sol, $solicitud->nume_docu_sol, $solicitud->codi_moda_mod);
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
      return "llegue aqui";
      // Valida si ya existe una cuenta de usuario
      $usuario = User::where('tdocumento', $tipodocu)
                     ->where('ndocumento', $numedocu)
                     ->first();
	
	  $contrasena = str_random(8);
	  
      if ($usuario) {
		 // Actualiza datos
		 $user->password = Hash::make($contrasena);
		 $user->email    = $email;
		 $user->update();
		 
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

     // $enlace = config('app.url_admision');

      if($modalidad == 'E'){
        $this->enviarMensajeExonerado($email);
      } else {
     //   $this->enviarMensaje($enlace, $email, $contrasena);
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

   public function apiRestRecibo(Request $request)
   {
      $param1 = $request->get('param1');
      $controller = new ReciboController();
           
      $response = $controller->reciboPostulante($param1);
      
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
