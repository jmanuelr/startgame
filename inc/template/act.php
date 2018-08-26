<?
	include(__DIR__."/../key_control.php");

    $oTemplate = $oObjeto;

	//-----------------------------------------------------------
	$dt_ymd = date("Ymd");
	$dt_hi 	= date("H:i");
	//-------------------------------------------------------------------

	$admin_id = preg_replace("/[^0-9]/i","", $_SESSION["sss_usr_id"]);
	if($admin_id=="")$admin_id=0;

	$oTemplateAdmin = UsuarioBD::get($admin_id);
	$usuario_admin_primeiro_nome = RN::primeiraPalavra($oTemplateAdmin->Nome);

	//======================================= Usuario ======

	$obj_id = preg_replace("/[^0-9]/i","",$_REQUEST["id"]);
	if($obj_id=="")$obj_id = 0;



	//if($_SESSION["sss_usr_tipo"]=="A" || $obj_id == $_SESSION["sss_usr_id_cln"]){//
		//--
	//}else{
		//falhar!
	//	$oTemplate = null;
	//}//if

	$txt_titulo 		= trim($_REQUEST["txt_titulo"]);
	$txt_descricao 		= trim($_REQUEST["txt_descricao"]);
	$txt_conteudo 		= trim($_REQUEST["txt_conteudo"]);
	$txt_status 		= trim($_REQUEST["txt_status"]);

	//if($obj_id > 0){
	//	$oTemplate = TemplateBD::get($obj_id);
	//}//if

	if(is_object($oTemplate)){
		$bool_obj_novo = false;

		if($_SESSION["sss_usr_tipo"]!="A" && $oTemplate->_Cliente != $_SESSION["sss_usr_id_cln"]){
			die("erro: permissao");
		}//if
	}else{
		$bool_obj_novo = true;
		$oTemplate = new Template;
		$oTemplate->Cliente 	= $_SESSION["sss_usr_id_cln"];
		$oTemplate->Usuario 	= $_SESSION["sss_usr_id"];
		$oTemplate->Tipo		= "E";
	}//if

	//$oTemplate->DtCreated
	//$oTemplate->DtUpdated

	$oTemplate->Titulo 		= $txt_titulo;
	$oTemplate->Descricao 	= $txt_descricao;
	$oTemplate->Conteudo 	= $txt_conteudo;
	$oTemplate->Status 		= $txt_status;


	if($bool_obj_novo){
		$tmp_id = TemplateBD::add($oTemplate);
		$alert_msg = "Registro criado com sucesso!";
	}else{
		TemplateBD::alter($oTemplate);
		$alert_msg = "Registro alterado com sucesso!";
	}//if

	//exit;

?><script>
	alert('<?=$alert_msg?>');
	top.location.href='./?mnu=<?=$_REQUEST["mnu"]?>&page=emails';
</script>