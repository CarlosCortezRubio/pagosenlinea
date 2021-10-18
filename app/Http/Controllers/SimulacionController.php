<?php

namespace App\Http\Controllers;

use App\Mail\MensajeIngresante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SimulacionController extends Controller
{
    public function enviarReciboIngreso()
    {
       Mail::to(config('app.email_soporte'))->send(new MensajeIngresante(config('app.url').'/ReciboSimulado'));
       return 'mensaje enviado';
    }

    public function index()
    {
             $key = '010001011112545';
 
             $array_cart = ['codi_secc_mov'=>'05001',
                            'codi_espe_mov'=>'04028',
                            'codi_conc_mov'=>'00051',
                            'cant_conc_mov'=>'1',
                            'mnto_prec_mov'=>'100',
                            'mnto_subt_mov'=>'100',
                            'desc_conc_mov'=>'Derecho de Ingreso',
                            'mail_soli_adm'=>config('app.email_soporte'),
                            'codi_proc_adm'=>'0213215',
                            'tipo_docu_sol'=>'0132153',
                            'nume_docu_sol'=>'2354354'
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
