function showMudaSenha(bool_chk){
	if(bool_chk){
		$('#div_muda_senha').show();
		$('#div_muda_senha_confirma').show();
	}else{
		$('#div_muda_senha').hide();
		$('#div_muda_senha_confirma').hide();
	}//if
}//fnc