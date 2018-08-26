
$(document).ready(function(){

    $('.classPF').hide();

    $('#slc_id_atv').select2();
    $('#slc_id_ffn').select2();

    //$("#slc_id_cdd").select2();
    $('#slc_uf').select2({placeholder:'Selecione o Estado...'}).on('change', function() {
        var uf = $(this).val();
        //console.log('uf: ['+uf+']');

        $('#slc_id_cdd').select2("val",'');

        if(uf!=""){

            $.get('act/ajax_json_cidade.php?uf='+$(this).val(), function(result){
                //$('#slc_id_cdd_placeholder').hide();
                $('#slc_id_cdd').select2({
                    placeholder:'Selecione a Cidade...',
                    formatNoMatches: 'Sem Resultados...',
                    //formatSearching: '...',
                    data:result
                });
                var valinit = $('#slc_id_cdd').attr('valinit');
                if(valinit!='' && valinit > 0){
                    $('#slc_id_cdd').select2("val",valinit);
                    $('#slc_id_cdd').attr('valinit','');
                    //console.log('valinit: '+valinit);
                }//if
            },'json');
            //console.log('cdd: '+$('#slc_id_cdd').val());
        }else{
            //console.log('hein? '+$('#slc_id_cdd').val());
            $('#slc_id_cdd').select2({
                    placeholder:'Selecione a Cidade...',
                    formatNoMatches: 'Sem Resultados...',
                    //formatSearching: '...',
                    data:[]
                });
        }//if
    }).trigger('change');

    handleValidation();
    /*
    $('.checkValue').on('change', function() {
        var campo = $(this).attr('id');
        var tipo = $(this).attr('checktipo');
        verificaExisteCampoInformado(campo,tipo);
    });//.trigger('change');
*/

});// $ document

function isPF(){
    var rdo_tipo_pessoa = $('input[name=rdo_tipo_pessoa]:checked').val();
    if(rdo_tipo_pessoa == "PF"){
        return true;
    }//if
    return false;
}//fnc

var boolPedeSenha = function(){
    var checked = $('#chk_senha').is(":checked");
    var obj_id = $('#hdd_id').val();
    if (checked || obj_id == 0) {
        return true;
    }else{
        return false;
    }//if
}


var handleValidation = function() {

    var formulario = $('#frm_edit');
    var errorFormAlert = $('.alert-danger', formulario);
    var successFormAlert = $('.alert-success', formulario);

    formulario.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, 
                ignore: "",
                rules: {
                    txt_razao_social:{
                        minlength: 5,
                        required: function () { return (isPF()?false:true);}
                    },
                    txt_nome_fantasia: {
                        minlength: 2,
                        required: function () { return (isPF()?false:true);}
                    },
                    txt_cnpj: {
                        minlength: 18,
                        required: function () { return (isPF()?false:true);}
                    },

                    txt_pf_nome: {
                        minlength: 2,
                        required: function () { return (isPF()?true:false);}
                    },
                    txt_pf_cpf: {
                        minlength: 14,
                        required: function () { return (isPF()?true:false);}
                    },

                    txt_end_rua: {
                        required: true
                    },
                    txt_end_cep: {
                        minlength: 9,
                        required: true
                    },
                    slc_uf: {
                        required: true
                    },
                    slc_id_cdd: {
                        required: true,
                        digits: true,
                        min:1
                    },
                    txt_fone: {
                        required: true
                    },
                    slc_id_atv: {
                        required: true
                    },
                    txt_num_empregados_anterior:{
                        required: true,
                        digits: true,
                        min:1
                    }
                },
                messages:{
                    slc_id_cdd:{
                        min:'Este campo é obrigatório.'
                    }
                },
                
                invalidHandler: function (event, validator) {
                    //display error alert on form submit
                    successFormAlert.hide();
                    errorFormAlert.show();
                    console.log('error!');
                    Metronic.scrollTo(errorFormAlert, -200);
                },
                
                errorPlacement: function (label, element) { // render error placement for each input type   
                    /*
                    if (element.attr("name") == "gender") { // for uniform radio buttons, insert the after the given container
                        errorFormAlert.insertAfter("#form_gender_error");
                    } else if (element.attr("name") == "chk_termos") { // for uniform checkboxes, insert the after the given container
                        errorFormAlert.insertAfter("#form_termos_error");
                    } else {
                        errorFormAlert.insertAfter(element.parent()); // for other inputs, just perform default behavior
                    }
                    */
                },
                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    if (label.attr("for") == "gender" || label.attr("for") == "chk_termos") { // for checkboxes and radio buttons, no need to show OK icon
                        label
                            .closest('.form-group').removeClass('has-error').addClass('has-success');
                        label.remove(); // remove error label here
                    } else { // display success icon for other inputs
                        label
                            .addClass('valid') // mark the current input as valid and display OK icon
                        .closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    }
                },
                
                submitHandler: function (form) {
                    successFormAlert.hide();
                    //formulario.submit();
                    form.submit();
                }
    });
}//fnc validation


function showSuccess(){
    var formulario = $('#frm_edit');
    var successFormAlert = $('.alert-success', formulario);
    successFormAlert.show();
    Metronic.scrollTo(successFormAlert, -200);
    setTimeout('hideAlerts',5000);
}//fnc

function hideAlerts(){
    var formulario = $('#frm_edit');
    var successFormAlert = $('.alert-success', formulario);
    var errorFormAlert = $('.alert-error', formulario);
    successFormAlert.hide();
    errorFormAlert.hide();
}//fnc



function setPFPJ(qual){
    $('.classPF').hide();
    $('.classPJ').hide();
    $('.class'+qual).show();
}//fnc

function falhaCadastro(qual){
    var msg = '';
    switch(qual){
        case 1:
            msg = 'CPF já consta no nosso cadastro!';
        break;
        case 2:
            msg = 'E-mail inválido!';
        break;
        case 3:
            msg = 'Senha e confirmação de senha não conferem!';
        break;
        case 4:
            msg = 'É necessário aceitar os termos de uso!';
        break;
    }//sw

    if(qual > 0){
        $("#cad_div_alert").show();
    }else{
        $("#cad_div_alert").hide();
    }//if

    $("#cad_spn_desc").text(msg);

    Metronic.scrollTo($('#cad_div_alert'), -200);
    
}//fnc


function encaminhaCadastro(){
    falhaCadastro(0);
    document.location.href = './';
}//fnc

function copiaMeusDados(){
    if( $('#chk_meus_dados').is(':checked') ){
        $('#txt_pf_nome').val($('#txt_nome').val());
        $('#txt_pf_cpf').val($('#txt_cpf').val());
    }//if
}//fnc


function verificaExisteCampoInformado(campo,tipo){
  var lnk_dest = 'ajax/ajax_verifica_campo.php';
  var obJCampo = $('#'+campo);
  var str_now = getNowString();

  falhaCadastro(0);

  $.post(lnk_dest, { valor:obJCampo.val(),qual:tipo,now : str_now },
    function(resposta){
        if(resposta.indexOf('[sim]')>=0){
            falhaCadastro(1);
        }//if
    }
  );
}