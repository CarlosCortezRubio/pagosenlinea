@extends('layouts.app')

@section('content')
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-lg-5 col-md-7 col-sm-9 col-xs-11">
            <div class="card card-primary card-outline elevation-2">
               <div class="card-header">
                  <strong>Restablecer contrase&ntilde;a</strong>
               </div>

               <div class="card-body">
                  <form method="POST" action="{{ route('password.update') }}">
                     @csrf

                     <input type="hidden" name="token" value="{{ $token }}">

                     <div class="form-group inputWithIcon">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="Correo electrónico">

                        @error('email')
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                        @enderror

                        <i class="fas fa-envelope fa-lg" aria-hidden="true"></i>
                     </div>

                     <div class="form-group inputWithIcon">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Nueva contraseña">

                        @error('password')
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                        @enderror

                        <i class="fas fa-key fa-lg" aria-hidden="true"></i>
                     </div>

                     <div class="form-group inputWithIcon">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmar nueva contraseña">

                        <i class="fas fa-key fa-lg" aria-hidden="true"></i>
                     </div>

                     <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">
                           <i class="fas fa-save pr-2"></i>Actualizar contraseña
                        </button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
