@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-sm-9 col-xs-11">
                <div class="card mt-3 shadow border border-primary">
                    <div class="card-body">
                        <div class="mb-4">
                            <img src="{{asset('img/SIG.png')}}" alt="Sistema Integrado de Gesti&oacute;n" width="100%">
                        </div>
                        <form method="POST" action="{{ route('changePassword') }}">
                            {{ csrf_field() }}
                            <p style="color:#014E78; margin-left:2px;"><strong>Cambiar contraseña:</strong></p>
                            <div class="form-group mb-2 inputWithIcon">
                                <input id="id" type="text" class="form-control" name="id" disabled value="{{ auth()->user()->id }}">
                                <i class="fa fa-user fa-lg" aria-hidden="true"></i>
                            </div>

                            <div class="form-group mb-2 inputWithIcon">
                                <input id="current_password" type="password" class="form-control{{ $errors->has('current_password') ? ' is-invalid' : '' }}" name="current_password" required placeholder="Ingrese su contraseña actual...">

                                @if ($errors->has('current_password'))
                                 <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('current_password') }}</strong>
                                    </span>
                                @endif

                                <i class="fa fa-lock fa-lg" aria-hidden="true"></i>
                            </div>

                            <div class="form-group mb-2 inputWithIcon">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Ingrese su nueva contraseña...">

                                @if ($errors->has('password'))
                                 <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif

                                <i class="fa fa-edit fa-lg" aria-hidden="true"></i>
                            </div>

                            <div class="form-group mb-3 inputWithIcon">
                                <input id="password_confirm" type="password" class="form-control{{ $errors->has('password_confirm') ? ' is-invalid' : '' }}" name="password_confirm" required placeholder="Confirme su nueva contraseña...">

                                @if ($errors->has('password_confirm'))
                                 <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('password_confirm') }}</strong>
                                    </span>
                                @endif

                                <i class="fa fa-edit fa-lg" aria-hidden="true"></i>
                            </div>

                            <div class="form-group row">
                                <div class="d-none d-md-block col-md-5 col-lg-5">
                                    <button id="btnCancel" class="btn btn-secondary btn-block" type="button"><i class="fas fa-undo pr-2"></i>Regresar</button>
                              </div>

                        <div class="col-sm-12 col-md-7 col-lg-7">
                           <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-save pr-2"></i>Cambiar contraseña</button>
                        </div>

                                <div class="d-md-none d-lg-none d-xl-none col-sm-12 pt-2">
                                    <button id="btnCancel2" class="btn btn-secondary btn-block" type="button"><i class="fas fa-undo pr-2"></i>Regresar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
