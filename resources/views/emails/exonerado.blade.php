@extends('layouts.email')

@section('title')
   Pago realizado con éxito
@endsection

@section('content')
   <p>Su pago se ha validado correctamente {{ $usuario }}</p>
   <p>Su proceso de inscripción se ha realizado con éxito. Al ser usted ingresante bajo la modalidad de exonerado, solo debe esperar la fecha de matrícula de la UNM la cual será publicada oportunamente.</p>
@endsection

@section('signature')
   Atentamente,
   <br>
   La Comisión de Admisión
@endsection
