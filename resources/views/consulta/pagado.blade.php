@extends('layouts.app')

@section('content_header')
   <h3><i class="fa fa-user-circle pr-2"></i>Mis pagos realizados</h3>
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
                           <th>Fecha generación</th>
                           <th>Fecha expiración</th>
                           <th>Plataforma</th>
                           <th>Nº Operación</th>
                           <th>Importe</th>
                           <th>Estado</th>
                           <th>Opciones</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($pagos as $pag)
                           <tr>
                              <td>
                                 {{ $pag->codi_movi_mov}}
                              </td>
                              <td>{{ $pag->fech_gene_mov }}</td>
                              <td>{{ $pag->fech_expi_mov }}</td>
                              <td>  @if ($pag->tipo_plat_mov == 'PE') PagoEfectivo
                                    @else -
                                    @endif
                              </td>
                              <td>{{ $pag->codi_oper_mov }}</td>
                              <td>{{ $pag->mnto_tota_mov }}</td>
                              <td>  @if ($pag->esta_movi_mov == 'PE') 
                                       {{-- @if ($pag->fech_expi_mov > {{Carbon::now()}})  --}}
                                          Pendiente
                                       {{-- @else --}}
                                          {{-- Expirado --}}
                                       {{-- @endif --}}
                                    @elseif ($pag->esta_movi_mov == 'PA') Pagado
                                    @endif
                              </td>
                              <td>
                                 <a href="{{ route('recibo',$pag->codi_movi_mov) }}" data-toggle="tooltip" title="Ver pago">
                                    <button class="btn btn-success btn-sm">
                                       <i class="fas fa-receipt"></i>
                                       <span class="d-none d-lg-inline-block pl-2">Ver</span>
                                    </button>
                                 </a>
                              </td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection