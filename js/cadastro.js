$(document).ready(function(){

          // Phone #
    $('.format-phone-number').formatter({
        pattern: '({{99}}) {{99999}}-{{9999}}'
    });

    //var target = getParameterByName('target');
    //if(target == 'cadastro' || target == 'senha'){
    //    showBoxLogin(target);
    //}//if

    //$('.checkValue').on('change', function() {
    //    var campo = $(this).attr('id');
    //    var tipo = $(this).attr('checktipo');
    //    verificaExisteCampoInformado(campo,tipo);
    //});//.trigger('change');
    //--------------------------------------------->>
    // Setup validation
    // ------------------------------

    // Initialize
    var validator = $("#frm_cadastro").validate({
        ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },

        // Different components require proper error label placement
        errorPlacement: function(error, element) {

            // Styled checkboxes, radios, bootstrap switch
            if (element.parents('div').hasClass("checker") || element.parents('div').hasClass("choice") || element.parent().hasClass('bootstrap-switch-container') ) {
                if(element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                    error.appendTo( element.parent().parent().parent().parent() );
                }
                 else {
                    error.appendTo( element.parent().parent().parent().parent().parent() );
                }
            }

            // Unstyled checkboxes, radios
            else if (element.parents('div').hasClass('checkbox') || element.parents('div').hasClass('radio')) {
                error.appendTo( element.parent().parent().parent() );
            }

            // Input with icons and Select2
            else if (element.parents('div').hasClass('has-feedback') || element.hasClass('select2-hidden-accessible')) {
                error.appendTo( element.parent() );
            }

            // Inline checkboxes, radios
            else if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                error.appendTo( element.parent().parent() );
            }

            // Input group, styled file input
            else if (element.parent().hasClass('uploader') || element.parents().hasClass('input-group')) {
                error.appendTo( element.parent().parent() );
            }

            else {
                error.insertAfter(element);
            }
        },
        validClass: "validation-valid-label",
        success: function(label,errorClass) {
            //label.addClass("validation-valid-label").text("")
            $(label).remove();
             //$(label).removeClass(errorClass);
             //console.log('first: '+label.parent().find(">:first-child").attr('id'));
        },
        rules: {
            txt_cadastro_nome:{
                required: true,
                minlength: 3
            },
            txt_cadastro_empresa:{
                required: true
            },

            txt_cadastro_email:{
                required: true,
                email: true
            },
            txt_cadastro_senha: {
                minlength: 5
            },
            txt_cadastro_senha_conf: {
                equalTo: "#txt_cadastro_senha"
            }//,
            //chk_termos: {
            //    minlength: 1
            //}
        },
        messages: {
            //chk_termos: "É obrigatório aceitar os Termos de serviço"
        }
    });


    // Reset form
    $('#reset').on('click', function() {
        validator.resetForm();
    });
    //---------------------------------------------<<

});//document ready



function falhaCadastro(qual){
    var msg = '';
    switch(qual){
        case 1:
            msg = 'E-mail já está cadastrado!';
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

    $('html, body').animate({
        scrollTop: $("#cad_div_alert").offset().top
    }, 2000);

}//fnc

function encaminhaCadastro(){
    document.location.href = '../';
}//fnc

function verificaExisteCampoInformado(campo,tipo){
  var lnk_dest = 'ajax/ajax_verifica_campo.php';
  var obJCampo = $('#'+campo);
  var str_now = getNowString();

  //falhaCadastro(0);

  $.post(lnk_dest, { valor:obJCampo.val(),qual:tipo,now : str_now },
    function(resposta){
        if(resposta.indexOf('[sim]')>=0){
            //falhaCadastro(1);
        }//if
    }
  );
}//fnc

function showBoxLogin(qual){
    $('#frm_login').hide();
    $('#frm_senha').hide();
    $('#frm_reset').hide();
    $('#frm_cadastro').hide();
    $('#frm_confirma').hide();

    $('#frm_'+qual).show();
}//fnc