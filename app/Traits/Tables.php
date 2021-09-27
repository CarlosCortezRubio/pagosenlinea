<?php

namespace App\Traits;

use Exception;
use DB;

use App\Models\Proceso;
use App\Models\Seccion;
use App\Models\Pais;
use Carbon\Carbon;

trait Tables
{
   public function getTables($table, $id, $status)
   {
      if (!(empty($id) || is_null($id))) {
         $data = DB::table('bdsig.ttablas_det')
                     ->where('codi_tabl_tab','=',$table)
                     ->where('codi_tabl_det','LIKE',$id ? $id : '')
                     ->where('flag_acti_det','LIKE',$status)
                     ->orderBy('desc_tabl_det','asc')
                     ->get();

         if ($id!='%') {
               $data = $data->first();
         }

         return ($data);

      } else {
         return ('');
      }
   }

   public function getConcepts($status)
   {
      $fech_expi = Carbon::now()->format('Y-m-d').' 23:59:59';

      $data = DB::table('bdsig.concepto_pago as cp')
                     ->join('bdsig.concepto_pago_det as cd','cd.codi_conc_pag', 'cp.codi_conc_pag')
                     ->join('bdsig.clasificador_pptal as cg','cg.codi_clas_ppt', 'cd.codi_clas_ppt')
                     ->where('cp.esta_conc_pag','LIKE',$status)
                     ->where('fweb_disp_pag','S')
                     ->where('cd.fech_inic_cpd','<=',Carbon::createFromFormat('Y-m-d H:i:s',$fech_expi))
                     ->where(function ($query) {
                        $query->where('cd.fech_fina_cpd', '>=', Carbon::now())
                              ->orWhere(function ($queryNull) {
                                 $queryNull->whereNull('cd.fech_fina_cpd');
                              });
                     })
                     ->select('cp.codi_conc_pag', 'cp.desc_conc_pag', 'cp.abre_conc_pag', 'cp.esta_conc_pag', 'cp.flag_cext_pag', 'cp.flag_carr_pag', 
                              'cd.fech_inic_cpd', 'cd.fech_fina_cpd', 'cd.mnto_regu_cpd', 'cd.flag_edit_cpd', 'cd.codi_clas_ppt', 'cg.clas_pres_ppt')
                     ->get();
      return ($data);
   }

   public function getUbigeo($ubigeo)
   {
      if (!(empty($ubigeo) || is_null($ubigeo))) {
         $data = DB::table('bdsig.ubigeo as di')
                     ->join('bdsig.ubigeo as dp', 'dp.codi_ubic_ubg', '=', DB::raw('substr(di.codi_ubic_ubg,1,2)'))
                     ->join('bdsig.ubigeo as pr', 'pr.codi_ubic_ubg', '=', DB::raw('substr(di.codi_ubic_ubg,1,4)'))
                     ->select('di.codi_ubic_ubg as codi_ubic_ubg','dp.abre_ubic_ubg as nomb_depa_ubg','pr.abre_ubic_ubg as nomb_prov_ubg','di.abre_ubic_ubg as nomb_dist_ubg')
                     ->where('di.codi_ubic_ubg','LIKE',$ubigeo ? $ubigeo : '')
                     ->where(DB::raw('length(di.codi_ubic_ubg)'),'=','6')
                     ->orderBy('di.codi_ubic_ubg','asc')
                     ->get();

         if ($ubigeo!='%') {
               $data = $data->first();
         }

         return ($data);

      } else {
         return ('');
      }
   }

   public function getParameter($period, $parm)
   {
      $data = DB::table('bdsig.sys_global_parametros')
               ->select('valo_text_sgp as text','valo_nume_sgp as nume','valo_fech_sgp as fech')
               ->where('peri_parm_sgp','=',$period)
               ->where('codi_parm_sgp','=',$parm ? $parm : '')
               ->first();

      return ($data);
   }

   public function getProceso($estado)
   {
      $data = Proceso::where('esta_proc_adm','=',$estado)
               ->first();

      return ($data);
   }

   public function generaURL($correo)
   {
      $variable = '';
      return 'cadena';
   }
}
