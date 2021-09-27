@extends('layouts.email')

@section('title')
   Confirma tu correo electrónico
@endsection

@section('content')
   <p>Por favor, confirma tu correo haciendo clic en el siguiente enlace:</p>

   @include('partials.email-action-button', ['link'=>$enlace, 'label'=>'Confirmar correo electrónico'])

   <p>Este enlace estará disponible por 60 minutos desde su recepción.</p>
@endsection

@section('signature')
   Atentamente,
   <br>
   Unidad de Tesorería
@endsection
