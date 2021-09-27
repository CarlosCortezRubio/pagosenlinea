<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pago;
use App\Models\Pago_Det;
use App\Traits\Tables;
use Carbon\Carbon;
use DB;
use GuzzleHttp\Exception\RequestException;
use PDF;

class PagoController extends Controller
{
   use Tables;

   public function __construct()
   {
      $this->middleware('auth');
   }

   public function index(){

      $concepts = $this->getConcepts('A');
      $sections = $this->getTables('05', '%', 'S');
      $specialties = $this->getTables('04', '%', 'S');

      if(hasCart()){
         if(session('cart')->count() == 0){
            session()->forget(['cart']);

            return redirect()->to('home');
         }
         $cart = session('cart');
      } else {
         return redirect()->to('home');
      }

      return view('pago.index',['conceptos'=>$concepts, 'pagos'=>$cart, 'secciones'=>$sections, 'especialidades'=>$specialties]);
   }

   public function store(Request $request)
   {
      $action = $request->get('action');
      if($action == 'add'){
         $key = $request->get('codi_secc_mov').$request->get('codi_espe_mov').$request->get('codi_conc_mov');

         $array_cart = ['codi_secc_mov'=>$request->get('codi_secc_mov'),
                        'codi_espe_mov'=>$request->get('codi_espe_mov'),
                        'codi_conc_mov'=>$request->get('codi_conc_mov'),
                        'cant_conc_mov'=>$request->get('cant_conc_mov'),
                        'mnto_prec_mov'=>$request->get('mnto_prec_mov'),
                        'mnto_subt_mov'=>$request->get('mnto_subt_mov'),
                        'desc_conc_mov'=>$request->get('desc_conc_mov'),
                        'desc_secc_mov'=>$request->get('desc_secc_mov'),
                        'desc_espe_mov'=>$request->get('desc_espe_mov')];
         if(hasCart()){
            $cart = session('cart');
         } else {
            $cart = collect([]);
         }
         $cart->put($key, $array_cart);

         session(['cart'=> $cart]);

         return redirect()->to('home/cart')
                  ->with('success','El pago ha sido agregado correctamente.');

      } else if($action == 'pay'){
         $concepts = $this->getConcepts('A');
         $sections = $this->getTables('05', '%', 'S');
         $specialties = $this->getTables('04', '%', 'S');
         $enlace = $this->prepareAccessToken();
         return view('partials.view-cip', ['link'=> $enlace,'conceptos'=>$concepts, 'secciones'=>$sections, 'especialidades'=>$specialties]);
      }
   }

   public function destroy(Request $request, $id)
   {
      $tipo = $request->get('action');
      $id = $request->get('key');
      if($tipo == 'one'){
         if(hasCart()){
            $cart = session('cart');
            $cart->pull($id);
         }

         if(hasCart()){
            if(session('cart')->count() == 0){
               session()->forget(['cart']);

               return redirect()->to('home')
                           ->with('success','El pago ha sido quitado correctamente.');
            }

            return redirect()->to('home/cart')
                           ->with('success','El pago ha sido quitado correctamente.');
         }

         return redirect()->to('home')
                           ->with('success','El pago ha sido quitado correctamente.');

      } else if($tipo == 'all'){
         if(hasCart()){
            session()->forget(['cart']);
         }

         return redirect()->to('home')
                  ->with('success','El carrito ha sido limpiado correctamente.');
      }
   }

   public function prepareAccessToken()
   {
	   if (hasCart() == false) {
		   abort(404, 'Página no encontrada.');
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
         if(hasCart()){
            session()->forget(['cart']);
         }
         // return view('partials.view-cip', ['link'=> $enlace]);
         return $enlace;

      }catch (RequestException $e){
         $responseAuth = $this->StatusCodeHandling($e);
         return $responseAuth;
      }
   }

   Public function generateCIP($accessToken)
   {
      $fechaExpCIP = Carbon::now()->add(1, 'day'); // Fecha de Expiración CIP
      $horaExpCIP = '12:59:59'; // Hora de Expiración CIP

      try
    	{
          DB::beginTransaction();
         // cabecera
         $pago = new Pago;
         $pago->tipo_plat_mov = 'PE';
         $pago->esta_movi_mov = 'PE';
         $pago->tipo_docu_mov = auth()->user()->tdocumento;
         $pago->nume_docu_mov = auth()->user()->ndocumento;
         $pago->mnto_tota_mov = getCartSum();
         $pago->term_regi_aud = request()->getClientIp();
         $pago->fech_gene_mov = Carbon::now();
         $fech_expi = $fechaExpCIP->format('Y-m-d').' '.$horaExpCIP; // Fecha de expiración del CIP
         $pago->fech_expi_mov = Carbon::createFromFormat('Y-m-d H:i:s',$fech_expi);
         $pago->fech_regi_aud = Carbon::now();
         $pago->save();
         // detalle
         $secu = 0;
         foreach (getCart() as $det) {
            $pagoDet = new Pago_Det;
            $pagoDet->codi_movi_mov = $pago->codi_movi_mov;
            $pagoDet->secu_deta_mov = $secu++;
            $pagoDet->codi_conc_pag = $det['codi_conc_mov'];
            $pagoDet->cant_conc_mov = $det['cant_conc_mov'];
            $pagoDet->mnto_prec_mov = $det['mnto_prec_mov'];
            $pagoDet->mnto_subt_mov = $det['mnto_subt_mov'];
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
               'amount'=> getCartSum(),
               'transactionCode'=> $pago->codi_movi_mov,
               'adminEmail'=> config('app.ORBIS_AdminEmail'),
               'dateExpiry'=> $fechaExpCIP->format('Y-m-d').'T'.$horaExpCIP.'-05:00',
               'paymentConcept'=> null,
               'additionalData'=> null,
               'userEmail'=> auth()->user()->email,
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

   public function recibo($id)
   {
      $pagoCab = DB::table('bdsigunm.pa_movimiento AS a')
                     ->join('bdsig.ttablas_det AS b', 'a.tipo_docu_mov','b.codi_tabl_det')
                     ->where('b.codi_tabl_tab','=', '01')
                     ->where('a.codi_movi_mov',$id)
                     ->select('a.codi_movi_mov', 'a.tipo_plat_mov', 'a.codi_oper_mov', 'b.abre_tabl_det', 'a.nume_docu_mov',  DB::raw("to_char(a.fech_pago_mov,'DD/MM/YYYY') AS fech_pago_mov"))
                     ->first();

      $pagoDet = DB::table('bdsigunm.pa_movimiento_det AS a')
                     ->join('bdsig.ttablas_det AS b', 'b.codi_tabl_det', 'a.codi_espe_esp')
                     ->join('bdsig.ttablas_det AS c', 'c.codi_tabl_det', 'a.codi_secc_sec')
                     ->join('bdsig.concepto_pago AS d', 'd.codi_conc_pag', 'a.codi_conc_pag')
                     ->where('b.codi_tabl_tab', '=', '04')
                     ->where('c.codi_tabl_tab', '=', '05')
                     ->where('a.codi_movi_mov',$id)
                     ->select('a.*', 'b.desc_tabl_det AS especialidad', 'c.abre_tabl_det AS seccion', 'd.desc_conc_pag')
                     ->get();

      $concepts = $this->getConcepts('A');
      $sections = $this->getTables('05', '%', 'S');
      $specialties = $this->getTables('04', '%', 'S');

      $pdf = PDF::loadView('pago.recibo',
      [ 'cabecera' => $pagoCab,
         'detalle' => $pagoDet
      ]);

         $filename='recibopago.pdf';
         $pdf->setPaper('a5', 'portrait');

         return $pdf->stream($filename);


      // return view('pago.recibo', ['conceptos'=>$concepts, 'secciones'=>$sections, 'especialidades'=>$specialties, 'cabecera'=>$pagoCab, 'detalle'=>$pagoDet]);
   }



}
