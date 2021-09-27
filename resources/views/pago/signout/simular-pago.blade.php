<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <title>Universidad Nacional de Música</title>

      <!-- Fonts -->
      <link rel="stylesheet" href="{{ asset('css/fontawesome-all.min.css') }}">
      <!-- Styles -->
      <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('css/toastr.min.css') }}">

      <style>
         body::after {
            content: "";
            background-image: url("{{ asset('img/background.png') }}");
            opacity:0.1;
            position:fixed;
            top:0;
            bottom:0;
            right:0;
            left:0;
            z-index:-1;
         }
         input::placeholder {
            font-size: 14px;
            text-transform: none;
         }
         .td-right {
            text-align:right;
            padding-right:1rem;
         }
      </style>

      <!-- Icon -->
      <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
      <link rel="apple-touch-icon" href="{{ asset('img/apple-touch-icon.png') }}">
   </head>
<body>
   <div id="app" class="d-flex flex-column justify-content-between">
      <header>
         <nav class="navbar navbar-expand navbar-dark bg-primary shadow-sm">
            <div class="container">
               <a class="navbar-brand" href="http://www.unm.edu.pe/" target="_blank">
                  <img src="{{ asset('img/logo_unm_white.png') }}" alt="Conservatorio Nacional de M&uacute;sica" style="height:42px;">
               </a>

               @yield('title_module')

               <ul class="navbar-nav ml-auto">
               </ul>
            </div>
         </nav>

      </header>

      <main class="py-md-1">

         <div class="content-header">
            <div class="container-fluid">
               <div class="clearfix">
                  <div class="container">
                     
                  </div>
               </div>
            </div>
         </div>

         <section class="content">
            <div class="container-fluid">
               <div class="container d-flex justify-content-center align-items-center">
                  <div class="card card-primary card-outline text-center mx-auto elevation-2">
                     <div class="card-body">
                        
                        <form id="add-form" action="{{ route('external.simularPago.post') }}" method="POST">
                           @csrf
            
                           <input type="hidden" name="action" value="add">
                           <div class="form-group row">
                              <label for="cod_cip" class="col-form-label text-md-right col-md-4">Nro. CIP:</label>
                              <div class="col-md-5">
                                 <input type="text" name="cod_cip" id="cod_cip" class="form-control text-right">
                              </div>
                           </div>
                                         
                           <div class="form-group row">
                              <label for="mnto_pago" class="col-form-label text-md-right col-md-4">Monto Pago:</label>
                              <div class="col-md-5">
                                 <input type="text" name="mnto_pago" id="mnto_pago" class="form-control text-right" >
                              </div>
                           </div>
                          
                           <div class="row">
                              <div class="col">
                                 <button type="submit" class="btn btn-primary btn-block">
                                    Simular pago
                                 </button>
                              </div>
                              <div class="col">
                                 <button type="reset" class="btn btn-secondary btn-block" data-dismiss="modal">
                                    <i class="fas fa-undo-alt pr-2"></i>Limpiar
                                 </button>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div><!-- /.container-fluid -->
         </section>

        
      </main>

      <footer class="text-center mt-2">
         <div class="container">
            <p>
               <strong>Copyright &copy; {{ date('Y') }} - <a href="http://www.unm.edu.pe/" target="_blank">Universidad Nacional de Música</a>.</strong> Todos los derechos reservados.
            </p>
            <br>
            <p align="center" style="color:gray;"><small>Desarrollado por:</small><br>
               <a href="https://devcosol.pe" target="_blank">
                  <img src="{{ asset('img/devco.png') }}" style="width:110px;">
               </a>
            </p>
         </div>
      </footer>
   </div>

   <!-- Scripts -->
   <script src="{{ asset('js/jquery.min.js') }}"></script>
   <script src="{{ asset('js/popper.min.js') }}"></script>
   <script src="{{ asset('js/bootstrap.min.js') }}"></script>
   <script src="{{ asset('js/app.js') }}"></script>
   <script src="{{ asset('js/adminlte.min.js') }}"></script>
   <script src="{{ asset('js/toastr.min.js') }}"></script>

   <!-- Funciones generales -->
   <script type="text/javascript">
      $(document).ready( function(){
         @if (session('success'))
            toastr.options = {
               "progressBar": true,
               "positionClass": "toast-bottom-right",
            }
            toastr.success("{{ session('success') }}");
         @endif

         @if (session('status'))
            toastr.options = {
               "progressBar": true,
               "positionClass": "toast-bottom-right",
            }
            toastr.success("{{ session('status') }}");
         @endif

         @if (session('no_success'))
            toastr.options = {
               "positionClass": "toast-top-right",
            }
            toastr.error("{{ session('no_success') }}");
         @endif
      });
   </script>
</body>
</html>