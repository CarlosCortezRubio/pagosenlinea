<li class="nav-item dropdown">
   <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
      <i class="fas fa-user pr-1"></i>
      <span class="d-none d-md-inline-block">{{ auth()->user()->email }}</span>
      <span class="caret"></span>
   </a>
   <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" aria-labelledby="navbarDropdown">
      <div class="dropdown-item-text d-sm-none py-2">
         <span class="text-gray">
            <i class="fas fa-user pr-2"></i>
            {{ auth()->user()->email }}
         </span>
      </div>

      <div class="dropdown-divider d-sm-none"></div>
      <a class="dropdown-item text-logout" href="#"
         onclick="event.preventDefault();
         document.getElementById('logout-form').submit();">
         <i class="fas fa-sign-out-alt pr-2"></i>Cerrar sesión
      </a>

      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
         @csrf
      </form>
   </div>
</li>