$(document).ready(function() {
	$('.select2').select2({
	  placeholder: "Selecionar...",
	  allowClear: true,
	  width: 400
	}).on("change", function(e) {
	      // mostly used event, fired to the original element when the value changes
	      console.log("change val=" + e.id);
	});


	$('#pnotify-solid-danger').on('click', function () {
        new PNotify({
            title: 'Danger notice',
            text: 'Check me out! I\'m a notice.',
            addclass: 'bg-danger'
        });
    });

    $('.filtroTask').on('keyup',function(){
    	//if($(this).val().length > 2){
    		procuraTask($(this).val(),$(this).attr('wrk'));
    	//}//if
    });

});

function procuraTask(texto,wrk){

	var objTarget = $('#table_wrk_'+wrk);

	var urlData = "";
	urlData += "&wrk="+wrk;
	urlData += "&q="+texto;

	$.ajax({
        type: "POST",
        url: "ajax/ajax_dash_find_tasks.php",
        data: urlData,
        success: function(data) {
        	objTarget.html(data);
        },
        beforeSend: function() {

        },
        complete: function() {

        }
    });
}//fnc


function selecionaCidadeAndGo(){
	var cdd = $('#slc_id_cdd').val();
	var uf  = $('#slc_uf').val();
	var urlData = "&uf="+uf+"&cdd="+cdd;

	$('#div_sel_modalidade').show();

	$.ajax({
        type: "POST",
        url: "ajax/ajax_load_modalidade.php",
        data: urlData,
        success: function(data) {
        	$('#slc_id_mdl').html(data);
        },
        beforeSend: function() {
        	$('#slc_id_mdl').html('<option disabled>Carregando...</option>');
        },
        complete: function() {
            //--
        }
    });

}//fnc