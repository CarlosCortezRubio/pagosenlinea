@extends('layouts.email')

@section('title')
   Pago realizado con éxito
@endsection

@section('content')
   <p>Su pago se ha validado correctamente.</p>
   <p>Felicitaciones por este nuevo logro. Sé que es el primero de muchos más, contamos que tendrás un gran futuro en nuestra universidad. Te deseamos lo mejor de los éxitos.</p>

   {{--@include('partials.email-action-button', ['link'=>$enlace, 'label'=>'Inscripción al Proceso de Admisión'])--}}
   
 {{-- <p>Utilice las siguientes credenciales de acceso:</p>
  <div>
	 <table width="50%" cellpadding="2" cellspacing="2" role="presentation" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; margin:auto; padding:20px; text-align: center; width: 50%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 50%; border: 1px solid gray; line-height: 1em;">
		<tr><td><strong>Correo electrónico:</strong></td></tr>
		<tr><td style="padding-bottom:15px;">{{ $usuario }}</td></tr>
		<tr><td><strong>Contraseña:</strong></td></tr>
		<tr><td>{{ $contrasena }}</td></tr>
	 </table>
  </div> --}}
   
@endsection

@section('signature')
   Atentamente,
   <br>
   La Comisión de Admisión
@endsection
