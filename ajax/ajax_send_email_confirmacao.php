<?
	date_default_timezone_set('America/Sao_Paulo');

	require_once(__DIR__.'/../lib/includes/session.inc.php');
	require_once(__DIR__.'/../lib/classes/class.RN.php');
	require_once(__DIR__.'/../lib/classes/class.usuarioBD.php');
	require_once(__DIR__.'/../lib/classes/class.clienteBD.php');
	require_once(__DIR__.'/../lib/classes/class.atividadeBD.php');
	require_once(__DIR__.'/../lib/classes/class.regiaoBD.php');
	require_once(__DIR__.'/../lib/classes/class.estadoBD.php');
	require_once(__DIR__.'/../lib/classes/class.envio_email.php');

	session::start();

	$usr_id = preg_replace("/[^0-9]/i","", $_SESSION["sss_usr_id"]);
	if($usr_id=="")$usr_id=0;

	$oUsuario = UsuarioBD::get($usr_id);

	if(!is_object($oUsuario)){
		die("Usuário nao encontrado");
	}//if

	if($oUsuario->Confirmacao > 0){
		die("Usuário já confirmado");
	}//if

	//-------------------------------------------------------------------
	$dt_ymd = $oUsuario->DtRegistro;
	$dt_hi 	= $oUsuario->HrRegistro;
	$txt_cadastro_email = $oUsuario->Email;
	$usuario_primeiro_nome = RN::primeiraPalavra($oUsuario->Nome);
	//-------------------------------------------------------------------
	$strUrlSite 			= Config::appSettings("strUrlSite");

	$system_name 			= getVariavelConfig("sys_name");
	$sys_email_contact 		= getVariavelConfig("sys_email_contact");

	$app_main_url 			= getVariavelConfig("app_main_url");
	$web_main_url 			= getVariavelConfig("web_main_url");
	$web_social_facebook 	= getVariavelConfig("web_social_facebook");
	$web_social_twitter 	= getVariavelConfig("web_social_twitter");
	//-------------------------------------------------------------------


	//------------------------------------------------------------------- enviar confirmacao por email
	$user_hash = sha1($usr_id."|".$dt_ymd."|".$dt_hi);
	$link_confirmacao = $app_main_url.'/auth/?target=confirma&mail='.$txt_cadastro_email.'&hash='.$user_hash;
	//-------------------------------------------------------------------
	$mensagem = 'Olá, <strong>'.$usuario_primeiro_nome.'</strong>!';
	$mensagem.= '<br />Recebemos seu cadastro no <strong>Noobets</strong>.';
	$mensagem.= '<br />Para conluí-lo, por favor, confirme seu e-mail clicando no link abaixo:';
	$mensagem.= '<br /><br /><a href="'.$link_confirmacao.'" style="color:#3498db;">'.$link_confirmacao.'</a>';
    //-------------------------------------------------------------------
	$dados = array(
				"##_web_main_url_##" 	=> $web_main_url,
				"##_app_main_url_##" 	=> $app_main_url,
				"##_titulo_##"      	=> "Noobets - Cadastro",
				"##_mensagem_##"   		=> $mensagem
	);

	$bool_enviou = @EnvioEmail::enviar(
		$txt_cadastro_email,
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
?>