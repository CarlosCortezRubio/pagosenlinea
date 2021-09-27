<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CustomModel;

class Pago_Det extends Model
{
    use CustomModel;

    protected $table = 'pa_movimiento_det';
 
    protected $primaryKey = [
       'codi_movi_mov',
       'secu_deta_mov'
    ];
    public $incrementing = false;
    public $timestamps = false;
  
    protected $fillable = [
       'codi_conc_pag',
       'cant_conc_mov',
       'mnto_prec_mov',
       'mnto_mult_mov',
       'mnto_desc_mov',
       'mnto_subt_mov',
       'codi_secc_sec',
       'codi_espe_esp'
    ];
 
}
