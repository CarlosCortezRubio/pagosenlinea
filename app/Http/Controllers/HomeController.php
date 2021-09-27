<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use Illuminate\Http\Request;
use App\Traits\Tables;
use DB;

class HomeController extends Controller
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

      $pagos = Pago::where('esta_movi_mov','PE')
                     ->get();

      return view('consulta.index',['conceptos'=>$concepts, 'pagos'=>$pagos, 'secciones'=>$sections, 'especialidades'=>$specialties]);
   }

   public function paid(){
      $concepts = $this->getConcepts('A');
      $sections = $this->getTables('05', '%', 'S');
      $specialties = $this->getTables('04', '%', 'S');

      $pagos = Pago::where('esta_movi_mov','PA')
                     ->get();

      return view('consulta.pagado',['conceptos'=>$concepts, 'pagos'=>$pagos, 'secciones'=>$sections, 'especialidades'=>$specialties]);
   }
}
