<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CustomModel;

class ReciboPagoDet extends Model
{
	use CustomModel;

	protected $table = 'recibo_pago_det';
    
	protected $primaryKey = [
		'codi_reci_pag',
		'secu_reci_pag',
		'codi_sede_pag'
	];
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'codi_conc_pag',
		'codi_curs_cex',
		'secu_hora_ceh',
		'codi_espe_cex',
		'codi_secc_cex',
		'codi_clas_ppt',
		'mnto_subt_pag',
		'mnto_mora_pag',
		'mnto_tota_pag',
		'orig_conc_pag',
		'user_regi_rpd',
		'user_actu_rpd',
		'peri_pago_pag',
		'codi_prog_pag',
		'nmes_prog_ppc',
		'prec_unit_pag',
		'cant_conc_pag'
	];

	protected $dates = [
		'fech_regi_rpd',
		'fech_actu_rpd',
	];
 
}
