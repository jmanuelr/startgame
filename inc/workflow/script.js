/*
 var lastScrollLeft = 0;
$(window).scroll(function() {
    var documentScrollLeft = $(document).scrollLeft();
    if (lastScrollLeft != documentScrollLeft) {
        //horizontal scroll
        lastScrollLeft = documentScrollLeft;
        $(document).scrollTop($(document).scrollLeft());
    } else {
            //vertical scroll
        $(document).scrollLeft($(document).scrollTop());
    }
});
*/
 // Format icon

var sorTablePhase = null;
var sorTableQuestion = null;

$(function() {

    //modal load form by phase
    // Load remote content
    $('#modal_remote').on('show.bs.modal', function(objeto) {
        //$('#div_panel_cliente').removeClass('active');
        //$('#div_panel_atividades').removeClass('active');

    	var tsk = $(objeto.relatedTarget).attr('tsk');
        var fse = $(objeto.relatedTarget).attr('fse');
        if(fse == null || fse == '' || fse == 'undefined'){
            fse = (tsk==0)?$('#workflow').attr('fse'):$(objeto.relatedTarget).parents('.box').attr('fase');
        }//if
        //console.log('tsk: '+$(objeto.relatedTarget).attr('tsk'));
        //console.log('fase: '+$(objeto.relatedTarget).parents('.box').attr('fase'));
        //console.log('fse: '+fse);
        //alert($(objeto.relatedTarget).attr('tsk'));
        if(tsk > 0){
            //console.log('whastisthebrother');
            $('.nav-tabs a[href="#div_panel_atividades"]').tab('show');
            loadFormulario(tsk,fse);
        }else{
            $('.nav-tabs a[href="#div_panel_cliente"]').tab('show');
            criaTask();
        }//if
    });

    //fase list itens-------
    var containers = $('.dropdown-menu-sortable').toArray();
    // Init dragula
    dragula(containers, {
        mirrorContainer: document.querySelector('.dropdown-menu-sortable'),
        revertOnSpill: true,
        moves: function (el, container, handle) {
            return handle.classList.contains('dragula-handle');
        }
    });

    // Dragula workflow tasks------------
    // ------------------------------
    if($('#workflow').length){
        var arrContainer = $('.media-list-target').toArray();


        // Init dragula
        var drake = dragula(arrContainer, {
            mirrorContainer: document.querySelector('.media-list-container'),
            revertOnSpill: true,
            moves: function (el, container, handle) {
                return handle.classList.contains('dragula-handle');
            }

        }).on('drag', function (el, container) {
            if($(el).attr('condicao')==0){
                alert('Esta Tarefa possui atividades obrigatórias que ainda não foram cumpridas!');
                $(this).cleanup();
                return false;
            }//if
            //console.log('el status: '+$(el).attr('status') + ' fase: '+$(el).attr('fase'));
            //console.log('DRAG container: '+$(container).attr('id') + ' task: '+$(el).attr('id') + ' fase: '+$(el).attr('fase'));
            //this.cleanup();
            //return false;

        }).on('drop', function (el, container) {
            //$(el).remove();
            //$(source).append(el);

            //alert('NAO');
            //$(this).cleanup();
            //return false;

            //console.log('el status: '+$(el).attr('status') + ' fase: '+$(el).attr('fase') + ' task: '+$(el).attr('id'));
            //console.log('DROP container: '+$(container).attr('id'));

            var fase_origem = $(el).attr('fase');
            var tsk_id = $(el).attr('tsk');

            //atualiza fase
            var fase_alvo = $(container).attr('id');
            fase_alvo = fase_alvo.replace(/[^0-9]/ig,'');
            $(el).attr('fase',fase_alvo);

            mudaTask(tsk_id,fase_alvo,fase_origem);

        }).on('over', function (el, container) {
            //console.log('OVER container: '+$(container).attr('id'));
        }).on('out', function (el, container) {
            //console.log('OUT container: '+$(container).attr('id'));
        });

        //var drake = dragula([document.querySelector('#list'), document.querySelector('#hlist')]);
            var scroll = autoScroll([
                //document.querySelector('#list-container'),
                document.querySelector('#workflow')
            ],{
            margin: 20,
            maxSpeed: 10,
            scrollWhenOutside: true,
            autoScroll: function(){
                //Only scroll when the pointer is down, and there is a child being dragged.
                return this.down && drake.dragging;
            }
        });
    }//if
    //---------------------------------------

    // Placeholder
    $( ".selectable-demo-list" ).sortable({
        placeholder: "sortable-placeholder",
        start: function(e, ui){
            ui.placeholder.height(ui.item.outerHeight());
        },
        stop: function( ) {
            var order = $(this).sortable("toArray");//, {key:'order[]'}
            //console.log(order);
            //$( '#div_log' ).html('0');
            var tipo = '';
            var tmp_idli = '';
            var tmp_iditem = '';
            var tmp_str = '';
            for (var i = 0; i < order.length; i++) {
                tmp_idli = order[i];
                if(tipo==''){
                    if(tmp_idli.indexOf('_fse_')>0){
                        tipo = 'fse';
                    }else if(tmp_idli.indexOf('_qst_')>0){
                        tipo = 'qst';
                    }//if
                }//if
                //tmp_iditem = tmp_idli.replace(/[^0-9]/g);

                tmp_str += ','+$('#'+tmp_idli).attr(tipo);


            }//for
            salvaOrdemLista(tipo,tmp_str);
        }
    });
    $( ".selectable-demo-list" ).disableSelection();

    //---------------------------------------




    setaTriggers();
    setaAfterLoad();

    //verificaCondicoes();
    /*
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
    */

    document.addEventListener('mousemove', this._onMouseMove);


});

function verificaCondicoes(){
    $('.taskDiv').each(function(){
        var condicao = parseInt($(this).attr('condicao'));
        console.log('condicao: '+condicao);
        $(this).find('.dragula-handle').each(function(){
            if(condicao==0){
                //$(this).hide();
            }else{
                //$(this).show();
            }//if
        });
    });
}//fnc

function verificaCondicoesEspecificas(tsk,fse){
    var intQtdeObrigatorios = $('#divQuestionList_fse_'+fse+'_tsk_'+tsk+' .chkQuestionObrigatorio').length;
    var intQtdeChecked      = $('#divQuestionList_fse_'+fse+'_tsk_'+tsk+' .chkQuestionObrigatorio:checked').length;
    var condicao            = 0;

    var bool_preencheu_custom_fields = true;
    $('#divCustomFieldsList_fse_'+fse+'_tsk_'+tsk+' .inpQuestionObrigatorio').each(function(){
        if($(this).val().trim()==""){
            bool_preencheu_custom_fields = false;
            console.log($(this).attr('id')+' = '+$(this).val())
        }//if
    });
    //

    console.log('divQuestionList_fse_'+fse+'_tsk_'+tsk+'');
    console.log( $('#divQuestionList_fse_'+fse+'_tsk_'+tsk+' .chkQuestionObrigatorio').length );
    console.log( $('#divQuestionList_fse_'+fse+'_tsk_'+tsk+' .chkQuestionObrigatorio:checked').length );
    console.log( $('#divQuestionList_fse_'+fse+'_tsk_'+tsk+' .inpQuestionObrigatorio').length );

    if(intQtdeObrigatorios > intQtdeChecked || !bool_preencheu_custom_fields){
        condicao = 0;
    }else{
        condicao = 1;
    }//if

    $('#divTsk_'+tsk).attr('condicao',condicao);

    console.log('condicao: '+condicao);

    $('#divTsk_'+tsk).find('.dragula-handle').each(function(){
        if(condicao==0){
            //$(this).hide();
        }else{
            //$(this).show();
        }//if
    });


}//fnc

function highlightTask(data){
    //console.log(data);
    var bool_achou = false;

    $('.taskDiv').each(function(){
        //console.log($(this).attr('tsk') +' : '+ data.tsk_id);
        if( parseInt( $(this).attr('tsk') ) == data.tsk_id ){
            //console.log(data.tsk_id);
            $(this).find('.panel').each(function(){
                $(this).addClass('taskFound');
                bool_achou = true;
            });
        }//if
    });

    if(bool_achou){
        return;
    }//if

    var htmlCard      = $('#divTemplateTask').html();
    htmlCard = htmlCard.replace(/{tsk_id}/g,data.tsk_id);
    htmlCard = htmlCard.replace(/{tsk_pai}/g,data.tsk_pai);
    htmlCard = htmlCard.replace(/{tsk_titulo}/g,data.tsk_titulo);
    htmlCard = htmlCard.replace(/{tsk_status}/g,data.tsk_status);
    htmlCard = htmlCard.replace(/{tsk_class_alerta}/g,data.tsk_class_alerta);
    htmlCard = htmlCard.replace(/{tsk_cln_nome}/g,data.tsk_cln_nome);
    htmlCard = htmlCard.replace(/{fse_id}/g,data.fse_id);
    htmlCard = htmlCard.replace(/{condicao}/g,data.condicao);
    htmlCard = htmlCard.replace(/{class_extra}/g,'taskFound');
    htmlCard = htmlCard.replace(/{percentual_feito}/g,0);

    $('#divContainer_'+data.fse_id).append(htmlCard);

    //$('#divTask_'+data.tsk_id+' .panel').each(function(){// nao ta fazendo pois nao renderizou ainda // ').find('
    //   $(this).addClass('taskFound');
    //});

}//fnc

function setFieldFase(field_id,quem,onoff){
    // quem = field ou req

    var wrk_id      = $('#hdd_id_wrk').val();
    var fse_id      = $('#hdd_id_fse_selected').val();
    var idLi        = $('#hdd_id_fse_selected').attr('contador');

    if(quem=='field'){
        var status = onoff;
        var req = $('#chk_field_required_'+field_id).is(':checked');
        if(!status){
            $('#chk_field_required_'+field_id).prop('checked', false);
            req = false;
        }//if
    }else{
        var status = $('#chk_field_id_'+field_id).is(':checked');
        var req = onoff;
        if(req){
            $('#chk_field_id_'+field_id).prop('checked', true);
            status = true;
        }//if
    }//if

    if(wrk_id == 0)return false;
    if(fse_id == 0)return false;
    if(field_id == 0)return false;

    //setaAfterLoad();


    var urlData = "&wrk="+wrk_id+"&fse="+fse_id+"&fld="+field_id+"&req="+req+"&status="+status;

    $.ajax({
        type: "POST",
        url: "ajax/ajax_field_check.php",
        data: urlData,
        success: function(data) {
            //--
        },
        beforeSend: function() {
            $.uniform.update();
        },
        complete: function() {
            //
            var str_novo_valor = "";
            var tmp_id = "";
            var tmp_required = "";
            $('.classFields').each(function(){
                tmp_id = $(this).attr('id');
                if(tmp_id.indexOf('_id_')>0){
                    if($(this).is(':checked')){
                        tmp_required = ($('#'+tmp_id.replace('_id_','_required_')).is(':checked')?"S":"N");

                        tmp_id = tmp_id.replace(/[^0-9]/g,'');

                        if(str_novo_valor!="")str_novo_valor+=",";
                        str_novo_valor+=tmp_id+":"+tmp_required;
                    }//if
                }//if
            });
            $('#li_fse_'+idLi).attr('fields',str_novo_valor);
            //console.log('#li_fse_'+idLi+' attr[fields]: '+str_novo_valor);
        }
    });
}

function setEmailFase(email_id,quem,onoff){
    // quem = field ou req

    var wrk_id      = $('#hdd_id_wrk').val();
    var fse_id      = $('#hdd_id_fse_selected').val();
    var idLi        = $('#hdd_id_fse_selected').attr('contador');

    var arr_flags      = [];
    arr_flags["id"]    = "";
    arr_flags["in"]    = "";
    arr_flags["out"]   = "";
    arr_flags["time"]   = 0;
    arr_flags["team"]  = "";
    arr_flags["resp"]  = "";
    arr_flags["cln"]   = "";


    for (var k in arr_flags){
        arr_flags[k] = $('#chk_email_'+k+'_'+email_id).is(':checked');
    }//for

    if(wrk_id == 0)return false;
    if(fse_id == 0)return false;
    if(email_id == 0)return false;

    //setaAfterLoad();

    var urlData = "&wrk="+wrk_id+"&fse="+fse_id+"&tmp="+email_id+"&status="+onoff+"&in="+arr_flags["in"]+"&out="+arr_flags["out"]+"&team="+arr_flags["team"]+"&resp="+arr_flags["resp"]+"&cln="+arr_flags["cln"];

    $.ajax({
        type: "POST",
        url: "ajax/ajax_template_check.php",
        data: urlData,
        success: function(data) {
            //--
        },
        beforeSend: function() {
            $.uniform.update();
        },
        complete: function() {
            //
            var str_novo_valor = "";
            var tmp_id = "";
            var tmp_dias = 0;
            //
            $('.classEmails').each(function(){
                tmp_id = $(this).attr('id');
                if(tmp_id.indexOf('_id_')>0){
                    if($(this).is(':checked')){
                        if(str_novo_valor!="")str_novo_valor+=",";
                        str_novo_valor+=tmp_id.replace(/[^0-9]/g,'');
                        for (var k in arr_flags){

                            if(k == 'id'){
                                continue;
                            }else if(k=='time'){
                                //console.log('#txt_email_dias_'+email_id);
                                tmp_dias = $('#txt_email_dias_'+email_id).val().replace(/[^0-9]/,'');
                                if(tmp_dias == '')tmp_dias = 0;
                                arr_flags[k] = tmp_dias;//($('#'+tmp_id.replace('_id_','_'+k+'_')).is(':checked')?"S":"N");
                            }else{
                                arr_flags[k] = ($('#'+tmp_id.replace('_id_','_'+k+'_')).is(':checked')?"S":"N");
                            }//if

                            str_novo_valor+=":"+arr_flags[k];
                        }//for

                    }//if
                }//if
            });
            $('#li_fse_'+idLi).attr('emails',str_novo_valor);
            console.log('#li_fse_'+idLi+' attr[emails]: '+str_novo_valor);//1:S:S:S::N:N:N
        }
    });
}

function mudaTask(tsk_id,fase_alvo,fase_origem){
    var wrk_id      = $('#hdd_id_wrk_selected').val();
    var urlData     = '&wrk='+wrk_id+'&fase_origem='+fase_origem+'&fse='+fase_alvo+'&tsk='+tsk_id;
    var htmlCard      = $('#divTemplateTask').html();

    console.log('mudaTask('+tsk_id+',' +fase_alvo+',' +fase_origem+')');

    var tskObject = $('#divTsk_'+tsk_id);
    var tskPai = $('#divTsk_'+tsk_id).attr('pai');

    if(tskPai!='' && tskPai > 0 && tskPai != '0'){
        //console.log('tskPai: '+tskPai);
        //mudaTask(tskPai,fase_alvo,$('#divTsk_'+tskPai).attr('fase'));
        //arquivaTask(tsk_id,true);
        //return;
        $('#divContainer_'+fase_alvo+' .taskDiv').each(function(){
            console.log('each tsk: '+$(this).attr('tsk'));
            if($(this).attr('tsk') == ''+tskPai+''){
                console.log('arquivaTask: '+$(this).attr('tsk'));
                arquivaTask($(this).attr('tsk'),true);
            }//if
        });
    }else{
        $('#divContainer_'+fase_alvo+' .taskDiv').each(function(){
            console.log('each pai: '+$(this).attr('pai'));
            if($(this).attr('pai') == ''+tsk_id+''){
                console.log('arquivaTask: '+$(this).attr('tsk'));
                arquivaTask($(this).attr('tsk'),true);
            }//if
        });
    }//if

    console.log('continue...');

    $.ajax({
        type: "POST",
        url: "ajax/ajax_muda_task.php",
        data: urlData,
        dataType: 'json',
        success: function(data) {

            if( $('#divContainer_'+fase_alvo).attr('replica') != '' ){//&& $('#divContainer_'+fase_alvo).attr('replica') != 'NULL'


                htmlCard = htmlCard.replace(/{tsk_id}/g,data.tsk_id);
                htmlCard = htmlCard.replace(/{tsk_pai}/g,data.tsk_pai);
                htmlCard = htmlCard.replace(/{tsk_titulo}/g,data.tsk_titulo);
                htmlCard = htmlCard.replace(/{tsk_status}/g,data.tsk_status);
                htmlCard = htmlCard.replace(/{tsk_class_alerta}/g,data.tsk_class_alerta);
                htmlCard = htmlCard.replace(/{tsk_cln_nome}/g,data.tsk_cln_nome);
                htmlCard = htmlCard.replace(/{fse_id}/g,data.fse_id);
                htmlCard = htmlCard.replace(/{condicao}/g,0);
                htmlCard = htmlCard.replace(/{class_extra}/g,'');
                htmlCard = htmlCard.replace(/{percentual_feito}/g,'0');

                //console.log(htmlCard);

                $('#divContainer_'+data.fse_id).append(htmlCard);
            }//if

            //console.log('success: '+$('#divContainer_'+fase_alvo).attr('replica'));
        },
        beforeSend: function() {
            //--
        },
        complete: function() {
            //--
        }
    });
}//fnc



function salvaOrdemLista(tipo,ordem){
    var wrk_id      = $('#hdd_id_wrk').val();
    var fse_id      = $('#hdd_id_fse_selected').val();
    var qst_id      = $('#hdd_id_qst_selected').val();
    var urlData     = '&tipo='+tipo+'&ordem='+ordem+'&wrk='+wrk_id+'&fse='+fse_id+'&qst='+qst_id;
    $.ajax({
        type: "POST",
        url: "ajax/ajax_salva_ordem.php",
        data: urlData,
        success: function(data) {
            console.log('tipo: '+tipo);
            //if(data.indexOf('ok')>=0){
                setOrdemLabels(tipo);
            //}//if
        },
        beforeSend: function() {
            //--
        },
        complete: function() {
            //--
        }
    });
}//fnc

function setOrdemLabels(tipo){
    var contador = 1;
    var idCardinalUl = (tipo=='fse')?$('#hdd_id_wrk').val():"0";
    $('#ul_lst_'+tipo+'_'+idCardinalUl).find('.badgecontador').each(function(){
        $(this).text(contador);
        contador++;
    });
}//fnc

function salvaEsteCampo(elemento){

    //console.log('salvaEsteCampo: '+$(elemento).attr('id'));

    var wrk_id      = $('#hdd_id_wrk').val();
    var idInput     = $(elemento).attr('id');
    var valor       = $(elemento).val().trim();
    var original    = $(elemento).attr('original').trim();

    //usados no frm
    var fse_id      = $('#hdd_id_fse_selected').val();
    var qst_id      = $('#hdd_id_qst_selected').val();
    var tsk_id      = $('#hdd_id_tsk_selected').val();

    //qndo nao tem info acima
    if(fse_id=='')fse_id = $(elemento).attr('fse');

    var urlData     = '&wrk='+wrk_id+'&tsk='+tsk_id+'&fse='+fse_id+'&qst='+qst_id+'&input='+idInput+'&value='+valor;

    console.log('urlData: '+urlData);

    if(valor!=original){
        $.ajax({
            type: "POST",
            url: "ajax/ajax_salva_campo.php",
            data: urlData,
            success: function(data) {
                console.log('data: '+data);
                if(data.indexOf('ok')>=0){

                    var regExp = /\[ok\:([0-9]+)\]/ig;
                    var arr_id_retorno = regExp.exec(data);
                    console.log(arr_id_retorno);
                    var int_id_retorno = arr_id_retorno[1];
                    console.log('int_id_retorno: '+int_id_retorno);

                    var regExpCampo = /txt_([a-z]+)(_[a-z]+)*_[0-9]+/g;
                    console.log(idInput);
                    var arr_regex_retorno_campo = regExpCampo.exec(idInput);
                    var str_atributo    = arr_regex_retorno_campo[1];

                    if(str_atributo == 'field'){
                        verificaCondicoesEspecificas(tsk_id,fse_id);
                        return;
                    }

                    if(str_atributo == 'nota'){

                        var d = new Date();
                        var int_dia = d.getDate();
                        var int_mes = d.getMonth() + 1;
                        var int_ano = d.getFullYear();
                        if(int_dia < 10)int_dia = "0" + int_dia;
                        if(int_mes < 10)int_mes = "0" + int_mes;
                        var date = int_dia + "/" + int_mes + "/" + int_ano;
                        var time = d.toLocaleTimeString().toLowerCase().split(":");
                        time = time[0]+":"+time[1];

                        var timestamp = date+" - "+time;

                        //var htmlInsert = '<div class="alert alert-info"><span>'+valor+'</span> - <span class="text-muted">'+timestamp+'</span> </div>';
                        var htmlInsert = '<tr>';
                                htmlInsert+= '<td><span class="text-muted">'+timestamp+'</span></td>';
                                htmlInsert+= '<td><span>'+valor+'</span></td>';
                            htmlInsert+= '</tr>';
                        $('#tbodyLog').prepend(htmlInsert);
                        //$('#divLogNota').prepend(htmlInsert);
                        $('#'+idInput).val('');
                        return;
                    }//if

                    var regExpTipo = /txt_[a-z]+_([a-z]+)_[0-9]+/g;
                    var arr_regex_retorno_tipo = regExpTipo.exec(idInput);
                    var str_tipo        = arr_regex_retorno_tipo[1];

                    if($('#hdd_id_'+str_tipo+'_selected').length){
                        var idLi = $('#hdd_id_'+str_tipo+'_selected').attr('contador');//idInput.replace(/[^0-9]/g,'');//

                        $('#li_'+str_tipo+'_'+idLi).attr(str_atributo,valor);

                        console.log('#li_'+str_tipo+'_'+idLi+' attr '+str_atributo + '('+valor+')');

                        if(str_tipo=='fse' && fse_id==0){
                            $('#hdd_id_fse_selected').val(int_id_retorno);
                        }//if
                        if(str_tipo=='qst' && qst_id==0){
                            $('#hdd_id_qst_selected').val(int_id_retorno);
                        }//if
                    }//if

                    if(str_tipo=='tsk'){
                        $('#spn_tsk_'+tsk_id+'_subtitle').text(valor);//a_tsk_ _title
                    }//if
                    console.log('idInput: '+idInput);
                }//if
            },
            beforeSend: function() {
                //--
            },
            complete: function() {
                $(elemento).next().hide();
            }
        });
    }else{
        $(elemento).next().hide();
    }//if

}//fnc

function setaTriggers(){

    console.log('setaTriggers()');
    /*

    $('.faseHiddenText').unbind('change');
    $('.faseHiddenText').unbind('keypress');

    $('.inputAutoSave').each(function(){
        $(this).unbind('focus');
        $(this).unbind('blur');
        console.log('unbind '+$(this).attr('id'));
    });


    $('.faseHiddenText').bind('change',function(){
        console.log('faseHiddenText change: '+$(this).attr('id')+' ('+$(this).val()+')');
        changeText($(this));
    });

    $('.faseHiddenText').bind('keypress',function(e){
        if(e.which == 13) {
            $(this).blur();
        }
    });

    $('.inputAutoSave').bind('focus',function(){
        console.log('inputAutoSave focus '+$(this).attr('id'));
        $(this).next().children().removeClass('icon-spinner');
        $(this).next().children().removeClass('spinner');
        $(this).next().children().addClass('icon-pencil4');
        $(this).next().show();
        $(this).css('border-color','#f00');
    });

    $('.inputAutoSave').bind('blur',function(){
        $(this).next().children().removeClass('icon-pencil4');
        $(this).next().children().addClass('icon-spinner');
        $(this).next().children().addClass('spinner');
        $(this).css('border-color','#ddd');
        console.log('inputAutoSave blur '+$(this).attr('id'));
        salvaEsteCampo(this);
    });

    */


}//fnc

function salvarEquipeTarefa(elemento){

    var wrk_id      = $('#hdd_id_wrk').val();
    var idInput     = $(elemento).attr('id');
    //var valor       = $(elemento).val().trim();
    //var original    = $(elemento).attr('original').trim();

    var fse_id      = $('#hdd_id_fse_selected').val();
    var qst_id      = $('#hdd_id_qst_selected').val();



    //console.log('salvarEquipeTarefa: ');
    var selecionados = [];
    for (var i = 0; i < elemento.length; i++) {
        if (elemento.options[i].selected) selecionados.push(elemento.options[i].value);
    }
    //console.log(selecionados);

    var urlData     = '&wrk='+wrk_id+'&fse='+fse_id+'&qst='+qst_id+'&input='+idInput+'&value='+selecionados;

    $.ajax({
            type: "POST",
            url: "ajax/ajax_salva_equipe.php",
            data: urlData,
            success: function(data) {
                console.log('data: '+data);
            },
            beforeSend: function() {
                //--
            },
            complete: function() {
               // $(elemento).next().hide();
            }
        });

}//fnc


function inputAutoSave(evento,elemento){
    if(evento=='focus'){
        $(elemento).next().children().removeClass('icon-spinner');
        $(elemento).next().children().removeClass('spinner');
        $(elemento).next().children().addClass('icon-pencil4');
        $(elemento).next().show();
        $(elemento).css('border-color','#f00');
    }else if(evento == 'blur'){
        $(elemento).next().children().removeClass('icon-pencil4');
        $(elemento).next().children().addClass('icon-spinner');
        $(elemento).next().children().addClass('spinner');
        $(elemento).css('border-color','#ddd');

        console.log('inputAutoSave('+evento+'): '+$(elemento).attr('id'));

        salvaEsteCampo(elemento);
    }//if
}//fnc



//-------------

function criaTask(){

    var primeiraFase    = $('#workflow').attr('fse');
    var wrk_id          = $('#hdd_id_wrk_selected').val();
    var htmlCard        = $('#divTemplateTask').html();

    var urlData         = '&wrk='+wrk_id+'&fse='+primeiraFase;

    console.log('criaTask('+wrk_id+')');

    $.ajax({
        type: "POST",
        url: "ajax/ajax_new_task.php",
        data: urlData,
        dataType: 'json',
        success: function(data) {

            htmlCard = htmlCard.replace(/{tsk_id}/g,data.tsk_id);
            htmlCard = htmlCard.replace(/{tsk_pai}/g,data.tsk_pai);
            htmlCard = htmlCard.replace(/{tsk_titulo}/g,data.tsk_titulo);
            htmlCard = htmlCard.replace(/{tsk_status}/g,data.tsk_status);
            htmlCard = htmlCard.replace(/{tsk_class_alerta}/g,data.tsk_class_alerta);
            htmlCard = htmlCard.replace(/{tsk_cln_nome}/g,data.tsk_cln_nome);
            htmlCard = htmlCard.replace(/{fse_id}/g,primeiraFase);
            htmlCard = htmlCard.replace(/{condicao}/g,0);
            htmlCard = htmlCard.replace(/{class_extra}/g,'');
            htmlCard = htmlCard.replace(/{percentual_feito}/g,0);

            $('#divContainer_'+primeiraFase).append(htmlCard);

            loadFormulario(data.tsk_id,primeiraFase);

        },
        beforeSend: function() {
            //--
        },
        complete: function() {
            //--
        }
    });
}

function loadTaskJson(){

}//

function setaAfterLoad(){
    // Init Select2 when loaded
    $('.select').select2({
        minimumResultsForSearch: Infinity
    });
    // Danger
    $(".control-danger").uniform({
        radioClass: 'choice',
        wrapperClass: 'border-danger-600 text-danger-800'
    });
    // Success
    $(".control-success").uniform({
        radioClass: 'choice',
        wrapperClass: 'border-success-600 text-success-800'
    });
     // Info
    $(".control-info").uniform({
        radioClass: 'choice',
        wrapperClass: 'border-info-600 text-info-800'
    });
}//fnc

function loadFormulario(tsk,fse){

    console.log('loadFormulario('+tsk+','+fse+')');

    $('#div_panel_cliente').html('<i class="spinner icon-spinner"></i> Carregando...');
    $('#div_panel_atividades').html('<i class="spinner icon-spinner"></i> Carregando...');
    $('#div_panel_equipe').html('<i class="spinner icon-spinner"></i> Carregando...');
    $('#div_panel_info').html('<i class="spinner icon-spinner"></i> Carregando...');
    $('#div_panel_log').html('<i class="spinner icon-spinner"></i> Carregando...');

    $('#hdd_id_tsk_selected').val(tsk);

    $('#div_panel_atividades').load('ajax/ajax_form_fase.php?tsk='+tsk+'&fse='+fse, function() {//$(this).find(.modal-body)
        setaAfterLoad();
    });

    $('#div_panel_cliente').load('ajax/ajax_form_cliente.php?tsk='+tsk+'&fse='+fse, function() {
        setaAfterLoad();
    });

    $('#div_panel_equipe').load('ajax/ajax_form_equipe.php?tsk='+tsk+'&fse='+fse, function() {

    });
    $('#div_panel_info').load('ajax/ajax_form_info.php?tsk='+tsk+'&fse='+fse, function() {
        setMasks();
        //setaAfterLoad();
    });
    $('#div_panel_log').load('ajax/ajax_form_log.php?tsk='+tsk+'&fse='+fse, function() {

    });


}//fnc

function validaFase(qual){
    if($('#txt_titulo_fse_'+qual).val().trim()==""){
        alert('Por favor, informe um nome para esta fase!');
        return false;
    }//if

    return true;
}//fnc

function validaQuestion(qual){
    if($('#txt_titulo_qst_'+qual).val().trim()==""){
        alert('Por favor, informe do que se trata a tarefa!');
        return false;
    }//if

    return true;
}//fnc

function mudaTitulo(idItem,que,tipo){
    console.log('mudaTitulo: '+idItem+' / '+que);
    var idOrdem = $('#hdd_id_'+tipo+'_selected').attr('contador');
    //$('#spn_tab_'+tipo+'_'+idItem).text(que);
    $('#h5_title_'+tipo+'_'+idItem).text(que);
    $('#spn_'+tipo+'_'+idOrdem).text(que);
}//fnc

function addElement(tipo, idItem){
    var strComplemento = tipo+"_"+idItem;
    var proximo = $('#ul_lst_'+strComplemento+' .liItem').length + 1;
    var classLabel = '';
    var strLabelItem = '';

    if(tipo=='fse'){
        classLabel = "primary";
        strLabelItem = "Nova Fase...";
    }else{
        classLabel = "danger";
        strLabelItem = "Nova Tarefa...";
    }//if

    console.log(strComplemento+': '+proximo+' (addElement) '+$('#ul_lst_'+strComplemento+' .liItem').length);
    strComplemento = tipo+"_"+proximo;//ui-sortable-handle
    var html_input = "<li class=\"has-feedback ui-sortable-handle liItem\" id=\"li_"+strComplemento+"\" "+tipo+"=\"0\" titulo=\""+strLabelItem+"\" descricao=\"\" risco=\"\" tempo=\"1\" obrigatorio=\"\" equipe=\"\">";
            html_input+= "<a id=\"a_titulo_"+strComplemento+"\" href=\"#\" onclick=\"selectItem(this.id,true,"+proximo+");return false;\">";
                html_input+= "<span class=\"badge badge-"+classLabel+"  pull-left\">"+proximo+"</span>";
                    html_input+= "<i class=\"icon-dots dragula-handle pull-right\"></i>";
                html_input+= " <span id=\"spn_titulo_"+strComplemento+"\" onclick=\"editItem(this,true,"+proximo+");\">"+strLabelItem+"</span>";
            html_input+= "</a>";
            html_input+= "<input id=\"txt_titulo_"+strComplemento+"\" type=\"text\" class=\"form-control faseHiddenText inputAutoSave\" value=\""+strLabelItem+"\" onfocus=\"inputAutoSave('focus',this);\" onblur=\"editItem(this,false, "+proximo+");inputAutoSave('blur',this);\" original=\"\" onkeyup=\"if(TeclaEnter(event))this.blur();\" onchange=\"changeText(this);\" />";
            html_input+="<div class=\"form-control-feedback\" style=\"display:none;\">";
                html_input+="<i class=\"icon-edit\"></i>";
            html_input+="</div>";

            html_input+=" <span class=\"dropdown pull-right spanOptions\">";
                html_input+="<a href=\"#\" class=\"text-default dropdown-toggle\" data-toggle=\"dropdown\"><i class=\"icon-cog\"></i> <span class=\"caret\"></span></a>";
                    html_input+="<ul class=\"dropdown-menu dropdown-menu-right\">";
                            html_input+="<li><a href=\"#\" onclick=\"selectItem('a_titulo_fse_"+proximo+"',true, "+proximo+");return false;\"><i class=\"icon-pencil7\"></i> Editar</a></li>";
                            html_input+="<li><a href=\"#\" onclick=\"arquivaItem('"+tipo+"', "+proximo+");return false;\"><i class=\"icon-drawer-in\"></i> Arquivar</a></li>";
                        html_input+="</ul>";
                    html_input+="</span>";

        html_input+= "</li>";
    $('#ul_lst_'+tipo+"_"+idItem).append(html_input);
    setaTriggers();
}//fnc
//-------------

function editItem(elemento,onoff, contador){
    var idItem = contador;//$(elemento).attr('id').replace(/[^0-9]/g,'');
    var targetElement = '';
    var regExp = /_([a-z]+)/ig;
    var matches = [];
    var match;
    while ((match = regExp.exec($(elemento).attr('id'))) != null) {
        matches.push(match[1]);
    }//wh
    var tipo = matches[1];

    console.log('editItem ('+idItem+') tipo: '+tipo+' ('+$(elemento).attr('id')+')');

    if(onoff){
        targetElement = 'txt';
        $('#a_titulo_'+tipo+'_'+idItem).hide();
    }else{
        targetElement = 'a';
        $('#txt_titulo_'+tipo+'_'+idItem).hide();
    }//if

    $('#'+targetElement+'_titulo_'+tipo+'_'+idItem).show();

    if(targetElement=='txt'){
        $('#'+targetElement+'_titulo_'+tipo+'_'+idItem).select().focus();
    }
}//fnc

function selectItem(elemento_id,onoff, contador){
    var idElement = contador;//$(elemento).attr('id').replace(/[^0-9]/g,'');
    var arrDados = [];

    var regExp = /_([a-z]+)/ig;
    var matches = [];
    var match;
    //console.log('tipo: '+tipo);
    while ((match = regExp.exec(elemento_id)) != null) {//$(elemento).attr('id')
        matches.push(match[1]);
    }//wh
    var tipo = matches[1];
    console.log('selectItem ('+idElement+') tipo: '+tipo+' ('+elemento_id+')');//$(elemento).attr('id')

    //console.log(matches);
    console.log('#li_'+tipo+'_'+idElement);

    arrDados["id"] = $('#li_'+tipo+'_'+idElement).attr(tipo);
    console.log(arrDados["id"]);

    $('#hdd_id_'+tipo+'_selected').val(arrDados["id"]);
    $('#hdd_id_'+tipo+'_selected').attr('contador', contador);

    arrDados["titulo"]      = $('#li_'+tipo+'_'+idElement).attr('titulo');
    arrDados["descricao"]   = $('#li_'+tipo+'_'+idElement).attr('descricao');

    switch(tipo){
        case "fse":
            arrDados["risco"]       = $('#li_'+tipo+'_'+idElement).attr('risco');
            arrDados["tempo"]       = $('#li_'+tipo+'_'+idElement).attr('tempo');
            arrDados["fields"]      = $('#li_'+tipo+'_'+idElement).attr('fields');
            arrDados["emails"]      = $('#li_'+tipo+'_'+idElement).attr('emails');
            arrDados["replica"]     = $('#li_'+tipo+'_'+idElement).attr('replica');
            loadQuestions(arrDados["id"]);
            populaFase(arrDados);
        break;
        case "qst":
            arrDados["obrigatorio"] = $('#li_'+tipo+'_'+idElement).attr('obrigatorio');
            arrDados["equipe"]   = $('#li_'+tipo+'_'+idElement).attr('equipe');
            populaQuestion(arrDados);
        break;
    }//sw

    /*
    arrDados["titulo"]
    arrDados["descricao"]
    fse - arrDados["risco"]
        - arrDados["tempo"]
    qst - arrDados["obrigatorio"]
        - arrDados["equipe"]
    */

}//fnc

function populaFase(arrDados){
    $('.classFields').prop('checked',false);
    $('.classEmails').prop('checked',false);
    $('.classEmailsText').val('');

    $('#divSelecioneUmaFase').hide();

    $('.classNomeFase').text('"'+arrDados["titulo"]+'"');

    console.log('populaFase titulo: '+arrDados["titulo"]);
    $('#txt_titulo_fse_0').val(arrDados["titulo"]);
    $('#txt_titulo_fse_0').attr('original',arrDados["titulo"]);

    $('#txt_descricao_fse_0').val(arrDados["descricao"]);
    $('#txt_descricao_fse_0').attr('original', arrDados["descricao"]);

    $('#txt_risco_fse_0').val(arrDados["risco"]);
    $('#txt_risco_fse_0').attr('original', arrDados["risco"]);

    $('#txt_tempo_fse_0').val(arrDados["tempo"]);
    $('#txt_tempo_fse_0').attr('original', arrDados["tempo"]);

    $('#slc_replica').val(arrDados["replica"]);
    $("#slc_replica").select2();

    var dataarray=arrDados["fields"].split(",");
    var arr_sub = [];

    for(var i = 0; i< dataarray.length; i++){
        arr_sub = dataarray[i].split(':');
        $('#chk_field_id_'+arr_sub[0]).prop('checked',true);
        $('#chk_field_required_'+arr_sub[0]).prop('checked',(arr_sub[1]=="S"?true:false));
    }//for

    var dataarray=arrDados["emails"].split(",");
    var arr_sub = [];

    console.log(arrDados["emails"]);

    for(var i = 0; i< dataarray.length; i++){
        arr_sub = dataarray[i].split(':');

        if(arr_sub[0]==""){
            break;
        }//if
        $('#chk_email_id_'+arr_sub[0]).prop('checked',true);

        /*
        Id
        SendIn
        SendOut
        SendTime
        SendTeam
        SendResp
        SendCln
        SendMail

        arr_flags["id"]    = "";
        arr_flags["in"]    = "";
        arr_flags["out"]   = "";
        arr_flags["time"]   = 0;
        arr_flags["team"]  = "";
        arr_flags["resp"]  = "";
        arr_flags["cln"]   = "";
        */

        $('#chk_email_in_'+arr_sub[0]).prop('checked',((arr_sub[1]=='S')?true:false));
        $('#chk_email_out_'+arr_sub[0]).prop('checked',((arr_sub[2]=='S')?true:false));
        $('#txt_email_dias_'+arr_sub[0]).val((arr_sub[3]==0)?'':arr_sub[3]);
        $('#chk_email_team_'+arr_sub[0]).prop('checked',((arr_sub[4]=='S')?true:false));
        $('#chk_email_resp_'+arr_sub[0]).prop('checked',((arr_sub[5]=='S')?true:false));
        $('#chk_email_cln_'+arr_sub[0]).prop('checked',((arr_sub[6]=='S')?true:false));
        console.log('#chk_email_id_'+arr_sub[0]);
        //$('#chk_field_required_'+arr_sub[0]).prop('checked',(arr_sub[1]=="S"?true:false));
    }//for

    $.uniform.update();

    $('#divDadosFase0').addClass('in');
    $('#divFields0').addClass('in');
    $('#divEmails0').addClass('in');
    $('#divTarefas0').addClass('in');
}

function populaQuestion(arrDados){
    console.log('populaQuestion titulo: '+arrDados["titulo"]);

    $('#txt_titulo_qst_0').val(arrDados["titulo"]);
    $('#txt_titulo_qst_0').attr('original',arrDados["titulo"]);

    $('#txt_descricao_qst_0').val(arrDados["descricao"]);
    $('#txt_descricao_qst_0').attr('original',arrDados["descricao"]);

    $('#txt_required_qst_0').val();

    arrDados["obrigatorio"] = (arrDados["obrigatorio"]=="S")?"S":"N";
    $('input:radio[name=txt_required_qst_0]').filter('[value='+arrDados["obrigatorio"]+']').prop('checked', true);
    var dataarray=arrDados["equipe"].split(",");
    $("#slc_id_eqps").val(dataarray);
    $("#slc_id_eqps").select2("destroy");
    $("#slc_id_eqps").select2();

    $('#question0').addClass('in');
}

function changeText(elemento){
    console.log('changeText: '+$(elemento).attr('id'));
    var idItem = $(elemento).attr('id').replace(/[^0-9]/g,'');
    var regExp = /_([a-z]+)/ig;
    var matches = [];
    var match;
    //console.log('tipo: '+tipo);
    while ((match = regExp.exec($(elemento).attr('id'))) != null) {
        matches.push(match[1]);
    }//wh
    var tipo = matches[1];
    var valor = $(elemento).val();

    if(idItem=='0' || idItem == 0)idItem = $('#hdd_id_'+tipo+'_selected').attr('contador');

    console.log(tipo+'_'+idItem);

    //$('#h5_titulo_'+tipo+'_'+idItem).text(valor);
    $('#h5_titulo_'+tipo+'_0').text(valor);

    $('#spn_titulo_'+tipo+'_'+idItem).text(valor);
    $('#li_'+tipo+'_'+idItem).attr('titulo',valor);

    $('#txt_titulo_'+tipo+'_0').val(valor);

    if(tipo=='fse'){
        $('.classNomeFase').text(valor);
    }

}//fnc

function loadQuestions(idFse){
    console.log('fase: '+idFse);
    if(idFse==0)return false;
    $('#ul_lst_qst_0').load('ajax/ajax_question_lst.php?fse='+idFse, function() {
        setaTriggers();
    });
}//
/*
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
*/
function setTaskQuestion(question, task,status){

    var urlData = "&qst="+question+"&tsk="+task+"&status="+status;
    var fse_id = $('#divTsk_'+task).attr('fase');

    $.ajax({
        type: "POST",
        url: "ajax/ajax_question_check.php",
        data: urlData,
        success: function(data) {
            //--
        },
        beforeSend: function() {
            //--
        },
        complete: function() {
            verificaCondicoesEspecificas(task,fse_id);
        }
    });

}//fnc
/*
 function salvarItem(tipo){
    //alert('salvarItem('+tipo+'): quem me chamou?');
    //--
    var id_elemento = $('#hdd_id_'+tipo+'_selected').val();
    var id_item = $('#li_'+tipo+'_'+id_elemento).attr(tipo);
    console.log('salvarItem id_elemento: '+id_elemento + ' ('+'hdd_id_'+tipo+'_selected'+') = '+id_item);
 }//fnc
*/
 function arquivaTask(qual,force){

    if( force==null || force=='undefined' || force=='')force = false;

    if(!force){
        if(!confirm('Tem certeza de que deseja arquivar este negócio?')){
            return false;
        }//if
    }//if


    var urlData = "&tipo=tsk&itm="+qual;

    $.ajax({
        type: "POST",
        url: "ajax/ajax_arquiva_item.php",
        data: urlData,
        success: function(data) {
            $('#divTsk_'+qual).remove();
        },
        beforeSend: function() {
            //--
        },
        complete: function() {
            //--
        }
    });


 }//fnc

 function arquivaItem(tipo,idCount, reativa){

    var id_li = 'li_'+tipo+'_'+idCount;
    var idItem = $('#'+id_li).attr(tipo);
    var label_item = '';

    var onoff = (reativa===true)?1:0;

    switch(tipo){
        case "wrk":
            label_item = 'esta Pipeline';
            idItem = idCount;
        break;
        case "fse":
            label_item = 'esta Fase';
        break;
        case "qst":
            label_item = 'esta Atividade';
        break;
    }//sw

    if(!confirm('Tem certeza de que deseja arquivar '+label_item+'?')){
        return false;
    }//if
    console.log('arquivaItem('+tipo+','+idItem+')');
    var urlData = "&tipo="+tipo+"&itm="+idItem+'&onoff='+onoff;

    $.ajax({
        type: "POST",
        url: "ajax/ajax_arquiva_item.php",
        data: urlData,
        success: function(data) {
            if(tipo!='wrk'){
                $('#'+id_li).remove();
            }else{
                document.location.href = './?page=workflow';
            }//if
        },
        beforeSend: function() {
            //--
        },
        complete: function() {
            //--
        }
    });
 }//fnc

 function salvaObrigatorio(onoff){

    var wrk_id      = $('#hdd_id_wrk').val();
    var idInput     = 'txt_required_qst_0';
    var valor       = onoff;
    var original    = '';

    var fse_id      = $('#hdd_id_fse_selected').val();
    var qst_id      = $('#hdd_id_qst_selected').val();
    var tsk_id      = $('#hdd_id_tsk_selected').val();

    var contadorSelected = $('#hdd_id_qst_selected').attr('contador');

    var urlData     = '&wrk='+wrk_id+'&tsk='+tsk_id+'&fse='+fse_id+'&qst='+qst_id+'&input='+idInput+'&value='+valor;

    $.ajax({
        type: "POST",
        url: "ajax/ajax_salva_campo.php",
        data: urlData,
        success: function(data) {
            //--
            $('#li_qst_'+contadorSelected).attr('obrigatorio',valor);
        },
        beforeSend: function() {
            //--
        },
        complete: function() {
            //--
        }
    });
 }//fnc

 function salvarClienteTask(tsk,cln){
    var urlData = "&tsk="+tsk+"&cln="+cln;
    //var tmp_nome_negocio = $('#txt_titulo_tsk_'+tsk).val().trim();

    $.ajax({
        type: "POST",
        url: "ajax/ajax_salvar_cliente_task.php",
        data: urlData,
        success: function(data) {
            //if(tmp_nome_negocio==''){
            $('#a_tsk_'+tsk+'_title').html(data);
            //}//if
        },
        beforeSend: function() {
            //--
        },
        complete: function() {
            //--
        }
    });
 }

  function salvarReplica(valor){
    var wrk_id      = $('#hdd_id_wrk').val();
    var fse_id      = $('#hdd_id_fse_selected').val();
    var idLi        = $('#hdd_id_fse_selected').attr('contador');
    var urlData = "&fse="+fse_id+"&destino="+valor;

    $.ajax({
        type: "POST",
        url: "ajax/ajax_salvar_replica_fase.php",
        data: urlData,

        success: function(data) {
            $('#li_fse_'+idLi).attr('replica',valor);
        },
        beforeSend: function() {
            //--
        },
        complete: function() {
            //--
        }
    });
 }