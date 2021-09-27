<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CustomModel;

class Proceso extends Model
{
   use CustomModel;

   protected $table = 'ad_proceso';

   protected $primaryKey = 'codi_proc_adm';
   protected $keyType = 'string';
   public $incrementing = false;

   public $timestamps = false;

   protected $fillable = [
      'nume_proc_adm',
      'esta_proc_adm',
      'mnto_proc_adm',
      'codi_conc_pag',
      'moti_anul_aud',
      'user_anul_aud',
      'term_anul_aud',
      'user_regi_aud',
      'term_regi_aud',
      'user_actu_aud',
      'term_actu_aud'
   ];

   protected $dates = [
      'fech_inic_adm',
      'fech_fina_adm',
      'fech_anul_aud',
      'fech_regi_aud',
      'fech_actu_aud'
   ];

   public function concepto()
   {
      return $this->belongsTo('App\Models\ConceptoPago', 'codi_conc_pag');
   }
}
