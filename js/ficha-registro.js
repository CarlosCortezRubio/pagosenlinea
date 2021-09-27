// Premilinar fotos
function filePreview(input) {
   if (input.files && input.files[0]) {

      var reader = new FileReader();

      getOrientation(input.files[0], function(orientation){
         rotate($("#" + $(input).data('img')), orientation, 1);
      });

      reader.onload = function (e) {
         $("#" + $(input).data('img')).attr("src", e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
   }
}

// Setear valor del modal Ubigeo
function setUbigeo(button) {
   $('#ubig_domi_per').val($(button).data('id'));
   $('#luga_naci_per').val($(button).data('id')+' - '+
                           $(button).data('dpto')+', '+
                           $(button).data('prov')+', '+
                           $(button).data('dist'));
   $('#modal-ubigeo').modal('hide');
}

$(document).ready( function() {
   // Inicializa pluggins
   $('#flag_corr_pos').bootstrapToggle();
   $('[data-toggle="popover"]').popover();

   //Preliminar fotos
   $('#foto1, #foto2').change(function () {
      filePreview(this);
   });

   // Mostrar correpetidor
   $('#flag_corr_pos').change(function() {
      if ($(this).prop('checked')) {
         $('#divCorrepetidor').removeClass('d-none');
      } else {
         $('#divCorrepetidor').addClass('d-none');
      }
   });

   // Activa botón Enviar
   $('#cbox1, #cbox2').change(function(){
      if ($('#cbox1').prop('checked') &&
          $('#cbox2').prop('checked')) {

         $('#btnEnviar').prop('disabled', false);
      } else {
         $('#btnEnviar').prop('disabled', true);
      }
   });

   // Enviar ficha
   $('#btnConfirm').click(function() {
      $('#modal-confirm').modal('hide');
   });

   // Modal Ubigeo
   $('#tblBusqUbigeo').DataTable({
      "language": {
         "url": "../js/datatables.spanish.json"
      },
      "order": [[ 1, "asc" ]],
      "info": false,
      "stateSave": true,
      "columnDefs": [
         { "orderable": false, "targets": 0 }
      ]
   });

   $('#modal-ubigeo').on('shown.bs.modal', function (e) {
      $('#tblBusqUbigeo_filter input[type=search]').focus();
   });

   /* ----- DETALLE -----*/

   // Agregar repertorio
   $('#btnItemRepertoryAdd').click(function() {
      $('#modal-repertory').find('.modal-header').html('<strong><i class="fas fa-plus pr-2"></i>Agregar Repertorio</strong>');
      $('#modal-repertory').find('input:text, input:hidden').val('');
      $('#modal-repertory').modal({backdrop: 'static'});
   });

   // OK - Repertorio
   $('#btnItemRepertoryOK').click(function() {
      var tr = $('#table-repertory').find('.itemActive');
      var id = $.trim($('#modal-repertory').find('#codi_repe_rep').val());
      var autor = $.trim($('#modal-repertory').find('#auto_repe_rep').val());
      var obra = $.trim($('#modal-repertory').find('#obra_repe_rep').val());
      var duracion = $.trim($('#modal-repertory').find('#dura_repe_rep').val());
      var nduracion = parseInt(duracion);
      var data_ok = true;

      if (autor=='') {
         data_ok = false;
         alert('Debe especificar al compositor.');

      } else if (obra=='') {
            data_ok = false;
            alert('Debe especificar la obra.');

      } else if (duracion=='' || isNaN(duracion) || nduracion < 1 || nduracion > 60) {
         data_ok = false;
         alert('La duración debe ser un valor entero entre 1 y 60.');
      }

      if (data_ok) {
         if (id.length > 0) {
            tr.data('codi_repe_rep', id);
            tr.data('auto_repe_rep', autor);
            tr.data('obra_repe_rep', obra);
            tr.data('dura_repe_rep', duracion);
            tr.children('td:eq(0)').text(autor);
            tr.children('td:eq(1)').text(obra);
            tr.children('td:eq(2)').text(duracion+' min.');

         } else {
            var tr_html = '<tr data-codi_repe_rep="0"'+
                              'data-auto_repe_rep="'+autor+'"'+
                              'data-obra_repe_rep="'+obra+'"'+
                              'data-dura_repe_rep="'+duracion+'">'+
                              '<td>'+autor+'</td>'+
                              '<td>'+obra+'</td>'+
                              '<td style="width:15%;">'+duracion+' min.</td>'+
                              '<td style="width:20%;">'+
                                 '<button type="button" class="btn btn-info btn-sm btnItemRepertoryEdit">'+
                                    '<i class="far fa-edit"></i><span class="d-none d-lg-inline-block pl-2">Editar</span>'+
                                 '</button>'+
                                 '<button type="button" class="btn btn-danger btn-sm btnRemoveItem">'+
                                    '<i class="far fa-trash-alt"></i><span class="d-none d-lg-inline-block pl-2">Quitar</span>'+
                                 '</button>'+
                              '</td>'+
                          '</tr>';

            $('#table-repertory tbody').append(tr_html);
         }

         // Crea inputs
         $('.div-repertory').remove();
         $('#table-repertory tbody tr').each(function (index) {
            var input_html = '<div class="div-repertory">'+
                                '<input type="hidden" name="auto_repe_rep[]" value="'+$(this).data('auto_repe_rep')+'">'+
                                '<input type="hidden" name="obra_repe_rep[]" value="'+$(this).data('obra_repe_rep')+'">'+
                                '<input type="hidden" name="dura_repe_rep[]" value="'+$(this).data('dura_repe_rep')+'">'+
                             '</div>';

            $('#table-repertory tbody').append(input_html);
         });

         $('#modal-repertory').modal('hide');
         $('#table-repertory').find('.itemActive').removeClass('itemActive');
      }
   });

   // Agregar trabajo
   $('#btnItemJobAdd').click(function() {
      $('#modal-jobs').find('.modal-header').html('<strong><i class="fas fa-plus pr-2"></i>Agregar Trabajo</strong>');
      $('#modal-jobs').find('input:text, input:hidden').val('');
      $('#modal-jobs').modal({backdrop: 'static'});
   });

   // OK - Trabajo
   $('#btnItemJobOK').click(function() {
      var tr = $('#table-jobs').find('.itemActive');
      var id = $.trim($('#modal-jobs').find('#codi_trab_tra').val());
      var obra = $.trim($('#modal-jobs').find('#obra_trab_tra').val());
      var instrumento = $.trim($('#modal-jobs').find('#inst_trab_tra').val());
      var comentario = $.trim($('#modal-jobs').find('#comn_trab_tra').val());
      var data_ok = true;

      if (obra=='') {
         data_ok = false;
         alert('Debe especificar la obra.');
      }

      if (data_ok) {
         if (id.length > 0) {
            tr.data('codi_trab_tra', id);
            tr.data('obra_trab_tra', obra);
            tr.data('inst_trab_tra', instrumento);
            tr.data('comn_trab_tra', comentario);
            tr.children('td:eq(0)').text(obra);
            tr.children('td:eq(1)').text(instrumento);
            tr.children('td:eq(2)').text(comentario);

         } else {
            var tr_html = '<tr data-codi_trab_tra="0"'+
                              'data-obra_trab_tra="'+obra+'"'+
                              'data-inst_trab_tra="'+instrumento+'"'+
                              'data-comn_trab_tra="'+comentario+'">'+
                              '<td>'+obra+'</td>'+
                              '<td>'+instrumento+'</td>'+
                              '<td>'+comentario+'</td>'+
                              '<td style="width:20%;">'+
                                 '<button type="button" class="btn btn-info btn-sm btnItemJobEdit">'+
                                    '<i class="far fa-edit"></i><span class="d-none d-lg-inline-block pl-2">Editar</span>'+
                                 '</button>'+
                                 '<button type="button" class="btn btn-danger btn-sm btnRemoveItem">'+
                                    '<i class="far fa-trash-alt"></i><span class="d-none d-lg-inline-block pl-2">Quitar</span>'+
                                 '</button>'+
                              '</td>'+
                          '</tr>';

            $('#table-jobs tbody').append(tr_html);
         }

         // Crea inputs
         $('.div-jobs').remove();
         $('#table-jobs tbody tr').each(function (index) {
            var input_html = '<div class="div-jobs">'+
                                '<input type="hidden" name="obra_trab_tra[]" value="'+$(this).data('obra_trab_tra')+'">'+
                                '<input type="hidden" name="inst_trab_tra[]" value="'+$(this).data('inst_trab_tra')+'">'+
                                '<input type="hidden" name="comn_trab_tra[]" value="'+$(this).data('comn_trab_tra')+'">'+
                             '</div>';

            $('#table-jobs tbody').append(input_html);
         });

         $('#modal-jobs').modal('hide');
         $('#table-jobs').find('.itemActive').removeClass('itemActive');
      }
   });
});

// Editar repertorio
$(document).on('click', '.btnItemRepertoryEdit', function (event) {
   event.preventDefault();
   var tr = $(this).closest('tr');

   $('#table-repertory').find('.itemActive').removeClass('itemActive');
   tr.addClass('itemActive');
   $('#modal-repertory').data('tr', tr.id);
   $('#modal-repertory').find('.modal-header').html('<strong><i class="far fa-edit pr-2"></i>Editar Repertorio</strong>');
   $('#modal-repertory').find('#codi_repe_rep').val(tr.data('codi_repe_rep'));
   $('#modal-repertory').find('#auto_repe_rep').val(tr.data('auto_repe_rep'));
   $('#modal-repertory').find('#obra_repe_rep').val(tr.data('obra_repe_rep'));
   $('#modal-repertory').find('#dura_repe_rep').val(tr.data('dura_repe_rep'));
   $('#modal-repertory').modal({backdrop: 'static'});
});

// Editar trabajo
$(document).on('click', '.btnItemJobEdit', function (event) {
   event.preventDefault();
   var tr = $(this).closest('tr');

   $('#table-jobs').find('.itemActive').removeClass('itemActive');
   tr.addClass('itemActive');
   $('#modal-jobs').data('tr', tr.id);
   $('#modal-jobs').find('.modal-header').html('<strong><i class="far fa-edit pr-2"></i>Editar Trabajo</strong>');
   $('#modal-jobs').find('#codi_trab_tra').val(tr.data('codi_trab_tra'));
   $('#modal-jobs').find('#obra_trab_tra').val(tr.data('obra_trab_tra'));
   $('#modal-jobs').find('#inst_trab_tra').val(tr.data('inst_trab_tra'));
   $('#modal-jobs').find('#comn_trab_tra').val(tr.data('comn_trab_tra'));
   $('#modal-jobs').modal({backdrop: 'static'});
});

// Borrar items
$(document).on('click', '.btnRemoveItem', function (event) {
   event.preventDefault();
   $(this).closest('tr').remove();
});

// leer la configuracion de una imagen
function getOrientation(file, callback) {
  var reader = new FileReader();
  reader.onload = function(e) {

    var view = new DataView(e.target.result);
    if (view.getUint16(0, false) != 0xFFD8) return callback(-2);
    var length = view.byteLength, offset = 2;
    while (offset < length) {
      var marker = view.getUint16(offset, false);
      offset += 2;
      if (marker == 0xFFE1) {
        if (view.getUint32(offset += 2, false) != 0x45786966) return callback(-1);
        var little = view.getUint16(offset += 6, false) == 0x4949;
        offset += view.getUint32(offset + 4, little);
        var tags = view.getUint16(offset, little);
        offset += 2;
        for (var i = 0; i < tags; i++)
          if (view.getUint16(offset + (i * 12), little) == 0x0112)
            return callback(view.getUint16(offset + (i * 12) + 8, little));
      }
      else if ((marker & 0xFF00) != 0xFF00) break;
      else offset += view.getUint16(offset, false);
    }
    return callback(-1);
  };
  reader.readAsArrayBuffer(file);
}


function rotate(elem, orientation) {
  var isChanged = false;
    if (isIPhone()) return;

    var degree = 0;
    switch (orientation) {
        case 1:
            degree = 0;
            break;
        case 2:
            degree = 0;
            break;
        case 3:
            degree = 180;
            break;
        case 4:
            degree = 180;
            break;
        case 5:
            degree = 90;
            break;
        case 6:
            degree = 90;
            break;
        case 7:
            degree = 270;
            break;
        case 8:
            degree = 270;
            break;
    }
    $(elem).css('transform', 'rotate('+ degree +'deg)')

    if(degree == 90 || degree == 270) {
      if (!isChanged) {
        changeWidthAndHeight90(elem);
        isChanged = true
      }
    } else if(degree == 180 || degree == 0){
      if (!isChanged) {
        changeWidthAndHeight180(elem);
        isChanged = true
      }
    }
}

function changeWidthAndHeight90(elem){
    var e = $(elem)
    e.css('max-width', '160px')
    e.css('max-height', '200px')
    e.css('margin-bottom','10px')
}

function changeWidthAndHeight180(elem){
    var e = $(elem)
    e.css('max-width', '200px')
    e.css('max-height', '160px')
    e.css('margin-bottom','0px')
}


function isIPhone(){
    return (
        (navigator.platform.indexOf("iPhone") != -1) ||
        (navigator.platform.indexOf("iPod") != -1)
    );
}