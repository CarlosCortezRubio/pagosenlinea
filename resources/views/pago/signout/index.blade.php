@extends('layouts.app')

@section('content_header')
   <h3><i class="fa fa-shopping-cart pr-2"></i>Carrito de compras</h3>
@endsection

@section('content_header_command')
   <form id="pay-form" action="{{ route('admision.pay') }}" method="POST">
      @csrf
      <button type="button" class="btn btn-primary" id="btnPagar" disabled onclick="event.preventDefault();
         document.getElementById('pay-form').submit();" data-toggle="tooltip" title="Pagar S/ {{ number_format(getCartSignOutSum(),2,".",",") }}">
         <i class="fa fa-coins"></i>
         <span class="d-none d-sm-inline-block pl-1">Pagar S/ {{ number_format(getCartSignOutSum(),2,".",",") }}</span>
      </button>
   </form>
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
                           <th>Concepto de pago</th>
                           <th>Cantidad</th>
                           <th>Costo S/</th>
                           <th>Importe total S/</th>
                        </tr>
                     </thead>
                     <tbody>
                        @if(hasCartSignOut())
                           @foreach(getCartSignOut() as $index => $pag)
                              <tr>
                                 <td>{{ $loop->index + 1 }}</td>
                                 <td>{{ $pag['desc_conc_mov'] }}</td>
                                 <td>{{ $pag['cant_conc_mov'] }}</td>
                                 <td>{{ $pag['mnto_prec_mov'] }}</td>
                                 <td>{{ $pag['mnto_subt_mov'] }}</td>
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
      });

   </script>
@endsection