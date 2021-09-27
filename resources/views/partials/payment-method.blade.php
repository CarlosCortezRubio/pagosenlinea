<div id="accordion">
   <div class="card card-primary card-outline elevation-2">
      <div class="card-header">
         <a class="card-link" data-toggle="collapse" href="#collapseOne">
            <i class="fas fa-money-bill-wave"></i> Dep&oacute;sitos y transferencias
         </a>
      </div>
      <div id="collapseOne" class="collapse show" data-parent="#accordion">
         <div class="card-body">
            <div class="row">
               <div class="col-lg-3 col-md-9">
                  <div class="custom-control custom-radio mb-2">
                        <input type="radio" class="custom-control-input" id="rbtn1" name="tipo_plat_mov" value="T">
                        <label class="custom-control-label" for="rbtn1">
                              <img src="{{ asset('img/logo_pagoefectivo_horizontal.png') }}" alt="" style="max-height:30px">
                        </label>
                     </div>
               </div>
               <div class="col-lg-8 col-md-9" style="font-size: 12px;">
                  <div class="row">
                     <div class="col" style="max-width: 30px;">
                        <i class="fas fa-check"></i>
                     </div>
                     <div class="col-11">
                        <p><b>Depósitos en efectivo vía PagoEfectivo - </b>Paga en BBVA, BCP, Interbank, Scotiabank, BanBif, Western Union, Tambo+, Kasnet, Full
                        Carga, Red Digital, Money Gram, Caja Arequipa, Disashop, en cualquier agente o agencia autorizada a nivel nacional a la cuenta de PagoEfectivo
                        <a href="#" data-toggle="modal" data-target="#modal-info" target="_blank">¿C&oacute;mo funciona?</a></p>
                     </div>
                  </div>
                  <div class="row" style="padding-top:5px">
                     <div class="col" style="max-width: 30px;">
                        <i class="fas fa-check"></i>
                     </div>
                     <div class="col-11">
                        <p><b>Transferencias bancarias vía PagoEfectivo - </b>Paga en BBVA, BCP, Interbank, Scotiabank, BanBif, Caja Arequipa, a través de la
                        banca por internet o banca móvil en la opción pago de servicios <a href="#" data-toggle="modal" data-target="#modal-info" target="_blank">¿C&oacute;mo funciona?</a></p>
                     </div>
                  </div>
                  <div class="row" style="padding-top:5px">
                     <div class="col" style="max-width: 30px;">
                        {{-- <i class="fas fa-asterisk"></i> --}}
                     </div>
                     <div class="col-11">
                        <img class="img-fluid" src="{{ asset('img/logo_pagoefectivo_centros_pago.png') }}" alt="" style="max-height:100px">
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>