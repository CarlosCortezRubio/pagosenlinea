@extends('layouts.app')

@section('content')
   @if (session()->has('message'))
      <div class="container d-flex justify-content-center align-items-center" style="height:300px;">
         <div class="card card-primary card-outline text-center mx-auto elevation-2">
            <div class="card-body">
               @include('auth.mensaje')
            </div>
         </div>
      </div>

   @else
      <div class="container">
         <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">

               <div class="card card-primary card-outline elevation-2">
                  <div class="card-header">
                     <strong>Registro de usuario</strong>
                  </div>
                  <div class="card-body">
                     <form method="POST" action="{{ url('register') }}">
                        @csrf

                        <div class="form-group selectWithIcon">
                           <select name="tipo_docu_sol" class="custom-select @error('tipo_docu_sol') is-invalid @enderror" autofocus required>
                              <option value="">Tipo de documento de identidad</option>
                              @foreach ($tDocumentos as $tdata)
                                 <option value="{{$tdata->codi_tabl_det}}">{{$tdata->abre_tabl_det}}</option>
                              @endforeach
                           </select>

                           @error('tipo_docu_sol')
                              <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                              </span>
                           @enderror

                           <i class="fas fa-tag fa-lg" aria-hidden="true"></i>
                        </div>

                        <div class="form-group inputWithIcon">
                           <input type="text" name="nume_docu_sol" class="form-control @error('nume_docu_sol') is-invalid @enderror" value="{{ old('nume_docu_sol') }}" placeholder="Número de documento de identidad" required maxlength="20">

                           @error('nume_docu_sol')
                              <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                              </span>
                           @enderror

                           <i class="fas fa-id-card fa-lg" aria-hidden="true"></i>
                        </div>

                        <div class="form-group inputWithIcon">
                           <input type="text" name="apel_pate_sol" class="text-uppercase form-control @error('apel_pate_sol') is-invalid @enderror" value="{{ old('apel_pate_sol') }}" placeholder="Apellido paterno" required maxlength="30">

                           @error('apel_pate_sol')
                              <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                              </span>
                           @enderror

                           <i class="fas fa-pen fa-lg" aria-hidden="true"></i>
                        </div>

                        <div class="form-group inputWithIcon">
                           <input type="text" name="apel_mate_sol" class="text-uppercase form-control @error('apel_mate_sol') is-invalid @enderror" value="{{ old('apel_mate_sol') }}" placeholder="Apellido materno" required maxlength="30">

                           @error('apel_mate_sol')
                              <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                              </span>
                           @enderror

                           <i class="fas fa-pen fa-lg" aria-hidden="true"></i>
                        </div>

                        <div class="form-group inputWithIcon">
                           <input type="text" name="nomb_pers_sol" class="text-uppercase form-control @error('nomb_pers_sol') is-invalid @enderror" value="{{ old('nomb_pers_sol') }}" placeholder="Nombres" required maxlength="40">

                           @error('nomb_pers_sol')
                              <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                              </span>
                           @enderror

                           <i class="fas fa-pen fa-lg" aria-hidden="true"></i>
                        </div>

                        <div class="form-group inputWithIcon">
                           <input type="text" name="telf_celu_sol" class="form-control @error('telf_celu_sol') is-invalid @enderror" value="{{ old('telf_celu_sol') }}" placeholder="Teléfono celular" required maxlength="20">

                           @error('telf_celu_sol')
                              <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                              </span>
                           @enderror

                           <i class="fas fa-mobile fa-lg" aria-hidden="true"></i>
                        </div>

                        <div class="form-group inputWithIcon">
                           <input type="email" name="mail_soli_sol" class="form-control @error('mail_soli_sol') is-invalid @enderror" value="{{ old('mail_soli_sol') }}" required placeholder="Correo electrónico" maxlength="100">

                           @error('mail_soli_sol')
                              <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                              </span>
                           @enderror

                           <i class="fas fa-envelope fa-lg" aria-hidden="true"></i>
                        </div>

                        <div class="form-group float-right">
                           <a href="{{ route('login') }}" class="card-link">
                              <strong>&#191;Ya te encuentras registrado&#63;</strong>
                           </a>
                        </div>

                        <div class="form-group">
                           <button type="submit" class="btn btn-primary btn-block" disabled>
                              <i class="fas fa-share-square pr-2"></i>Registrarme
                           </button>
                        </div>

                        <p class="text-justify text-blue mb-0">
                           <i class="fas fa-info-circle"></i>
                           <small>Recibir&aacute;s un enlace en el correo electr&oacute;nico proporcionado, desde el cual podr&aacute;s completar el registro.</small>
                        </p>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   @endif
@endsection

@section('scripts')
   <script src="https://www.google.com/recaptcha/api.js?render={{ config('app.captcha_key') }}"></script>
   <script>
      grecaptcha.ready(function() {
          grecaptcha.execute("{{ config('app.captcha_key') }}", {action: '/'}).then(function(token) {

          });
      });
   </script>
@endsection