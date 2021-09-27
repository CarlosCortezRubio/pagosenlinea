<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <title>Conservatorio Nacional de Música - Pagos</title>

      <!-- Fonts -->
      <link rel="stylesheet" href="{{ asset('css/fontawesome-all.min.css') }}">
      <!-- Styles -->
      <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('css/toastr.min.css') }}">

      @yield('styles')

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
         /*.nav-item:hover > .nav-link, 
         .nav-item > .nav-link:focus {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 0.25rem;
         }
         .nav-item > .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 0.25rem;
         }*/
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
                  <img src="{{ asset('img/logo_cnm_white.png') }}" alt="Conservatorio Nacional de M&uacute;sica" style="height:42px;">
               </a>

               <ul class="navbar-nav mr-auto"></ul>

               <!--<ul class="navbar-nav ml-auto">

                  @auth
                     @include('partials.user-panel')
                  @else
                     @if(!hasCartSignOut())
                        @if ( Route::is('register') )
                           <li class="nav-item">
                              <a class="nav-link" href="{{ route('login') }}" data-toggle="tooltip" title="Iniciar sesión">
                                 <i class="fas fa-sign-in-alt"></i>
                                 <span class="d-none d-md-inline-block pl-1">Iniciar sesi&oacute;n</span>
                              </a>
                           </li>
                        @else
                           @if ( !Route::is('admision') )
                              <li class="nav-item">
                                 <a class="nav-link" href="{{ route('register') }}" data-toggle="tooltip" title="Regístrese">
                                    <i class="far fa-address-book"></i>
                                    <span class="d-none d-md-inline-block pl-1">Reg&iacute;strese</span>
                                 </a>
                              </li>
                           @endif
                        @endif
                     @endif
                  @endauth
               </ul>-->
            </div>
         </nav>
         @auth
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark sidebar-dark-primary">
               <div class="container">
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                     <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                     <ul class="navbar-nav nav-sidebar">
                        <li class="nav-item">
                           <a class="nav-link pl-2"  style="border-radius: 0.25rem;" href="{{ route('home') }}">MIS PAGOS GENERADOS</a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link pl-2"  style="border-radius: 0.25rem;" href="{{ route('paid') }}">MIS PAGOS REALIZADOS</a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link pl-2"  style="border-radius: 0.25rem;" href="#">MIS PAGOS PROGRAMADOS</a>
                        </li>
                        
                     </ul>
                  </div>
                  
                  <a class="btn btn-success ml-auto" href="#" id="btnModalAddCart">
                     <i class="fas fa-plus pr-2"></i>Agregar Pago
                  </a>
                  <form id="cart-form" action="{{ route('cart') }}" method="GET" style="display: none;">
                     @csrf
                  </form>

                  @include('partials.cart-panel')
               </div>
            </nav>
         @endauth
         
      </header>

      <main class="py-md-4">
        
         <div class="content-header">
            <div class="container-fluid">
               <div class="clearfix">
                  <div class="container">
                     <div class="float-left">
                        @yield('content_header')
                     </div>
                     <div class="float-right">
                        @yield('content_header_command')
                     </div>
                  </div>
               </div>
            </div>
         </div>
         
         <section class="content">
            <div class="container-fluid">
               <!-- Contenido -->
               @yield('content')
            </div><!-- /.container-fluid -->
         </section>

         @auth
            @include('partials.add-cart')
         @endauth
      </main>

      <footer class="text-center mt-2">
         <div class="container">
            <p>
               <strong>Copyright &copy; {{ date('Y') }} - <a href="http://www.unm.edu.pe/" target="_blank">Conservatorio Nacional de Música</a>.</strong> Todos los derechos reservados.
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

         // Modal para agregar pagos
         $('#btnModalAddCart').click(function() {
            $('#modal-add-cart').find('input:text, select').val('');
            $('#modal-add-cart').modal({backdrop: 'static'});
         });

         // Concepto de pago
         $('#s_concepto').change(function() {
            $('#desc_conc_mov').val($('#s_concepto option:selected').data('desc_conc_pag'));
            $('#mnto_prec_mov').val($('#s_concepto option:selected').data('prec_conc_pag'));
            $('#cant_conc_mov').val('1');
            $('#mnto_subt_mov').val($('#s_concepto option:selected').data('prec_conc_pag'));
         });

         // seccion
         $('#s_seccion').change(function() {
            $('#desc_secc_mov').val($('#s_seccion option:selected').data('desc_tabl_det'));
         });

          // especialidad
          $('#s_especialidad').change(function() {
            $('#desc_espe_mov').val($('#s_especialidad option:selected').data('desc_tabl_det'));
         });

         // cantidad del Concepto de pago
         $('#cant_conc_mov').change(function() {
            var cant = $('#cant_conc_mov').val();
            var mnto = $('#mnto_prec_mov').val();
            $('#mnto_subt_mov').val(parseFloat(cant * mnto).toFixed(2));
         });
         $('#cant_conc_mov').keypress(function(event) {
            if(event.charCode >= 48 && event.charCode <= 57){
               return true;
            }
            return false;
         });
      });

      
   </script>

   @yield('scripts')
</body>
</html>
