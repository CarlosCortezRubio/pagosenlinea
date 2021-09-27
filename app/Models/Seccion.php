<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CustomModel;

class Seccion extends Model
{
   use CustomModel;

   protected $table = 'bdsig.vw_sig_seccion';

   public function especialidad(){
      return $this->hasMany('App\Models\Seccion_Especialidad', 'codi_secc_sec', 'codi_secc_sec');
   }
}
