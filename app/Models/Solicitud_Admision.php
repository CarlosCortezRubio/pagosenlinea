<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CustomModel;

class Solicitud_Admision extends Model
{
   use CustomModel;

   protected $table = 'ad_solicitud';

   protected $primaryKey = [
      'codi_proc_adm',
      'tipo_docu_sol',
      'nume_docu_sol'
   ];

      public $incrementing = false;
   public $timestamps = false;

   protected $fillable = [
      'mail_soli_sol',
      'link_gene_sol',
      'esta_pago_sol',
      'codi_oper_sol',
      'mnto_pago_sol',
      'tipo_plat_sol',
      'codi_secc_sec',
      'codi_espe_esp',
      'edad_calc_pos',
      'term_regi_aud',
      'toke_pago_sol',
      'link_pago_sol',
	  'codi_moda_mod'
   ];

   protected $dates = [
      'fech_expi_sol',
      'fech_naci_pos',
      'fech_regi_sol',
      'fech_pago_sol',
      'fech_expi_pag'
      ];
}
