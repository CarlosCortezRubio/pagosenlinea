<!-- Agregar Pago -->
<form id="add-form" action="{{ route('cart.add.pay') }}" method="POST">
   @csrf
   <div class="modal fade" aria-hidden="true" role="dialog" tabindex="-1" id="modal-add-cart">
      <div class="modal-dialog" style="max-width: 700px;">
         <div class="modal-content">
            <div class="modal-header bg-primary">
               <strong>Agregar nuevo pago</strong>
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
               @if ($conceptos)
                  <input type="hidden" name="action" value="add">
                  <input type="hidden" name="desc_secc_mov" id="desc_secc_mov">
                  <input type="hidden" name="desc_espe_mov" id="desc_espe_mov">
                  <input type="hidden" name="desc_conc_mov" id="desc_conc_mov">
                  <div class="form-group row">
                     <label for="codi_secc_mov" class="col-form-label text-md-right col-md-2">Sección:</label>
                     <div class="col-md-10">
                        <select name="codi_secc_mov" class="form-control" id="s_seccion" autofocus required>
                           <option value="" selected>Seleccione...</option>
                           @foreach ($secciones as $secc)
                              <option value="{{$secc->codi_tabl_det}}" data-desc_tabl_det="{{$secc->desc_tabl_det}}">{{$secc->desc_tabl_det}}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="codi_espe_mov" class="col-form-label text-md-right col-md-2">Especialidad:</label>
                     <div class="col-md-10">
                        <select name="codi_espe_mov" class="form-control" id="s_especialidad" autofocus required>
                           <option value="" selected>Seleccione...</option>
                           @foreach ($especialidades as $espe)
                              <option value="{{$espe->codi_tabl_det}}" data-desc_tabl_det="{{$espe->desc_tabl_det}}">{{$espe->desc_tabl_det}}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="codi_conc_mov" class="col-form-label text-md-right col-md-2">Concepto:</label>
                     <div class="col-md-10">
                        <select name="codi_conc_mov" class="form-control" id="s_concepto" autofocus required>
                           <option value="" selected>Seleccione...</option>
                           @foreach ($conceptos as $conc)
                        <option value="{{$conc->codi_conc_pag}}" data-desc_conc_pag="{{$conc->desc_conc_pag}}" data-prec_conc_pag="{{$conc->mnto_regu_cpd}}">{{$conc->desc_conc_pag}}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="cant_conc_mov" class="col-form-label text-md-right col-md-2">Cantidad:</label>
                     <div class="col-md-3">
                        <input type="text" name="cant_conc_mov" id="cant_conc_mov" class="form-control text-right" maxlength="3">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="mnto_prec_mov" class="col-form-label text-md-right col-md-2">Costo:</label>
                     <div class="col-md-3">
                        <input type="text" name="mnto_prec_mov" id="mnto_prec_mov" class="form-control text-right" readonly>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="mnto_subt_mov" class="col-form-label text-md-right col-md-2">Importe total:</label>
                     <div class="col-md-3">
                        <input type="text" name="mnto_subt_mov" id="mnto_subt_mov" class="form-control text-right" readonly>
                     </div>
                  </div>
               @endif
            </div>
            <div class="modal-footer p-3" style="text-aling">
               <div class="container text-center">
                  <div class="row">
                     <div class="col">
                        <button type="submit" class="btn btn-primary btn-block">
                           <i class="fas fa-plus pr-2"></i>Agregar
                        </button>
                     </div>
                     <div class="col">
                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">
                           <i class="fas fa-undo-alt pr-2"></i>Cancelar
                        </button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</form>