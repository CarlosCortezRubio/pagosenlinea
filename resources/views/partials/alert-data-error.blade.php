@if (count($errors)>0)
   <div class="alert alert-danger alert-dismissible" role="alert">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <span><i class="icon fas fa-exclamation-triangle"></i></span>
      <strong>Se encontraron las siguientes inconsistencias:</strong>
      <ul>
         @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
         @endforeach
      </ul>
    </div>
@endif