<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CustomModel;

class Solicitud extends Model
{
   use CustomModel;

   protected $table = 'bdsig.sg_usuario_solicitud';

   protected $primaryKey = [
      'tipo_docu_sol',
      'nume_docu_sol'
   ];

  	public $incrementing = false;
   public $timestamps = false;
   
   protected $fillable = [
      'mail_soli_sol',
      'link_conf_sol',
      'esta_soli_sol',
      'apel_pate_sol',
      'apel_mate_sol',
      'nomb_pers_sol',
      'telf_celu_sol',
      'term_regi_aud'
   ];

   protected $dates = [
		'fech_expi_sol',
      'fech_regi_sol'
  	];
}
