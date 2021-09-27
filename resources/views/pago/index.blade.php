@extends('layouts.app')

@section('content_header')
   <h3><i class="fa fa-shopping-cart pr-2"></i>Carrito de compras</h3>
@endsection

@section('content_header_command')
   <div class="row">
      <form id="pay-form" action="{{ route('cart.add.pay') }}" method="POST">
         @csrf
         <input type="hidden" name="action" value="pay">
         <button type="button" class="btn btn-primary" id="btnPagar" disabled onclick="event.preventDefault();
            document.getElementById('pay-form').submit();" data-toggle="tooltip" title="Pagar S/ {{ number_format(getCartSum(),2,".",",") }}">
            <i class="fa fa-coins"></i>
            <span class="d-none d-sm-inline-block pl-1">Pagar S/ {{ number_format(getCartSum(),2,".",",") }}</span>
         </button>
      </form>&nbsp;
      <button type="button" id="btn-delete-all" class="btn btn-primary" data-toggle="tooltip" title="Limpiar carrito">
         <i class="fas fa-trash-alt"></i>
         <span class="d-none d-sm-inline-block pl-1">Limpiar carrito</span>
      </button>
   </div>
@endsection

@section('content')
   <div class="container">
      <div class="card card-primary card-outline elevation-2">
         <div class="card-body">
            <div class="row">
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="table-responsive" id="mydata">
                     <table class="table table-sm table-bordered table-hover">
                        <thead>
                           <tr class="bg-light">
                              <th>Nº</th>
                              <th>Secci&oacute;n</th>
                              <th>Especialidad</th>
                              <th>Concepto de pago</th>
                              <th>Cantidad</th>
                              <th>Costo S/</th>
                              <th>Importe total S/</th>
                              <th>Opciones</th>
                           </tr>
                        </thead>
                        <tbody>
                           @if(hasCart())
                              @foreach($pagos as $index => $pag)
                                 <tr data-key="{{ $index }}">
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $pag['desc_secc_mov'] }}</td>
                                    <td>{{ $pag['desc_espe_mov'] }}</td>
                                    <td>{{ $pag['desc_conc_mov'] }}</td>
                                    <td>{{ $pag['cant_conc_mov'] }}</td>
                                    <td>{{ $pag['mnto_prec_mov'] }}</td>
                                    <td>{{ $pag['mnto_subt_mov'] }}</td>
                                    {{-- <td>{{ $pag['codi_secc_mov'] }}</td>
                                    <td>{{ $pag['codi_espe_mov'] }}</td> --}}
                                    <td>
                                       <button id="btn-delete" class="btn btn-secondary btn-sm btnItemRemove" type="button" data-toggle="tooltip" title="Quitar pago">
                                          <i class="fas fa-trash-alt"></i>
                                       </button>
                                    </td>
                                 </tr>
                              @endforeach
                           @endif
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <form id='delete-form' action="{{ route('pago.destroy','1') }}" method="POST">
         @method('DELETE')
         @csrf
         <input type="hidden" id="action" name="action">
         <input type="hidden" id="key" name="key">
      </form>

      @include('partials.payment-method')
   </div>
   @include('partials.modal-info',['link'=>'https://cip.pagoefectivo.pe/CNT/QueEsPagoEfectivo.aspx'])
@endsection

@section('scripts')
   <script type="text/javascript">
      // Activa botón Pagar
      function activePay() {
         if ($('#rbtn1').prop('checked')) {
            $('#btnPagar').prop('disabled', false);
         } else {
            $('#btnPagar').prop('disabled', true);
         }
      }

      $(document).ready(function(){
         // Activa botón Pagar
         $('#rbtn1').change(function(){
            activePay();
         });

         $('#btn-delete-all').click(function(e){
            e.preventDefault();
            $('#action').val('all');
            document.getElementById('delete-form').submit();
         });
      });

      $(document).on('click', '.btnItemRemove', function (event) {
         event.preventDefault();
         var tr = $(this).closest('tr');

         $('#action').val('one');
         $('#key').val(tr.data('key'));
         document.getElementById('delete-form').submit();
      });

   </script>
@endsection