/**todas as máscaras dos formulários do sistema */
$(document).ready(function() {
  /*
  $.ajax({
    url: 'https://randomuser.me/api/?gender=male',
    dataType: 'json',
    success: function(data) {
      console.log(data.results[0].picture.thumbnail);
      $('#img_user').attr('src',data.results[0].picture.thumbnail);
    }
  });
  */

  $('#divSearchResult').css('width',$('#divSearchContainer').width());

  //tags
  $('.tokenfield').tokenfield();

  $(".select2").select2();

  // Initialize with options
  $(".select-icons").select2({
      templateResult: iconFormat,
      minimumResultsForSearch: Infinity,
      templateSelection: iconFormat,
      escapeMarkup: function(m) { return m; }
  });



  // Initialize on button click
    $('.btn-loading-workflow').click(function () {
        var btn = $(this);
        var wrk_tipo = $(this).attr("wrk-tipo");
        btn.button('loading');
        addWorkflow(wrk_tipo);

        //setTimeout(function () {
        //    btn.button('reset')
        //}, 3000)

    });


    setMasks();
  //console.log('passei no default...');


  $(document).mouseup(function(e) {
      var container = $("#divSearchResult");
      // if the target of the click isn't the container nor a descendant of the container
      if (!container.is(e.target) && container.has(e.target).length === 0)
      {
          container.hide();
          $('#thSearchResult').html('<i class="icon-spinner spinner"></i> Buscando...');
          $('#tbodySearchResults').html('');
          $('#txt_search').val('');
      }
  });


    if($('#txt_search').length){
          //$('#txt_search').on('blur',function(){
          //    $('#divSearchResult').hide();
          //    $('#thSearchResult').html('<i class="icon-spinner spinner"></i> Buscando...');
          //    $('#tbodySearchResults').html('');
          //    $('#txt_search').val('');
          //});
          $('#txt_search').on('keyup',function(){
              //var wrk = $('#hdd_id_wrk').val();
              var search = $(this).val().trim();
              if(search.length < 3){
                  return;
              }//if

              $('#tbodySearchResults').html('');

              $.ajax({
                  url: 'ajax/ajax_search_antro.php',
                  data: '&q='+search,//'&wrk='+wrk+
                  dataType: 'json',
                  success: function(data) {
                    //console.log(data.results[0].picture.thumbnail);
                    //$('#img_user').attr('src',data.results[0].picture.thumbnail);

                    //console.log(data);
                    var intQtde   = data.length;
                    var strMsg    = (intQtde>0)?((intQtde==1)?"registro encontrado":"registros encontrados"):"Nenhum registro encontrado";
                    var cardResult = '';

                    if(intQtde > 0){
                      $('#thSearchResult').html('<strong>'+intQtde+'</strong> '+strMsg);
                      //$('#msg_busca').html('<strong>'+intQtde+'</strong> '+strMsg);
                      for(var i = 0; i < data.length; i++){
                          //highlightTask(data[i]);
                            cardResult = '<a href="javascript:addAntro('+data[i].ant_id+',\''+data[i].ant_nome+'\',\''+data[i].ant_descricao+'\');">';
                              //cardResult+= '<i class="icon-strategy position-left"></i>&nbsp;';
                              cardResult+= '<strong>';
                                  cardResult+= data[i].ant_nome;
                              cardResult+= '</strong>';
                              cardResult+= '<br />';
                              cardResult+= '<span>';
                                  cardResult+= data[i].ant_descricao;
                              cardResult+= '</span>';
                          cardResult+= '</a>';

                          $('#tbodySearchResults').append('<tr><td>'+cardResult+'</td></tr>');
                      }//for
                    }else{
                      //$('#msg_busca').html(strMsg);
                      $('#thSearchResult').html(strMsg);
                    }//if

                  },//success
                  beforeSend:function(){//
                      $('#divSearchResult').show();

                      $('#thSearchResult').html('<i class="icon-spinner spinner"></i> Buscando...');
                      $('#tbodySearchResults').html('');
                      //$('#msg_busca').html('<i class="icon-spinner spinner"></i> Buscando...');
                      //$('.box').find('.taskFound').each(function(){
                      //    $(this).removeClass('taskFound');
                      //});
                  },
                  complete: function(){
                      //setTimeout(function(){
                      //    $('.box').find('.taskFound').each(function(){
                      //        $(this).removeClass('taskFound');
                      //    },5000);
                      //});
                  }
                });
          });
      }//if

});

function addAntro(ant_id,ant_nome,ant_desc){
  if($('#tr_ant_'+ant_id).length)return;
  var template = '';
  template+='<tr id="tr_ant_'+ant_id+'">';
    template+='<td>'+ant_nome+'</td>';
    template+='<td><input type="text" class="form-control inpAntro" id="txt_ant_'+ant_id+'" size="5" value="" placeholder="Valor..." /></td>';
    template+='<td><a href="#" onclick="removeAntro('+ant_id+');"><i class="icon-trash"></i></a></td>';
  template+='</tr>';
  $('#tbAntropometria').append(template);
}//fnc
function removeAntro(ant_id){
  $('#tr_ant_'+ant_id).remove();
}//fnc
function lerAntro(){
  var strAntro = '';
  var idAnt,valAnt = '';
  $('.inpAntro').each(function(){
    idAnt = $(this).attr('id').replace(/[^0-9]+/g,'');
    valAnt = $(this).val().trim();
    if(idAnt!=''&&valAnt!='')strAntro+='['+idAnt+':'+valAnt+']';
  });;
  $('#hdd_antropometria').val(strAntro);
}//fnc
//-------------------------------------------
function goToTask(task,fase,wrk){
  console.log('goToTask('+task+','+fase+','+wrk+')');
  var bool_pode_abrir = false;
  if( $('#workflow').length ){
    if($('#divTsk_'+task).length){
      bool_pode_abrir = true;
    }//if
  }//if

  if(bool_pode_abrir){
    $('#modal_remote').modal('show');
    $('.nav-tabs a[href="#div_panel_atividades"]').tab('show');
    loadFormulario(task,fase);
  }else{
    document.location.href='./?mnu=2&page=workflow&act=dtl&id='+wrk+"&task="+task;
  }//if

}//if
function setMasks(){
  $("textarea:not(.noLimit),input[type=text].form-control:not(.noLimit)").maxlength({
      //threshold: 10,
      alwaysShow: true,
      placement: 'top-right',
      warningClass: 'label label-info'
  });
  $(".mask_data").mask('99/99/9999');
}//fnc

function addWorkflow(tipo){
    var lnk_dest = 'ajax/ajax_workflow_add.php';
    var str_now = getNowString();

    $.post(lnk_dest, { tipo:tipo,now : str_now },
        function(resposta){
            //console.log('resposta: '+resposta);
            document.location.href = './?page=workflow&id='+resposta+'&edit=1';
        }
    );

}//fnc
//-------------------------------------------


function myPNalert(titulo,texto,classe){
  if(classe == 'undefined' || classe == null)classe = 'warning';
  classe = 'alert alert-styled-left alert-arrow-left bg-' + classe;

  new PNotify({
        title: titulo,
        text: texto,
        addclass: classe,
        //icon: 'icon-warning'
        //type: classe
    });
}//fnc

function myPNConfirmMail(){

  new PNotify({
        title: 'Não esqueça!',
        text: 'Confira sua conta de e-mail e confirme seu endereço eletrônico',
        addclass: 'alert alert-styled-left alert-arrow-left bg-warning',
        //type: classe,
        confirm: {
                confirm: true,
                buttons: [
                    {
                        text: 'Re-enviar email',
                        addClass: 'btn btn-sm bg-warning',
                        click: function(notice) {

                              notice.update({
                                  title: 'Enviando e-mail',
                                  text: 'Por favor, aguarde.',
                                  icon: 'icon-spinner4 spinner',
                                  //type: 'success',
                                  hide: true,
                                  confirm: {
                                      confirm: false
                                  },
                                  buttons: {
                                      closer: false,
                                      sticker: false
                                  }
                              });

                              $.ajax({
                                url: 'ajax/ajax_send_email_confirmacao.php',
                                //dataType: 'json',
                                success: function(data) {
                                    notice.update({
                                        title: 'Email enviado!',
                                        text: 'Enviamos um novo email de confirmaçao.',
                                        icon: 'icon-paperplane',
                                        //type: 'success',
                                        hide: true,
                                        confirm: {
                                            confirm: false
                                        },
                                        buttons: {
                                            closer: true,
                                            sticker: false
                                        }
                                    });
                                }
                              });


                        }
                    },null
                ]
        }//confirm
    });
}//fnc

function enterKey(e){
    if(e.which == 13) {
        $(e.target).blur();
    }
}

function iconFormat(icon) {
    var originalOption = icon.element;
    if (!icon.id) { return icon.text; }
    var $icon = "<i class='icon-" + $(icon.element).data('icon') + "'></i>" + icon.text;

    return $icon;
}

  function scrollToTop(qtal){
    if(qtal == null || qtal == 'undefined' || qtal == '')qtal = 'slow';
    $('html,body').animate({ scrollTop: 0 }, qtal);
  }//fnc



function labelColor(onoff,quem){
  if(onoff){
    $('#'+quem).css('color','#f00');
  }else{
    $('#'+quem).css('color','');
  }//if
}//fnc


function addRegistro(extra){
  if(extra=='undefined' || extra == null)extra = '';
  var pagina = getParameterByName('page');
  var mnu = getParameterByName('mnu');
  var url_new = './?mnu='+mnu+'&page='+pagina+ '&act=frm&id=0'+extra;
  document.location.href=url_new;
}//fnc

function cancelEdit(){
  $('#div_form').hide();
  $('#div_lista').show();
}