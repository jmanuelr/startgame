<?
	include(__DIR__."/../key_control.php");

    $oSistema = $oObjeto;

    $sis_id = $obj_id;

	//======================================= Sistema ======
	$txt_nome 			= trim($_REQUEST["txt_nome"]);
	$txt_info 		= trim($_REQUEST["txt_info"]);
	$txt_status 		= trim($_REQUEST["txt_status"]);

	$slc_id_usr 		= $_REQUEST["slc_id_usr"];//Array

	if(is_object($oSistema)){
		$bool_obj_novo = false;
	}else{
		$bool_obj_novo = true;
		$oSistema = new Sistema;

		$oSistema->Cliente 			= $_SESSION["sss_usr_id_cln"];
		$oSistema->Usuario 			= $_SESSION["sss_usr_id"];
	}//if

	$oSistema->Nome 		= $txt_nome;
	$oSistema->Info 		= $txt_info;
	$oSistema->Status 		= $txt_status;

	if($bool_obj_novo){
		$sis_id = SistemaBD::add($oSistema);
		$alert_msg = "Registro criado com sucesso!";
	}else{
		SistemaBD::alter($oSistema);
		$alert_msg = "Registro alterado com sucesso!";
	}//if


?><script>
	alert('<?=$alert_msg?>');
	top.location.href='./?mnu=<?=$_REQUEST["mnu"]?>&page=sistema';
</script>