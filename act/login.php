<?php
	$dirname = dirname(__FILE__);
	//-----------------------------------------------------------
	require_once($dirname."/../lib/includes/session.inc.php");
	require_once($dirname."/../lib/classes/class.usuarioBD.php");
	require_once($dirname."/../lib/classes/class.RN.php");

	//require_once($dirname."/../lib/classes/class.clienteBD.php");
	//require_once($dirname."/../lib/classes/class.configuracaoBD.php");
	//require_once($dirname."/../lib/classes/class.fornecedorBD.php");
	//require_once($dirname."/../lib/classes/class.empresa_associadaBD.php");
	//-----------------------------------------------------------
	$strUrlSite = Config::appSettings("strUrlSite");
	//$prefStatus = Config::appSettings("prefStatus");

	$cdd_id_login = 0;
	//-----------------------------------------------------------

	session::start();
	session::destroy();
	session::start();
	//---------------------------------------------------
	$url_destino	= "../";//http://".base64_decode(urldecode($_REQUEST["local"]));

	if( ($_REQUEST["form"]=="site") ){
		/*
		$url_destino	= $strUrlSite."/epgrs/";//"./";
		$txt_login		= eregi_replace("[^0-9]","",strtolower($_REQUEST["epgrs_login"]));
		$txt_password	= trim($_REQUEST["epgrs_senha"]);
		$txt_password	= sha1($txt_password);
		*/
	}else{
		$int_form		= is_numeric($_REQUEST["form"])?$_REQUEST["form"]:'';

		//$txt_login		= eregi_replace("[^0-9]","",strtolower($_REQUEST["username".$int_form]));
		//$txt_login 		= preg_replace("/[^0-9]/i", "", strtolower($_REQUEST["username".$int_form]));
		$txt_password	= $_REQUEST["password".$int_form];
		$txt_password	= sha1($txt_password);

		//$cdd_id_login 	= intval($_REQUEST["cdd"]);
		$txt_email 		= trim($_REQUEST["username".$int_form]);
	}
	//---------------------------------------------------


	$txt_email 		= filter_var($txt_email, FILTER_SANITIZE_EMAIL);

	$condicao = "usr_email = '" . $txt_email . "' AND usr_senha = '" . $txt_password . "' AND usr_status = 'A'";


	$oListaUsuario = UsuarioBD::getLista($condicao);

	/*
	if($prefStatus=="A"){
		$oListaUsuario = UsuarioBD::getLista("usr_cpf = '" . $txt_login . "' AND usr_password = '" . $txt_password . "' AND usr_status = 'A'");
	}else{
		$oListaUsuario = UsuarioBD::getLista("usr_cpf = '" . $txt_login . "' AND usr_password = '" . $txt_password . "' AND usr_status = 'A' AND usr_tipo IN ('A','P')");
		//$oListaUsuario = array();
	}//if
	*/


	$data_hoje = date("YmdHi");

	if(count($oListaUsuario) == 1){//


			session::save("validadordesessao", $data_hoje);
			session::save("sss_usr_id", $oListaUsuario[0]->Id);
			session::save("sss_usr_cpf", $oListaUsuario[0]->Cpf);
			session::save("sss_usr_nome", $oListaUsuario[0]->Nome);
			session::save("sss_usr_email", $oListaUsuario[0]->Email);
			session::save("sss_usr_tipo", $oListaUsuario[0]->Tipo);
			session::save("sss_usr_cnpj", $oListaUsuario[0]->Cnpj);//referente a empresa vinculada, segundo tipo
			session::save("sss_usr_id_cln", $oListaUsuario[0]->_Cliente);
			session::save("sss_usr_multi", false);

			switch ($oListaUsuario[0]->Tipo) {
				case 'A'://ADMIN
					$txt_label = "Admin";
				break;
				case 'C'://Cliente
					$txt_label = "Cliente";
					/*
					//$bool_imprime = true;
					$oListaCliente = ClienteBD::getLista("cln_cnpj = '".$oListaUsuario[0]->Cnpj."' AND cln_cnpj_eas = '' AND cln_cpf_cnpj_usr = '".$oListaUsuario[0]->CpfCnpj."' AND cln_status = 'A'","",0,1);
					foreach($oListaCliente as $oCliente){
						$txt_complemento .= $oCliente->RazaoSocial;
					}//foreach
					*/
				break;
				default:
					//-- ger prefeitura
					//$oPrefeitura = PrefeituraBD::get($oUsuario->_Cidade);
					$txt_label = "Outro";
					//$txt_complemento .= $oListaUsuario[0]->Cidade->Nome."/".$oListaUsuario[0]->Cidade->Uf;
				break;
			}//sw

			if($txt_complemento!="")$txt_label = $txt_complemento."<br />".$txt_label;

			session::save("sss_usr_nome_complemento", $txt_label);//.$txt_complemento

			echo "<scr"."ipt>top.location.href = '".$url_destino."';</scr"."ipt>";
		exit;
	}elseif(count($oListaUsuario) > 1){

			session::save("validadordesessao", $data_hoje);
			session::save("sss_usr_cpf_cnpj", $txt_login);
			session::save("sss_usr_multi", true);
			session::save("sss_usr_pass_temp", $txt_password);

			if( ($_REQUEST["form"]=="site") ){
				echo "<scr"."ipt>top.location.href = '../?erro=2&login=".$txt_login."';</scr"."ipt>";
			}else{
				echo "<scr"."ipt>top.verificaPerfisUsuario('".$txt_login."',".$int_form.");</scr"."ipt>";
			}//if

		exit;
	}else{

		if( ($_REQUEST["form"]=="site") ){
			echo "<scr"."ipt>top.location.href = '../?erro=1';</scr"."ipt>";
		}else{
			?>
			<script>
				//top.myAlert("ERRO","Usuário/Senha não coincidem!");
				alert('Usuário/Senha não coincidem!');
				//top.falhaLogin();
				//<?=$_SERVER['HTTP_HOST']?>
			</script>
			<?
		}
		exit;
	}
	unset($oListaUsuario);
?>