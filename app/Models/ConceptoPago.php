<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CustomModel;

class ConceptoPago extends Model
{
   use CustomModel;

   protected $table='bdsig.concepto_pago';

   protected $primaryKey='codi_conc_pag';
   protected $keyType='string';
   public $incrementing=false;

   public $timestamps=false;

   protected $fillable=[
      'desc_conc_pag',
      'abre_conc_pag',
      'esta_conc_pag',
      'flag_cext_pag',
      'flag_carr_pag',
      'flag_otro_pag',
      'flag_peri_pag',
      'flag_manu_pag'
   ];
}
