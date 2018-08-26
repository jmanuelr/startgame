<?
	require_once("../lib/classes/class.RN.php");
	require_once("../lib/classes/class.usuarioBD.php");
	require_once("../lib/classes/class.envio_email.php");

	/*
	template: esqueci_minha_senha.html
	##ano##
	##link##
	##sys_name##
	##logo##
	*/

	/*
	##web_site_frontend##
	##web_site_url_root##
	##SYSTEM_URL##
	##email_logo_header## https://www.indicadoresrh.com.br/benchmarking/img/str/logo_horizontal_w200.png
	##email_logo_alt## Bachmann &amp; Associados.
	##email_titulo##
	##email_sub_titulo##
	##email_descricao##
	 */

	$mensagem = "Recebemos um pedido para redefinir sua senha.<br />Caso você não tenha solicitado a redefinição de senha, apenas ignore esta mensagem.<br />Caso você precise redefinir sua senha, clique no link abaixo.<br /><br />";

	$retorno = array();

	$strUrlSite = Config::appSettings("strUrlSite");

	$txt_email 		= trim($_REQUEST["txt_senha_email"]);
	$txt_email 		= filter_var($txt_email, FILTER_SANITIZE_EMAIL);
	$condicao = "usr_email = '" . $txt_email . "' AND usr_status = 'A'";

	$oListaUsuario 	= UsuarioBD::getLista($condicao,"",0,1);

	if(count($oListaUsuario) > 0){

			$oUsuario = $oListaUsuario[0];

			$sha1 = sha1($oUsuario->Id.$oUsuario->Cpf.$oUsuario->Tipo.$oUsuario->Senha);

			$link	= $strUrlSite."?area=esqueci_minha_senha_confirmacao&id=".$oUsuario->Id."&key=".$sha1;

			$mensagem.= "<a href=\"".$link."\" target=\"_blank\">".$link."</a>";

			$dados = array(
				"##_web_main_url_##" 	=> $web_main_url,
				"##_app_main_url_##" 	=> $app_main_url,
				"##_titulo_##"      	=> "Noobets - Esqueci senha",
				"##_mensagem_##"   		=> $mensagem
			);

			$bool_enviou = @EnvioEmail::enviar(
				$oUsuario->Email,
				"[Esqueci minha senha]",
				"../webmails/template_email.html",
				$dados,
				"",
				"",
				"",
				false
				);


			if($bool_enviou){
				$retorno['success'] = 1;
				$retorno['msg'] 	= "Enviamos para seu e-mail um link para renovação de sua senha.";
				$retorno['link'] 	= $link;
			}else{
				$retorno['success'] = 0;
				$retorno['msg'] 	= "Ocorreu um erro ao enviar sua senha";
				$retorno['link'] 	= $link;
			}
	}else{
		$retorno['success'] = 2;
		$retorno['msg'] = "Não encontramos nenhum usuário cadastrado com essas informações.";
	}

	echo json_encode($retorno);
?>