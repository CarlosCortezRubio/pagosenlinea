@extends('layouts.app')

@section('content')
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-lg-5 col-md-7 col-sm-9 col-xs-11">
            <div class="card card-primary card-outline elevation-2">
               <div class="card-header">
                  <strong>Inicio de sesi&oacute;n</strong>
               </div>

               <div class="card-body">
                  <form method="POST" action="{{ route('login') }}">
                     @csrf

                     <div class="form-group inputWithIcon">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Correo electrónico">

                        @error('email')
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                        @enderror

                        <i class="fas fa-envelope fa-lg" aria-hidden="true"></i>
                     </div>

                     <div class="form-group inputWithIcon">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Contraseña">

                        @error('password')
                           <span class="invalid-feedback" role="alert">
                               <strong>{{ $message }}</strong>
                           </span>
                        @enderror

                        <i class="fas fa-key fa-lg" aria-hidden="true"></i>

                        @if (Route::has('password.request'))
                           <p class="text-right">
                              <a class="card-link" href="{{ route('password.request') }}">
                                 <strong>¿Olvidaste tu contraseña?</strong>
                              </a>
                           </p>
                        @endif
                     </div>

                     <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">
                           <i class="fas fa-sign-in-alt pr-2"></i>Iniciar sesión
                        </button>
                     </div>
                  </form>
                  <hr>
                  <a href="{{ route('register') }}">
                     <button type="button" class="btn btn-primary btn-block">
                        <i class="fas fa-address-book pr-2"></i>Reg&iacute;strate
                     </button>
                  </a>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
