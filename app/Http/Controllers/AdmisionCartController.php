<?php

namespace App\Http\Controllers;

use App\Models\Solicitud_Admision;
use App\Models\Pago;
use App\Models\Pago_Det;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use App\Traits\Tables;
use Carbon\Carbon;
use DB;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class AdmisionCartController extends Controller
{
   use Tables;

   public function __construct() {
      $this->middleware('guest');
   }

   public function apiRest(Request $request)
   {
      $param1 = $request->get('param1');
      $param2 = $request->get('param2');
      $param3 = $request->get('param3');
      $param4 = $request->get('param4');

      $enlace = $this->getEnlaceConfirmacion($param1, $param2, $param3, $param4);

      return response()->json($enlace, 200);
   }

   public function getEnlaceConfirmacion($proceso, $tipoDoc, $numeDoc, $token)
   {
      return URL::SignedRoute('admision', [
         'p1' => $proceso,
         'p2' => $tipoDoc,
         'p3' => $numeDoc,
         'p4' => $token
      ]);
   }

   public function index(Request $request)
   {
      if ($request) {
         if (!$request->hasValidSignature()) {
            return view('pago.signout.mensaje');

         } else {

            $solicitud = Solicitud_Admision::where('codi_proc_adm', $request->get('p1'))
            ->where('tipo_docu_sol', $request->get('p2'))
            ->where('nume_docu_sol', $request->get('p3'))
            ->where('toke_pago_sol', $request->get('p4'))
            ->first();
            // VALIDAR PAGO GENERADO O PAGADO
            if ($solicitud->esta_pago_sol == 'G') {
               return view('partials.view-cip', ['link'=> $solicitud->link_pago_sol]);
               // return redirect()->away($solicitud->link_pago_sol);
            } else if($solicitud->esta_pago_sol == 'P'){
               return view('pago.signout.mensaje');
            }

            $proceso = $this->getProceso('V');

            $key = $solicitud->codi_secc_sec.$solicitud->codi_espe_esp.$proceso->codi_conc_pag;

            $array_cart = ['codi_secc_mov'=>$solicitud->codi_secc_sec,
                           'codi_espe_mov'=>$solicitud->codi_espe_esp,
                           'codi_conc_mov'=>$proceso->codi_conc_pag,
                           'cant_conc_mov'=>'1',
                           'mnto_prec_mov'=>$solicitud->mnto_pago_sol,
                           'mnto_subt_mov'=>$solicitud->mnto_pago_sol,
                           'desc_conc_mov'=>$proceso->concepto->desc_conc_pag,
                           'mail_soli_adm'=>$solicitud->mail_soli_sol,
                           'codi_proc_adm'=>$solicitud->codi_proc_adm,
                           'tipo_docu_sol'=>$solicitud->tipo_docu_sol,
                           'nume_docu_sol'=>$solicitud->nume_docu_sol
                        ];
            if(hasCartSignOut()){
               session()->forget(['cartSignOut']);
            }
            $cart = collect([]);
            $cart->put($key, $array_cart);

            session(['cartSignOut'=> $cart]);

            return view('pago.signout.index');
         }
      }
   }

   public function prepareAccessToken()
   {
	   if (hasCartSignOut() == false) {
		   abort(404, 'Página no encontrada.');
      }
      // VALIDAR PAGO GENERADO O PAGADO
      $solicitud = Solicitud_Admision::where('codi_proc_adm', getCartSignAttribute('codi_proc_adm'))
      ->where('tipo_docu_sol', getCartSignAttribute('tipo_docu_sol'))
      ->where('nume_docu_sol', getCartSignAttribute('nume_docu_sol'))
      ->first();
      if ($solicitud) {
         if ($solicitud->esta_pago_sol == 'G') {
            return view('partials.view-cip', ['link'=> $solicitud->link_pago_sol]);
            // return redirect()->away($solicitud->link_pago_sol);
         } else if($solicitud->esta_pago_sol == 'P'){
            return view('pago.signout.mensaje');
         }
      }
      try{
         $clientAuth = new \GuzzleHttp\Client();
         $serviceId = config('app.ORBIS_IdService');
         $accessKey = config('app.ORBIS_AccessKey');
         $secretKey = config('app.ORBIS_SecretKey');
         $date = Carbon::now()->toAtomString();
         $hash = hash('SHA256', $serviceId.'.'.$accessKey.'.'.$secretKey.'.'.$date, false);
         $responseAuth = $clientAuth->post(config('app.ORBIS_URL_AUTH'),[
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
               'accessKey' => $accessKey,
               'idService' => $serviceId,
               'dateRequest' => $date,
               'hashString' => $hash
            ]
         ]);

         $result = json_decode($responseAuth->getBody()->getContents());
         $accessToken = $result->data->token;
         $enlace = $this->generateCIP($accessToken);
         if(hasCartSignOut()){
            session()->forget(['cartSignOut']);
         }
         return view('partials.view-cip', ['link'=> $enlace]);
         // return redirect()->away($enlace);
      }catch (RequestException $e){
         //$responseAuth = $this->StatusCodeHandling($e);
         return $e;
      }
   }

   Public function generateCIP($accessToken)
   {
      $fechaExpCIP = Carbon::now()->add(1, 'day'); // Fecha de Expiración CIP
      $horaExpCIP = '12:59:59'; // Hora de Expiración CIP

      try
    	{
    		DB::beginTransaction();
         // Crea movimiento del pago
         // cabecera
         $pago = new Pago;
         $pago->tipo_plat_mov = 'PE';
         $pago->esta_movi_mov = 'PE';
		 $pago->codi_modu_ori = 'ADM';
         $pago->tipo_docu_mov = getCartSignAttribute('tipo_docu_sol');
         $pago->nume_docu_mov = getCartSignAttribute('nume_docu_sol');
         $pago->mnto_tota_mov = getCartSignOutSum();
         $pago->term_regi_aud = request()->getClientIp();
         $pago->fech_gene_mov = Carbon::now();
         $fech_expi = $fechaExpCIP->format('Y-m-d').' '.$horaExpCIP; // Fecha de expiración del CIP
         $pago->fech_expi_mov = Carbon::createFromFormat('Y-m-d H:i:s',$fech_expi);
         $pago->fech_regi_aud = Carbon::now();
         $pago->save();
         // detalle
         $secu = 0;
         foreach (getCartSignOut() as $det) {
            $secu++;
            $pagoDet = new Pago_Det;
            $pagoDet->codi_movi_mov = $pago->codi_movi_mov;
            $pagoDet->secu_deta_mov = $secu;
            $pagoDet->codi_conc_pag = $det['codi_conc_mov'];
            $pagoDet->cant_conc_mov = $det['cant_conc_mov'];
            $pagoDet->mnto_prec_mov = $det['mnto_prec_mov'];
            $pagoDet->mnto_subt_mov = $det['mnto_subt_mov'];
            $pagoDet->codi_secc_sec = $det['codi_secc_mov'];
            $pagoDet->codi_espe_esp = $det['codi_espe_mov'];
            $pagoDet->save();
         }
         DB::commit();
      }
      catch(\Exception $e)
      {
         DB::rollback();
         dd($e);
         return '';
      }

      try{
         $clientCIPs = new \GuzzleHttp\Client();

         $responseCIP = $clientCIPs->post(config('app.ORBIS_URL_CIPS'),[
            'headers' => [
               'Content-Type' => 'application/json',
               'Accept-Language' => 'es-PE',
               'Origin' => 'web',
               'Authorization' => 'Bearer '.$accessToken
            ],
            'json' => [
               'currency'=> 'PEN',
               'amount'=> getCartSignOutSum(),
               'transactionCode'=> $pago->codi_movi_mov,
               'adminEmail'=> config('app.ORBIS_AdminEmail'),
               'dateExpiry'=> $fechaExpCIP->format('Y-m-d').'T'.$horaExpCIP.'-05:00',
               'paymentConcept'=> null,
               'additionalData'=> null,
               'userEmail'=> getCartSignAttribute('mail_soli_adm'),
               'userId'=> null,
               'userName'=> null,
               'userLastName'=> null,
               'userUbigeo'=> null,
               'userCountry'=> null,
               'userDocumentType'=> 'DNI',
               'userDocumentNumber'=> $pago->nume_docu_mov,
               'userCodeCountry' => null,
               'userPhone' => null,
               'serviceId'=> config('app.ORBIS_IdService')
            ]
         ]);

         $result = json_decode($responseCIP->getBody()->getContents());

         // GUARDAR EN LA BD: ESTADO SOLICITUD GENERADA;
         $solicitud = Solicitud_Admision::where('codi_proc_adm', getCartSignAttribute('codi_proc_adm'))
            ->where('tipo_docu_sol', getCartSignAttribute('tipo_docu_sol'))
            ->where('nume_docu_sol', getCartSignAttribute('nume_docu_sol'))
            ->first();

         $solicitud->esta_pago_sol = 'G';
         $solicitud->tipo_plat_sol = 'PE';
         $solicitud->codi_oper_sol = $result->data->cip;
         $solicitud->link_pago_sol = $result->data->cipUrl;
         $solicitud->fech_expi_pag = Carbon::createFromFormat('Y-m-d H:i:s',$fech_expi);
         $solicitud->update();

         $pago->codi_oper_mov = $result->data->cip;
         $pago->link_pago_mov = $result->data->cipUrl;
         $pago->update();

         return $result->data->cipUrl;

      }catch (RequestException $e){
         $responseCIP = $this->StatusCodeHandling($e);
         return $responseCIP;
      }
   }

   public function StatusCodeHandling($e)
   {
      if ($e->getResponse()->getStatusCode() == '400'){
         // $this->prepare_access_token();
         $response = json_decode($e->getResponse()->getBody(true)->getContents());
         return $response;
      } elseif ($e->getResponse()->getStatusCode() == '422'){
         $response = json_decode($e->getResponse()->getBody(true)->getContents());
         return $response;
      } elseif ($e->getResponse()->getStatusCode() == '500'){
         $response = json_decode($e->getResponse()->getBody(true)->getContents());
         return $response;
      } elseif ($e->getResponse()->getStatusCode() == '401'){
         $response = json_decode($e->getResponse()->getBody(true)->getContents());
         return $response;
      } elseif ($e->getResponse()->getStatusCode() == '403'){
         $response = json_decode($e->getResponse()->getBody(true)->getContents());
         return $response;
      } else{
         $response = json_decode($e->getResponse()->getBody(true)->getContents());
         return $response;
      }
   }
}
