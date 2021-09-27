@extends('layouts.app')

@section('content')
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-lg-5 col-md-7 col-sm-9 col-xs-11">
            <div class="card card-primary card-outline elevation-2">
               <div class="card-header">
                  <strong>Crear contraseña</strong>
               </div>
               <div class="card-body">
                  <form method="POST" action="{{ route('createPassword') }}">
                     {{ csrf_field() }}
                     <div class="form-group mb-2 inputWithIcon">
                        <input id="id" type="text" class="form-control" name="id" disabled value="{{ $solicitud->mail_soli_sol }}">
                        <i class="fa fa-user fa-lg" aria-hidden="true"></i>
                     </div>

                     <div class="form-group mb-2 inputWithIcon">
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Ingrese su contraseña...">

                        @if ($errors->has('password'))
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('password') }}</strong>
                           </span>
                        @endif

                        <i class="fa fa-edit fa-lg" aria-hidden="true"></i>
                     </div>

                     <div class="form-group mb-3 inputWithIcon">
                        <input id="password_confirm" type="password" class="form-control{{ $errors->has('password_confirm') ? ' is-invalid' : '' }}" name="password_confirm" required placeholder="Confirme su contraseña...">

                        @if ($errors->has('password_confirm'))
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('password_confirm') }}</strong>
                           </span>
                        @endif

                        <i class="fa fa-edit fa-lg" aria-hidden="true"></i>
                     </div>

                     <input type="hidden" name="tipo_docu" value="{{ $solicitud->tipo_docu_sol }}">
                     <input type="hidden" name="nume_docu" value="{{ $solicitud->nume_docu_sol }}">

                     <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-save pr-2"></i>Crear contraseña</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
