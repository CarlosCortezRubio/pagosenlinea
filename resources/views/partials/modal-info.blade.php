<div class="modal fade" aria-hidden="true" role="dialog" tabindex="-1" id="modal-info">
   <div class="modal-dialog" style="max-width: 600px;">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
            @if ($link)
               <div class="container justify-content-center align-items-center">
                  <div class="embed-responsive embed-responsive-1by1"> 
                     <iframe id="enlaceExterno" class="embed-responsive-item" src="{{$link}}" allowfullscreen></iframe>
                  </div>
               </div>
            @endif
         </div>
      </div>
   </div>
</div>
