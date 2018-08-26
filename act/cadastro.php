<?
	date_default_timezone_set('America/Sao_Paulo');

	require_once(__DIR__.'/../lib/includes/session.inc.php');
	require_once(__DIR__.'/../lib/classes/class.RN.php');
	require_once(__DIR__.'/../lib/classes/class.usuarioBD.php');
	require_once(__DIR__.'/../lib/classes/class.clienteBD.php');
	require_once(__DIR__.'/../lib/classes/class.cidade_ibgeBD.php');
	//require_once(__DIR__.'/../lib/classes/class.porte_empresaBD.php');
	require_once(__DIR__.'/../lib/classes/class.atividadeBD.php');
	require_once(__DIR__.'/../lib/classes/class.regiaoBD.php');
	require_once(__DIR__.'/../lib/classes/class.estadoBD.php');
	require_once(__DIR__.'/../lib/classes/class.envio_email.php');

	//-------------------------------------------------------------------
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


	//echo "<pre>";
	//print_r($_REQUEST);
	//echo "</pre>";
	/*
	txt_cadastro_nome
	txt_cadastro_empresa
	txt_cadastro_fone
	txt_cadastro_email
	txt_cadastro_senha
	txt_cadastro_senha_conf
	*/

    // usuario -------
	$txt_cadastro_nome 			= ucwords(strtolower(trim($_REQUEST["txt_cadastro_nome"])));
	$txt_cadastro_empresa 		= ucwords(strtolower(trim($_REQUEST["txt_cadastro_empresa"])));
	//$txt_cpf 		= preg_replace("/[^0-9]/i","",$_REQUEST["txt_cpf"]);
	$txt_cadastro_fone 			= trim($_REQUEST["txt_cadastro_fone"]);
	$txt_cadastro_fone 			= preg_replace("/_/i","",$txt_cadastro_fone);
	$txt_cadastro_email 		= strtolower(trim($_REQUEST["txt_cadastro_email"]));
	$txt_cadastro_email 		= filter_var($txt_cadastro_email, FILTER_SANITIZE_EMAIL);

	$txt_cadastro_senha 		= trim($_REQUEST["txt_cadastro_senha"]);
	$txt_cadastro_senha_conf 	= trim($_REQUEST["txt_cadastro_senha_conf"]);

	// termos -------
	$chk_termos 		= intval($_REQUEST["chk_termos"]);

	// newsletter ------- // falta tratar!
	$chk_newsletter 	= intval($_REQUEST["chk_newsletter"]);
	$chk_newsletter 	= ($chk_newsletter==1)?"S":"N";

	// ---------------------- verificar email ok ------------------------ !
	if ( !filter_var($txt_cadastro_email, FILTER_VALIDATE_EMAIL) ){
		?>
		<script>
			top.falhaCadastro(2);
		</script>
		<?
		exit;
	}//if
	// ---------------------- verificar se password veio correto ------------------------ !
	if( ($txt_cadastro_senha!="") && ($txt_cadastro_senha == $txt_cadastro_senha_conf)){
		$txt_cadastro_senha = sha1($txt_cadastro_senha);
	}else{
		?>
		<script>
			top.falhaCadastro(3);
		</script>
		<?
		exit;
	}//if
	// ---------------------- verificar chk termos ------------------------ !
	/*
	if($chk_termos!=1){
		?>
		<script>
			top.falhaCadastro(4);
		</script>
		<?
		exit;
	}//if
	*/

	// ---------------------- verificar se email já existe ------------------------ !
	$oListaUsuario = UsuarioBD::getLista("usr_email = '".$txt_cadastro_email."'","",0,1);

	$bool_achou_usuario = false;

	if(count($oListaUsuario) > 0){
		$bool_achou_usuario = true;
		?>
		<script>
			top.falhaCadastro(1);
		</script>
		<?
		exit;
	}//if


	//----------------------------------

	if($bool_achou_usuario){
		$oUsuario = $oListaUsuario[0];
	}else{
		$oUsuario = new Usuario;
		$oUsuario->DtRegistro 	= $dt_ymd;
		$oUsuario->HrRegistro 	= $dt_hi;
		$oUsuario->Confirmacao 	= 0;
		$oUsuario->Supervisor	= "S";
	}//if

	//$oUsuario->Cpf			= $txt_cpf;
	$oUsuario->Nome			= $txt_cadastro_nome;
	$oUsuario->Email		= $txt_cadastro_email;
	$oUsuario->Fone			= $txt_cadastro_fone;
	$oUsuario->Senha		= $txt_cadastro_senha;
	$oUsuario->Cidade		= 0;
	$oUsuario->Uf			= '';
	$oUsuario->Tipo			= "C";
	$oUsuario->Status		= "A";

	$oUsuario->FlagNewsletter = $chk_newsletter;

	if($bool_achou_usuario){
		//UsuarioBD::alter($oUsuario);
		$usr_id = 0;//$oUsuario->Id;
	}else{
		$usr_id = UsuarioBD::add($oUsuario);
	}//if

	//----------------------------------
	$rdo_tipo_pessoa = "J";

	$oCliente = new Cliente;

	$oCliente->Usuario			= $usr_id;
	$oCliente->Tipo				= $rdo_tipo_pessoa;//$cln_tipo;


	$oCliente->Nome				= $txt_cadastro_empresa;
	$oCliente->RazaoSocial		= $txt_cadastro_empresa;


	$oCliente->CnpjCpf			= "";

	$oCliente->Cidade			= 0;
	$oCliente->Uf				= "";
	//$oCliente->EndRua			= $txt_end_rua;
	//$oCliente->EndNro			= $txt_end_nro;
	//$oCliente->EndCompl			= $txt_end_compl;
	//$oCliente->EndCep			= $txt_end_cep;
	//$oCliente->Fone 			= $txt_fone;
	$oCliente->Status  			= "A";

	$oCliente->Atividade             = 0;
	$oCliente->Modalidade            = 0;
    $oCliente->NumEmpregadosAnterior = 0;
    $oCliente->RelacaoParceiro       = "";
    $oCliente->Parceiros             = "";
    $oCliente->AutorizaDivulgacao    = "";

    $oCliente->PorteEmpresa          = 0;

    $oCliente->DtCadastro = $dt_ymd;//date("Ymd");
    $oCliente->HrCadastro = $dt_hi;//date("H:i");

    //$oEstado = EstadoBD::get($slc_uf);
    //$regiao_id = is_object($oEstado)?intval($oEstado->_Regiao):0;
    $oCliente->Regiao    = 0;//$regiao_id;
    //-----
    $oCliente->TipoAssinatura = "";//depois muda, qndo pagar.


	$cln_id = ClienteBD::add($oCliente);

	//----------------------------------
	$oUsuario = UsuarioBD::get($usr_id);
	$oUsuario->Cliente = $cln_id;
	UsuarioBD::alter($oUsuario);
	//----------------------------------

	$usuario_primeiro_nome = RN::primeiraPalavra($txt_cadastro_nome);

	//----------------------------------------- salvar em sessao -------------
	session::start();
	session::destroy();
	session::start();

	$data_hoje = date("YmdHi");
	session::save("validadordesessao", $data_hoje);
	session::save("sss_usr_id", $usr_id);
	//session::save("sss_usr_cpf", $txt_cpf);
	session::save("sss_usr_nome", $txt_cadastro_nome);
	session::save("sss_usr_primeiro_nome", $usuario_primeiro_nome);
	session::save("sss_usr_email", $txt_cadastro_email);
	session::save("sss_usr_tipo", "C");
	//session::save("sss_usr_cnpj", $txt_cnpj);//referente a empresa vinculada, segundo tipo
	session::save("sss_usr_id_cln", $cln_id);
	session::save("sss_usr_multi", false);
	session::save("sss_usr_nome_complemento", $txt_cadastro_empresa);
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

	//----------------------------------------- redirecionar -------------

	?>
		<script>
			top.encaminhaCadastro();
		</script>
	<?
	exit;
?>