@extends('layouts.app')

@section('content')
   @if ($link)
      <div class="container justify-content-center align-items-center">
         <div class="card card-primary card-outline elevation-2">
            <div class="card-body">
               <div class="embed-responsive embed-responsive-16by9"> 
                  <iframe id="enlacePago" class="embed-responsive-item" src="{{$link}}" allowfullscreen></iframe>
               </div>
            </div>
         </div>
      </div>
   @endif
@endsection