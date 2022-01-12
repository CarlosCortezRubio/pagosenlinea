<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Exception\RequestException;
use App\Models\Pago;
use Carbon\Carbon;

class ExternalController extends Controller
{

	public function showSimularPago(Request $request)
	{
		
         return view('pago.signout.simular-pago');
       
	}

	public function simularPago(Request $request)
	{
		

         try{
   			$cip = $request->get('cod_cip');
   			$monto = $request->get('mnto_pago');

   			$pago = Pago::where('codi_oper_mov', $cip)
   							->first();

   			if ($pago) {
   				if ($pago->esta_movi_mov == 'PA') {
   					return redirect()->route('external.simularPago')
   											->with('no_success', 'El CIP '.$cip.' ya se encuentra pagado.');
   				}

   			} else {
   				return redirect()->route('external.simularPago')
   										->with('no_success', 'El CIP '.$cip.' no es correcto.');
   			}

            $fechaPago = Carbon::now()->format('Y-m-d').'T'.Carbon::now()->format('H:i:s').'-05:00';

            $clientAuth = new \GuzzleHttp\Client( ['verify'=>false /*,'exceptions'=>false*/ ] );

   			$secretKey = config('app.ORBIS_SecretKey');
   			$textBody ='{"eventType":"cip.paid","operationNumber":"'.$pago->codi_movi_mov.'","data":{"cip":"'.$cip.'","currency":"PEN","amount":'.number_format($monto,2,".","")./*',"paymentDate":"'.$fechaPago.'","transactionCode":"013240BN403"*/'}}';
   			$signature = hash_hmac('sha256', $textBody, $secretKey);
   			$data = [
   				'cip' => $cip,
   				'currency' => 'PEN',
   				'amount' => number_format($monto,2,".",""),
   				'paymentDate' => $fechaPago,
   				'transactionCode' => '013240BN403'
   			];

            $responseAuth = $clientAuth->post(route('api.rest.notify'),[
   				'headers' => ['Content-Type' => 'application/json',
   								  'PE-Signature' => $signature],
               'json' => [
                  'eventType' => 'cip.paid',
                  'operationNumber' => $pago->codi_movi_mov,
                  'data' => $data
               ]
   			]);

   			$status = $responseAuth->getStatusCode();
            if($status=="200") {
   				return redirect()->route('external.simularPago')
                     ->with('success','El pago se ha simulado correctamente.');
   			} else {
   				return redirect()->route('external.simularPago')
   				->with('no_success', 'El CIP o el monto no son correctos ('.$status.'). Por favor, verifique.');
   			}

         } catch (RequestException $e){
			 dd($e->getMessage());
            return redirect()->route('external.simularPago')
   				->with('no_success', 'El CIP o el monto no son correctos. Por favor, verifique.');
         }

      
   }
    }