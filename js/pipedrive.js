function getPipelines(){
      var email         = $('#txt_pipe_email').val().trim();
      var password      = $('#txt_pipe_password').val().trim();
      var token         = $('#txt_pipe_token').val().trim();

      if(email!="" && password!=""){
            pipeAuth();
      }else if(token!=""){
            loadPipelines();
      }else{
            alert('Informe seu login e senha do pipedrive!');
      }//if

}//fnc

function pipeAuth(){
      //https://api.pipedrive.com/v1/authorizations?api_token=null
      var objTarget     = $('#div_retorno');
      var email         = $('#txt_pipe_email').val().trim();
      var password      = $('#txt_pipe_password').val().trim();
      var urlData = '&email='+email;
            urlData+= '&password='+password;
      //------
          $.ajax({
            type: "POST",
            url: "https://api.pipedrive.com/v1/authorizations?api_token=null",
            data: urlData,
            dataType:'json',
            success: function(response) {
                  if(response.success){
                        $('#txt_pipe_token').val(response.data[0].api_token);
                        //objTarget.html('<i class="icon-check"></i> ok: '+response.data[0].api_token);
                        saveTokenPipedrive(response.data[0].api_token);
                  }else{
                        console.log('erro get token');
                  }//if
            },
            beforeSend: function() {
                   objTarget.html('<i class="icon-spinner2 spinner"></i> Carregando...');
            },
            complete: function() {

            }
      });
}//fnc

function saveTokenPipedrive(pd_token){
      var urlData = '&token='+pd_token;
      var objTarget = $('#div_retorno');
      //------
          $.ajax({
            type: "POST",
            url: "ajax/ajax_save_pipedrive_token.php",
            data: urlData,
            //dataType:'json',
            success: function(response) {
                  loadPipelines();
            },
            beforeSend: function() {

            },
            complete: function() {

            }
      });
}//fnc


function loadPipelines(){
	//https://api.pipedrive.com/v1/persons/find?term=termotempera%40termotempera.com&start=0&search_by_email=1&api_token=04a28fb36489c6bff38b940178e9cd50b4fe7e1b
	var pd_token = $('#txt_pipe_token').val();
      //var objTarget = $('#div_retorno');
	var urlData = '';//'api_token='+pd_token;
	//------
    $.ajax({
            type: "GET",
            url: "https://api.pipedrive.com/v1/pipelines?api_token="+pd_token,
            data: urlData,
            dataType:'json',
            success: function(response) {
            	if(response.success){
            		//objTarget.html('<i class="icon-check"></i> ok: '+response);
                        //objTarget.html('');
                        var contador = 0;
                        $('.slcPipe').each(function(){
                              var idOriginal = $(this).attr('ppd');
                              var tmpConteudo = "<option value=''"+((idOriginal==''||idOriginal==0)?" selected":"")+">NENHUM</option>";
                              $(this).html('');
                              $(this).append(tmpConteudo);
                              for(var indice in response.data){
                                    if(contador==0)savePipedrives(response.data[indice].id,response.data[indice].name);
                                    $(this).append("<option value='"+response.data[indice].id + "'"+((idOriginal==response.data[indice].id)?" selected":"")+">" + response.data[indice].name+"</option>");
                              }//for
                              contador++;
                        });
                        
            	}else{
            		//objTarget.html('<i class="icon-warning"></i> Erro: '+response);
            	}//if
            },
            beforeSend: function() {
                  //objTarget.html('<i class="icon-spinner2 spinner"></i> Carregando......');
            },
            complete: function() {

            }
      });
      
}//fnc

function savePipeVinculo(wrk_id,ppl_id){
      var urlData = '&wrk='+wrk_id;
            urlData+= '&ppl='+ppl_id;
      //------
          $.ajax({
            type: "POST",
            url: "ajax/ajax_save_pipedrive_vinculo.php",
            data: urlData,
            success: function(response) {
                  //--
            },
            beforeSend: function() {

            },
            complete: function() {

            }
      });
}//fnc

function savePipedrives(ppl_id,ppl_name){
      var urlData = '&name='+ppl_name;
            urlData+= '&ppl='+ppl_id;
      //------
          $.ajax({
            type: "POST",
            url: "ajax/ajax_save_pipedrives.php",
            data: urlData,
            success: function(response) {
                  //--
            },
            beforeSend: function() {

            },
            complete: function() {

            }
      });
}//fnc

function puxaDeals(wrk_id){
      var btn = $('#btn_import_'+wrk_id);
      btn.button('loading');
      
	var urlData = '&wrk='+wrk_id;
            urlData+= '&ppl='+$('#slc_id_ppl_'+wrk_id).val();
      //------
          $.ajax({
            type: "POST",
            url: "ajax/ajax_pipeline_deals.php",
            data: urlData,
            success: function(response) {
                  //--
            },
            beforeSend: function() {

            },
            complete: function() {
                  btn.button('reset');
            }
      });
}//fnc