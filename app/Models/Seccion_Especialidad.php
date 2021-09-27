<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CustomModel;

class Seccion_Especialidad extends Model
{
   use CustomModel;

   protected $table = 'bdsig.vw_sig_seccion_especialidad';
}
