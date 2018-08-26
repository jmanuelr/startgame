<?
	include(__DIR__."/../key_control.php");

    $oUsuario = $oObjeto;

    $usr_id = $obj_id;
	//-----------------------------------------------------------
	$dt_ymd = date("Ymd");
	$dt_hi 	= date("H:i");
	//-------------------------------------------------------------------
	$strUrlSite 			= Config::appSettings("strUrlSite");

	$system_name 			= getVariavelConfig("sys_name");
	$sys_email_contact 		= getVariavelConfig("sys_email_contact");

	$app_main_url 			= getVariavelConfig("app_main_url");
	$web_main_url 			= getVariavelConfig("web_main_url");
	$web_social_facebook 	= getVariavelConfig("web_social_facebook");
	$web_social_twitter 	= getVariavelConfig("web_social_twitter");
	//-------------------------------------------------------------------

	$admin_id = preg_replace("/[^0-9]/i","", $_SESSION["sss_usr_id"]);
	if($admin_id=="")$admin_id=0;

	$oUsuarioAdmin = UsuarioBD::get($admin_id);
	$usuario_admin_primeiro_nome = RN::primeiraPalavra($oUsuarioAdmin->Nome);

	//======================================= Usuario ======

	$obj_id = preg_replace("/[^0-9]/i","",$_REQUEST["id"]);
	if($obj_id=="")$obj_id = 0;
	$usr_id = $obj_id;


	//if($_SESSION["sss_usr_tipo"]=="A" || $obj_id == $_SESSION["sss_usr_id_cln"]){//
		//--
	//}else{
		//falhar!
	//	$oUsuario = null;
	//}//if

	$txt_nome 			= trim($_REQUEST["txt_nome"]);
	$txt_email 			= trim($_REQUEST["txt_email"]);
	$txt_dt_nasc 		= trim($_REQUEST["txt_dt_nasc"]);
	$txt_dt_nasc 		= (strlen($txt_dt_nasc)==10)?RN::StringDate($txt_dt_nasc):"";
	$txt_supervisor 	= trim($_REQUEST["txt_supervisor"]);
	$txt_status 		= trim($_REQUEST["txt_status"]);
	$slc_id_eqp 		= $_REQUEST["slc_id_eqp"];//Array

	$chk_senha 		= intval($_REQUEST["chk_senha"]);
	$txt_nova_senha 			= $_REQUEST["txt_nova_senha"];
	$txt_nova_senha_confirma 	= $_REQUEST["txt_nova_senha_confirma"];


	if($obj_id > 0){
		$oUsuario = UsuarioBD::get($obj_id);
	}//if

	if(is_object($oUsuario)){
		$bool_obj_novo = false;

		if($_SESSION["sss_usr_tipo"]!="A" && $oUsuario->_Cliente != $_SESSION["sss_usr_id_cln"]){
			die("erro: permissao");
		}//if
	}else{
		$bool_obj_novo = true;
		$oUsuario = new Usuario;
		//$oUsuario->Status 			= "A";
		$oUsuario->Cliente 			= $_SESSION["sss_usr_id_cln"];
		$oUsuario->IdPrf 			= 0;
		$oUsuario->Confirmacao 		= 0;

		$oUsuario->DtRegistro 	= $dt_ymd;
		$oUsuario->HrRegistro 	= $dt_hi;
		$oUsuario->Tipo			= "C";

		$random_senha 	= randomPassword(8);

		$oUsuario->Senha 		= sha1($random_senha);

	}//if

	$oUsuario->Nome 		= $txt_nome;
	$oUsuario->Email 		= $txt_email;
	$oUsuario->DtNasc 		= $txt_dt_nasc;
	//$oUsuario->Supervisor 	= $txt_supervisor;

	if($usr_id!=$_SESSION["sss_usr_id"]){
		$oUsuario->Status 		= $txt_status;
	}//if

	$usuario_primeiro_nome = RN::primeiraPalavra($txt_nome);

	if($bool_obj_novo){
		$usr_id = UsuarioBD::add($oUsuario);
		$alert_msg = "Registro criado com sucesso!";
	}else{
		if($chk_senha == 1 && ($txt_nova_senha == $txt_nova_senha_confirma) && ($txt_nova_senha != "") ){
			//$random_senha = $txt_nova_senha;
			$oUsuario->Senha = sha1($txt_nova_senha);
		}//if
		UsuarioBD::alter($oUsuario);
		$alert_msg = "Registro alterado com sucesso!";
	}//if

	EquipeUsuarioBD::delByCondition("esr_id_usr = ".$usr_id);

	if(is_array($slc_id_eqp)){
		foreach($slc_id_eqp as $equipe){
			$arr_valor = array(
				"esr_id_eqp" => $equipe,
				"esr_id_usr" => $usr_id,
				"esr_status" => "'A'"
			);
			EquipeUsuarioBD::addCustom($arr_valor);
		}//foreach
	}//if

	if($bool_obj_novo){
		//------------------------------------------------------------------- enviar confirmacao por email
		$user_hash = sha1($usr_id."|".$dt_ymd."|".$dt_hi);
		$link_confirmacao = $app_main_url.'/auth/?target=confirma&mail='.$txt_email.'&hash='.$user_hash;
		//-------------------------------------------------------------------
		$mensagem = 'Olá, <strong>'.$usuario_primeiro_nome.'</strong>!';
		$mensagem.= '<br /><strong>'.$usuario_admin_primeiro_nome.'</strong> cadastrou você no <strong>Goonbo</strong>.';
		$mensagem.= '<br />Seus dados de acesso são:<br />';

		$mensagem.= '<br />Login: <strong>'.$txt_email.'</strong>';
		$mensagem.= '<br />Senha: <strong>'.$random_senha.'</strong>';

		$mensagem.= '<br /><br />Para conluir seu cadastro, por favor, confirme seu e-mail clicando no link abaixo:';
		$mensagem.= '<br /><br /><a href="'.$link_confirmacao.'" style="color:#3498db;">'.$link_confirmacao.'</a>';
	    //-------------------------------------------------------------------
		$dados = array(
					"##_web_main_url_##" 	=> $web_main_url,
					"##_app_main_url_##" 	=> $app_main_url,
					"##_titulo_##"      	=> "Noobets - Cadastro",
					"##_mensagem_##"   		=> $mensagem
		);

		$bool_enviou = @EnvioEmail::enviar(
			$txt_email,
			"Confirme seu cadastro no Noobets",
			"../webmails/template_email.html",
			$dados,
			"",//reply_email
			"",//filepath
			"",//filename
			false
		);


		if($bool_enviou){
			$valor_retorno_envio = 1;
		}else{
			$valor_retorno_envio = 0;
		}//if
		//-------------------------------------------------------------------
	}//if


?><script>
	alert('<?=$alert_msg?>');
	top.location.href='./?mnu=<?=$_REQUEST["mnu"]?>&page=user';
</script>