<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CustomModel;

class Pago extends Model
{
   use CustomModel;

   protected $table = 'pa_movimiento';

   protected $primaryKey = 'codi_movi_mov';

  	public $incrementing = true;
   public $timestamps = false;
 
   protected $fillable = [
      'tipo_plat_mov',
      'codi_oper_mov',
      'esta_movi_mov',
      'tipo_docu_mov',
      'nume_docu_mov',
      'mnto_tota_mov',
      'user_regi_aud',
      'term_regi_aud',
      'user_actu_aud',
      'term_actu_aud',
      'link_pago_mov',
      'codi_pago_mov',
	  'codi_modu_ori'
   ];

   protected $dates = [
	   'fech_gene_mov',
      'fech_expi_mov',
      'fech_pago_mov',
      'fech_regi_aud',
      'fech_actu_aud'
  	];
}
