@extends('pago.template')
@section('header')
     <div>
      <div>
         <table id="reportesTabla" align="left" style="width: 100%">
            <tr>
               <td width="22%"></td>
               <td width="18%"></td>
               <td width="20%"></td>
               <td width="20%"></td>
               <td width="20%"></td>
            </tr>
            <tr>
               <td colspan="3"><img src="{{asset('img/logo_cnm.png')}}" alt="Picture" style="max-height:50px"></td>
               <td colspan="2" rowspan="2"> 
                  <table width="100%" height="100%" cellpadding="2" cellspacing="0" style="border-collapse:separate; border: 1px solid #003872; border-radius: 9px; -moz-border-radius: 9px; -webkit-border-radius:9px; padding: 10px; text-align: center;"> 
                     <tr><th><span style="font-size:15px;">R.U.C 20123456789</span></th></tr>
                     <tr><th><span style="font-size:15px;">RECIBO DE PAGO</span></th></tr> 
                     <tr><th><span style="font-size:15px;">Nº E3 - 2021007313</span></th></tr> 
                  </table>
               </td>
            </tr>
            <tr style="text-align: center; line-height:7px;">
               <td colspan="3">
                  <span style="font-size:7px;"><strong>OFICINA DE ADMINISTRACIÓN<br>AREA DE ECONOMÍA</strong></span>
                  <span style="font-size:7px;"><br>JR. CARABAYA Nº 429 - LIMA - PERÚ<br>TELEF.: 426-9677 - 426-5554 - D.A. 426-5659<br>Cursos Libres de Extensión Telf.: 426-9830 Dir. PAM Telf.: 426-5764</span>
               </td>
            </tr>
            <tr style="height:5px;">
               <td colspan="3"></td>
            </tr>
            <tr>
               <td colspan="5"><span style="font-size:8px;"><strong>DATOS DEL USUARIO:</strong></span></td>
            </tr>
            <tr>
               <td colspan="1"><span style="font-size:8px;">Apellidos y Nombres</span></td>
               <td colspan="4"><span style="font-size:8px;">: EDUARDO CAHUANA JUAREZ</span></td>
            </tr>
            <tr>
               <td colspan="1"><span style="font-size:8px;">Documento de Identidad</span></td>
               <td colspan="2"><span style="font-size:8px;">: DNI - 12345678</span></td>
               <td colspan="1" align="right"><span style="font-size:8px;">Fecha Emisión:</span></td>
               <td colspan="1"><span style="font-size:8px;">18/10/2021</span></td>
            </tr>
         </table>
      </div>
   </div>
@endsection

@section('content')
     <div>
      <div>
         <table align="left" style="width: 100%">
            
               <td colspan="5">
                  <table id="detalles" width="100%" cellspacing="0" cellpadding="5" style="border-collapse:separate; border: 1px solid #003872; border-radius: 9px; padding: 5px;">
                     <tr>
                        <th colspan="1" width="45px" style="border-bottom: 1px solid black;"><span style="font-size:8px;">Sección</span></th>
                        <th colspan="1" width="50px" style="border-bottom: 1px solid black;"><span style="font-size:8px;">Especialidad</span></th>
                        <th colspan="1" style="border-bottom: 1px solid black;"><span style="font-size:8px;">Concepto</span></th>
                        <th colspan="1" width="38px" style="border-bottom: 1px solid black; text-align: right;"><span style="font-size:8px;">Sub Total</span></th>
                        <th colspan="1" width="38px" style="border-bottom: 1px solid black; text-align: right;"><span style="font-size:8px;">Mora</span></th>
                        <th colspan="1" width="38px" style="border-bottom: 1px solid black; text-align: right;"><span style="font-size:8px;">Total</span></th>
                     </tr>
                    
                        <tr style="vertical-align:top;">
                           <td><span style="font-size:8px;">OTROS</span></td>
                           <td><span style="font-size:8px;">GUITARRA</span></td>
                           <td><span style="font-size:8px;">INSCRIPCION</span></td>
                           <td style="text-align: right;"><span style="font-size:8px;">100.00</span></td>
                           <td style="text-align: right;"><span style="font-size:8px;">0.00</span></td>
                           <td style="text-align: right;"><span style="font-size:8px;">100.00</span></td>
                        </tr>
                    
                     <tr>
                        <td></td>
                        <td colspan="2"></td>
                        <td style="border-top: 1px solid black; text-align: right;"><span style="font-size:8px;">100.00</span></td>
                        <td style="border-top: 1px solid black; text-align: right;"><span style="font-size:8px;">0.00</span></td>
                        <td style="border-top: 1px solid black; text-align: right;"><span style="font-size:8px;">100.00</span></td>
                     </tr>
                  </table>
               </td>
            {{--  <tr style="height:5px; line-height:8px;">
               <td colspan="3" style="vertical-align:top; padding-top:15px;">
                     <span style="font-size:6px;">M&eacute;todo de Pago: Dep&oacute;sitos y transferencias</span><br>
                     <span style="font-size:6px;">Entidad Recaudadora: </span>
                     <span style="font-size:6px;">PagoEfectivo</span>
                     <br>
                     <span style="font-size:6px;">C&oacute;digo de Operaci&oacute;n: 80094853</span>
               </td>
               <td style="text-align: right; vertical-align:top;" colspan="2">
                 
               </td>
            </tr>--}}
         </table>
      </div>
   </div>
@endsection

