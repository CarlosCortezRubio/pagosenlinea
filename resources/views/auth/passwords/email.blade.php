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
                  <form method="POST" action="{{ route('password.email') }}">
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

                     <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">
                           <i class="fas fa-share pr-2"></i>Enviar
                        </button>
                     </div>

                     <p class="text-justify text-blue mb-0">
                        <i class="fas fa-info-circle"></i>
                        <small>Se enviar&aacute; un enlace al correo electr&oacute;nico registrado, desde el cual podr&aacute; restablecer su contrase&ntilde;a.</small>
                     </p>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
