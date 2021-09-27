<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CustomModel;

class ReciboPago extends Model
{
	use CustomModel;

	protected $table = 'recibo_pago';

	protected $primaryKey = [
		'codi_reci_pag',
		'codi_sede_pag'
	];
	protected $keyType='string';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'esta_reci_pag',
		'codi_alum_pag',
		'obse_reci_pag',
		'flag_empr_pag',
		'codi_empr_pag',
		'tipo_plat_pag',
		'codi_oper_pag',
		'user_regi_pag',
		'user_actu_pag',
		'user_anul_pag',
		'moti_anul_pag'
	];

	protected $dates = [
		'fech_emis_pag',
		'fech_regi_pag',
		'fech_actu_pag',
		'fech_anul_pag',
	];

}
