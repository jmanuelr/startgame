var iframeDoc = null;

$(function() {

    //modal load form by phase
    // Load remote content
    $('#modal_janela').on('show.bs.modal', function(objeto) {
        
        deselecionaElemento()
        //$('#modal_janela .modal-content').css('height',$(window).height()-50);
    	//var tsk = $(objeto.relatedTarget).attr('tsk');
        //$('.nav-tabs a[href="#div_panel_atividades"]').tab('show');
        $('#ifr_janela').load(function(){
           inicializaSeletor();
        });

    });
});

function inicializaSeletor(){
    if(iframeDoc != null)iframeDoc = null;
    iframeDoc = document.getElementById('ifr_janela').contentWindow;
    $(iframeDoc).mouseover(function(event){
        if($('#hdd_elm_selecionado').val()=='' && event.target.id){
            $(event.target).addClass('outline-element');
            console.log('mouseover em '+event.target);
            $('#spn_elm_selecionado').text(event.target);

            var idElemento = event.target.id;
            var nomeElemento = event.target.name;
            var path_elm_selecionado = getElementXPath(event.target);
            $('#path_elm_selecionado').text(path_elm_selecionado);
            $('#id_elm_selecionado').text(idElemento);
            $('#name_elm_selecionado').text(nomeElemento);
        }else{
            if($('#hdd_elm_selecionado').val().trim()==''){
                $('#spn_elm_selecionado').text('-');
                $('#path_elm_selecionado').text("-");
                $('#id_elm_selecionado').text("-");
                $('#name_elm_selecionado').text("-");
            }//if
        }//if
    }).mouseout(function(event){
        //if($('#hdd_elm_selecionado').val()!=''){
            //$(event.target).removeClass('outline-element');
            //console.log('mouseout em '+event.target);    
        //}//if
        if($('#hdd_elm_selecionado').val().trim()==''){
            $('#spn_elm_selecionado').text('-');
            $('#path_elm_selecionado').text("-");
            $('#id_elm_selecionado').text("-");
            $('#name_elm_selecionado').text("-");
        }//if
        
    }).click(function(event){
        if($('#hdd_elm_selecionado').val()==''  && event.target.id ){
            //console.log(event.target.id);
            $(event.target).toggleClass('outline-element-clicked');
            var idElemento = event.target.id;
            var nomeElemento = event.target.name;
            var path_elm_selecionado = getElementXPath(event.target);
            $('#spn_elm_selecionado').text(event.target);
            $('#spn_elm_selecionado').css('color','red');
            $('.btnAcao').show();
            $('#hdd_elm_selecionado').val(path_elm_selecionado);
            $('#path_elm_selecionado').text(path_elm_selecionado);

            $('#id_elm_selecionado').text(idElemento);
            $('#name_elm_selecionado').text(nomeElemento);

        }//if
        
    });
}

function adicionarALista(){
    if($('#hdd_elm_selecionado').val()!=''){

        var idElemento = $('#id_elm_selecionado').text();
        var nomeElemento = $('#name_elm_selecionado').text();
        var pathElemento = $('#path_elm_selecionado').text();

        salvaItemAdded(idElemento,false);
        //addItemElementList(idElemento,false);//+'('+pathElemento+')'

    }//if

    
}//fnc

function addItemElementList(item,boolClear){
    var liItem;
    console.log(item);
    if(boolClear){
        $('#ul_element_list').html('');
    }else if(item!=''){
        liItem = '<li>'+item+'</li>';
        $('#ul_element_list').append(liItem);
    }//if
    
}//fnc

function salvaItemAdded(item,boolClear){
    var sis = $('#hdd_id_sis').val();
    var jnl = $('#hdd_id_jnl').val();
    var byid = $('#id_elm_selecionado').text();
    var byname = $('#name_elm_selecionado').text();
    var path = $('#hdd_elm_selecionado').val();
    var data = '&sis='+sis+'&jnl='+jnl+'&byid='+byid+'&byname='+byname+'&path='+path;
    $.ajax({
        url: 'ajax/ajax_save_elemento.php',
        data: data,
        dataType: 'json',
        success: function(data) {
            if(data.success){
                addItemElementList(item,boolClear);
            }else{
                alert(data.msg);
            }//if
        }
    });
}//fnc

function loadElementos(){
    var objTarget = $('#div_panel_acoes');
    var sis = $('#hdd_id_sis').val();
    var jnl = $('#hdd_id_jnl').val();
    var data = '&sis='+sis+'&jnl='+jnl;
    $.ajax({
        url: 'ajax/ajax_load_elementos.php',
        data: data,
        dataType: 'html',
        beforeSend: function(){
            objTarget.html('<i class="spinner icon-spinner"></i> Carregando...');
        },
        success: function(data) {
            objTarget.html(data);
        }
    });
}//fnc

function loadElementosJson(){
    var objTarget = $('#ul_element_list');
    var sis = $('#hdd_id_sis').val();
    var jnl = $('#hdd_id_jnl').val();
    var data = '&sis='+sis+'&jnl='+jnl+'&json=1';
    $.ajax({
        url: 'ajax/ajax_load_elementos.php',
        data: data,
        dataType: 'json',
        beforeSend: function(){
            objTarget.html('');
        },
        success: function(data) {
            if(data.success){
                if(data.qtde>0){
                    for(let i = 0;i<data.qtde;i++){
                        objTarget.append("<li>"+data.elementos[i].byid+"</li>");
                    }//for
                }//if
            }//if
        }
    });
}//fnc

function deselecionaElemento(){
    $('#spn_elm_selecionado').css('color','black');
    $('.btnAcao').hide();
    $('#hdd_elm_selecionado').val('');
    $('#spn_elm_selecionado').text('-');
    $('#path_elm_selecionado').text('/');
    $('#id_elm_selecionado').text('');
    $('#name_elm_selecionado').text('');
}

function getElementXPath(element){
    console.log('cliquei em '+element);
    return "//"+$(element).parents().andSelf().map(function(){
        var $this = $(this);
        var tagName = this.nodeName;
        if($this.siblings(tagName).length > 0){
            tagName += "["+($this.prevAll(tagName).length + 1) + "]";
        }
        return tagName;
    }).get().join("/").toLowerCase();
}

function verElementos(jnl_id,jnl_url){
    $('#hdd_id_jnl').val(jnl_id);
    $('#ifr_janela').attr('src',jnl_url);
    loadElementos();
    loadElementosJson();
    $('#modal_janela').modal('show');
}//fnc

function redimensionaIframe(){
    var divIframeContainer = document.getElementById('divIframeContainer');
    var ifrProposta = document.getElementById('ifr_janela');
    ifrProposta.style.height = ifrProposta.offsetHeight;
    divIframeContainer.style.height = ifrProposta.offsetHeight + 50;
    console.log('height: '+ifrProposta.offsetHeight);
}//fnc