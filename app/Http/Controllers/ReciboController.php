<?php

namespace App\Http\Controllers;

use App\Models\CorrelativoDocumento;
use App\Models\Pago;
use App\Models\Pago_Det;
use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\ReciboPago;
use App\Models\ReciboPagoDet;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Log;
use PDF;

class ReciboController extends Controller
{
   public function reciboPostulante($idpostulante){

		$postulante = DB::table('bdsigunm.ad_postulacion AS a')
								->join('bdsigunm.ad_solicitud AS b', function ($join) {
									$join->on('b.tipo_docu_sol', '=', 'a.tipo_docu_per')
											->on('b.nume_docu_sol', '=', 'a.nume_docu_per')
											->on('b.codi_proc_adm', '=', 'a.codi_proc_adm');
							})
							->where('codi_post_pos',$idpostulante)
							->select('a.codi_espe_esp', 'a.codi_secc_sec', 'a.codi_post_pos', 'a.codi_pers_per', 'a.codi_proc_adm', 'a.apel_pate_per', 'a.apel_mate_per', 'a.nomb_pers_per', 'a.tipo_docu_per', 'a.nume_docu_per', 'a.ubig_domi_per', 'a.telf_fijo_per', 'a.telf_celu_per', 'a.fech_naci_per', 'a.apel_nomb_apd',	'a.nume_docu_apd', 'a.foto_post_per', 'b.tipo_plat_sol', 'b.codi_oper_sol', 'b.mail_soli_sol')
							->first();
		if($postulante){
			$tipo_doc = $postulante->tipo_docu_per;
			$nume_doc = $postulante->nume_docu_per;

			$persona = Persona::Where('tipo_docu_per', $tipo_doc)
							->where('nume_docu_per', $nume_doc)
							->first();

			if(!$persona){
				$alumno = new Persona;
				$alumno->apel_pate_per=strtoupper(trim($postulante->apel_pate_per));
				$alumno->apel_mate_per=strtoupper(trim($postulante->apel_mate_per));
				$alumno->nomb_pers_per=strtoupper(trim($postulante->nomb_pers_per));
				$alumno->tipo_docu_per=$tipo_doc;
				$alumno->nume_docu_per=$nume_doc;
				$alumno->flag_alum_per='S';
				$alumno->flag_acti_per='S';
				$alumno->fech_naci_per=$postulante->fech_naci_per;
				$alumno->tipo_pers_per='N';
				//$alumno->ubig_domi_per=substr($postulante->ubig_domi_per,0,6);
				//$alumno->telf_domi_per=$postulante->telf_fijo_per;
				//$alumno->telf_emer_per=$postulante->telf_celu_per;
				$alumno->mail_pers_per=$postulante->mail_soli_sol;
				//$alumno->ndni_reap_per=$postulante->nume_docu_apd;
				//$alumno->repr_apod_per=$postulante->apel_nomb_apd;
				//$alumno->foto_pers_per=$postulante->foto_post_per;
				$alumno->save();
			}
			
		} else {
			return ['ok' => false, 'error' => 'No existe el postulante'];
		}					

		$pago = Pago::where('tipo_plat_mov', $postulante->tipo_plat_sol)
						->where('codi_oper_mov', $postulante->codi_oper_sol)
						->first();
		
		$idPago = $pago->codi_movi_mov;

		$response = $this->generarRecibo($idPago);

		return $response;
	}
	
	public function generarRecibo($id)
   {
		$pagoCab = Pago::where('codi_movi_mov',$id)
							->first();
		
		$pagoDet = Pago_Det::where('codi_movi_mov',$id)
							->get();
		
		$persona = Persona::Where('tipo_docu_per', $pagoCab->tipo_docu_mov)
							->where('nume_docu_per', $pagoCab->nume_docu_mov)
							->first();
		Log::info(implode(",",$pagoCab));
		Log::info(implode(",",$pagoDet));
		Log::info(implode(",",$persona));
		
		$codi_pers = $persona->codi_pers_per;
		$email = $persona->mail_pers_per;
		$sede = '004';
		
		try
		{
			DB::beginTransaction();
	
			$correlativo = CorrelativoDocumento::where('tipo_corr_cdo', 'REC')
								->where('codi_sede_tse', $sede)
								->where('anio_corr_cdo', Carbon::now()->format('Y'))
								->where('nmes_corr_cdo', '99')
								->first();
			
			if($correlativo){
				$nume_corr = $correlativo->corr_actu_cdo;
			} else {
				$newCorre = new CorrelativoDocumento;
				$newCorre->tipo_corr_cdo = 'REC';
				$newCorre->codi_sede_tse = $sede;
				$newCorre->anio_corr_cdo = Carbon::now()->format('Y');
				$newCorre->nmes_corr_cdo = '99';
				$newCorre->fech_regi_aud = Carbon::now();
				// $newCorre->user_regi_aud=;
				$newCorre->term_regi_aud = request()->getClientIp();
				$newCorre->save();

				$nume_corr = 0;
			}
			// Cabecera
			$nume_corr = $nume_corr + 1;
			$codi_reci = Carbon::now()->format('Y').str_pad($nume_corr, 6, "0", STR_PAD_LEFT);
			$recibo = new ReciboPago;
			$recibo->codi_reci_pag = $codi_reci;
			$recibo->codi_sede_pag = $sede;
			$recibo->esta_reci_pag = 'E';
			$recibo->codi_alum_pag = $codi_pers;
			$recibo->flag_empr_pag = 'N';
			$recibo->tipo_plat_pag = $pagoCab->tipo_plat_mov;
			$recibo->codi_oper_pag = $pagoCab->codi_oper_mov;
			$recibo->user_regi_pag = 'VIRTUAL';
			$recibo->fech_emis_pag = Carbon::now();
			$recibo->fech_regi_pag = Carbon::now();
			$recibo->save();
			// Correlativo 
			$correlativo->corr_actu_cdo = $nume_corr;
			$correlativo->save();
			// Detalle
			$secu = 0;
			foreach ($pagoDet as $det) {
				$secu++;
				$reciboDet = new ReciboPagoDet;
				$reciboDet->codi_reci_pag = $recibo->codi_reci_pag;
				$reciboDet->secu_reci_pag = $secu;
				$reciboDet->codi_sede_pag = $sede;
				$reciboDet->codi_conc_pag = $det->codi_conc_pag;
				// $reciboDet->codi_curs_cex = $det->;
				// $reciboDet->secu_hora_ceh = $det->;
				$reciboDet->codi_espe_cex = $det->codi_espe_esp;
				$reciboDet->codi_secc_cex = $det->codi_secc_sec;
				$reciboDet->codi_clas_ppt = '001281'; //solo para pruebas
				$reciboDet->mnto_subt_pag = $det->mnto_subt_mov;
				$mora = (is_null($det->mnto_mult_mov) || empty($det->mnto_mult_mov) || strlen($det->mnto_mult_mov) < 1 ? 0 : $det->mnto_mult_mov);
				$reciboDet->mnto_mora_pag = $mora;
				$reciboDet->mnto_tota_pag = $det->mnto_subt_mov + $mora;
				$reciboDet->orig_conc_pag = 'MA';
				$reciboDet->user_regi_rpd = 'VIRTUAL';
				$reciboDet->peri_pago_pag = Carbon::now()->format('Ym');;
				// $reciboDet->codi_prog_pag = $det->;
				// $reciboDet->nmes_prog_ppc = $det->;
				$reciboDet->prec_unit_pag = $det->mnto_prec_mov;
				$reciboDet->cant_conc_pag = $det->cant_conc_mov;
				$reciboDet->fech_regi_rpd = Carbon::now();
				$reciboDet->save();
			}

			DB::commit();

			return ['ok' => true,'corr'=>$recibo->codi_reci_pag, 'sede'=>$sede, 'email'=>$email];
      }
      catch(\Exception $e)
      {
         DB::rollback();
		 Log::error($e->getMessage());
         return ['ok' => false, 'error' => $e];
      }
	}
	
	public function recibo(Request $request)
   {
		if ($request) {
         if (!$request->hasValidSignature()) {
            return view('pago.signout.mensaje');

         } else {

				$reciboCab = DB::table('bdsigunm.recibo_pago AS a')
									->join('bdsig.persona AS b', 'a.codi_alum_pag','b.codi_pers_per')					
									->join('bdsig.ttablas_det AS c', 'b.tipo_docu_per','c.codi_tabl_det')
									->where('c.codi_tabl_tab','=', '01')
									->where('a.codi_reci_pag',$request->get('p1'))
									->where('a.codi_sede_pag',$request->get('p2'))
									->select('a.codi_reci_pag', 'a.tipo_plat_pag', 'a.codi_oper_pag', 'b.nomb_comp_per', 'c.abre_tabl_det', 'b.nume_docu_per',  DB::raw("to_char(a.fech_emis_pag,'DD/MM/YYYY') AS fech_pago_pag"))
									->first();

				$reciboDet = DB::table('bdsigunm.recibo_pago_det AS a')
									->join('bdsig.ttablas_det AS b', 'b.codi_tabl_det', 'a.codi_espe_cex')
									->join('bdsig.ttablas_det AS c', 'c.codi_tabl_det', 'a.codi_secc_cex')
									->join('bdsig.concepto_pago AS d', 'd.codi_conc_pag', 'a.codi_conc_pag')
									->where('b.codi_tabl_tab', '=', '04')
									->where('c.codi_tabl_tab', '=', '05')
									->where('a.codi_reci_pag',$request->get('p1'))
									->where('a.codi_sede_pag',$request->get('p2'))
									->select('a.*', 'b.desc_tabl_det AS especialidad', 'c.abre_tabl_det AS seccion', 'd.desc_conc_pag')
									->get();
		// dd($reciboDet);
				$pdf = PDF::loadView('pago.recibo',
				[ 'cabecera' => $reciboCab,
					'detalle' => $reciboDet
				]);

				$filename='recibopago.pdf';
				$pdf->setPaper('a5', 'portrait');

				return $pdf->stream($filename);
			}
		}
   }
}
