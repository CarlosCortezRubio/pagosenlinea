<li class="nav-item dropdown ml-auto" style="list-style:none;">
   <a id="navbarDropdown" class="nav-link" style="color:inherit;" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
      <i class="fas fa-shopping-cart"></i>
      @if(hasCart())
         <span class="badge badge-danger navbar-badge">{{ session('cart')->count() }}</span>
      @endif
      <span class="caret"></span>
   </a>
   @if(hasCart())
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" aria-labelledby="navbarDropdown">
         @foreach(getCart() as $pag)
            <div class="dropdown-item-text py-2">
               <div class="row" style="width: 100%;">
                  <div style="width: 70%; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">
                     <span class="text-gray" style="font-size:10px;" data-toggle="tooltip" title="{{ $pag['desc_conc_mov'] }}">
                        <i class="fas fa-angle-right pr-2"></i>{{ $pag['desc_conc_mov'] }}
                     </span>
                  </div>
                  <div style="width: 30%; text-align: right;">
                     <span class="text-gray" style="font-size:10px;" data-toggle="tooltip" title="{{ $pag['desc_conc_mov'] }}">
                        S/ {{ $pag['mnto_subt_mov'] }}
                     </span>
                  </div>
               </div>
            </div>
            <div class="dropdown-divider"></div>
         @endforeach
         <a href="{{ route('cart') }}" class="dropdown-item dropdown-footer">
            <i class="fas fa-clipboard-list pr-2"></i>Ver carrito
         </a>
      </div>
   @endif
</li>