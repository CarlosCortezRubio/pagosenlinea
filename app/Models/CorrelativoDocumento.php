<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CustomModel;

class CorrelativoDocumento extends Model
{
    use CustomModel;

	protected $table = 'correlativo_documento';

	protected $primaryKey = [
		'tipo_corr_cdo',
		'codi_sede_tse',
		'anio_corr_cdo',
		'nmes_corr_cdo'
	];
	public $incrementing = false;
	public $timestamps = false;
	
	protected $fillable = [
		'corr_actu_cdo',
		'corr_mini_cdo',
		'corr_maxi_cdo',
		'user_regi_aud',
		'term_regi_aud',
		'user_actu_aud',
		'term_actu_aud'
	];

	protected $dates = [
		'fech_regi_aud',
		'fech_actu_aud'
	];
}
