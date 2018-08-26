<?
	include(__DIR__."/../key_control.php");

    $oField = $oObjeto;
    $fld_id = $obj_id;

	$txt_nome 			= trim($_REQUEST["txt_nome"]);
	$txt_descricao 		= trim($_REQUEST["txt_descricao"]);
	$txt_default        = trim($_REQUEST["txt_default"]);
	$txt_tipo           = trim($_REQUEST["slc_tipo"]);/// [I]nput [T]extarea [N]umero inteiro [D]ecimal [S]elect [R]adio [C]heckbox
 	$txt_decimal        = 0;//0 nao, > 0 precisao
	$txt_status 		= trim($_REQUEST["txt_status"]);
	$txt_cadastro 		= intval($_REQUEST["txt_cadastro"]);

	if(is_object($oField)){
		$bool_obj_novo = false;
	}else{
		$bool_obj_novo = true;
		$oField = new Field;

		$oField->Cliente 			= $_SESSION["sss_usr_id_cln"];
		//$oField->Usuario 			= $_SESSION["sss_usr_id"];
		//$oField->Status 			= "A";
		//$oField->DtCadastro 		= date("Ymd");
		//$oField->HrCadastro 		= date("H:i");
	}//if

	$oField->Nome 			= $txt_nome;
	$oField->Descricao 		= $txt_descricao;
	$oField->Default 		= $txt_default;
	$oField->Tipo 			= $txt_tipo;
	$oField->Decimal 		= $txt_decimal;
	$oField->Status 		= $txt_status;
	$oField->Cadastro 		= $txt_cadastro;

	if($bool_obj_novo){
		$fld_id = FieldBD::add($oField);
		$alert_msg = "Registro criado com sucesso!";
	}else{
		FieldBD::alter($oField);
		$alert_msg = "Registro alterado com sucesso!";
	}//if

	$oListaWorkflow = WorkflowBD::getLista("wrk_status = 'A' AND wrk_id_cln = ".$_SESSION["sss_usr_id_cln"]);
	foreach($oListaWorkflow as $oWorkflow){
		if(isset($_REQUEST["txt_workflow_".$oWorkflow->Id])){
			FieldFaseBD::delByCondition("ffs_id_fld = ".$fld_id." AND ffs_id_wrk = ".$oWorkflow->Id." AND ffs_id_fse = 0");
			if(intval($_REQUEST["txt_workflow_".$oWorkflow->Id])>0){
				$arr_valor = array(
					'ffs_id_fld' 		=> $fld_id,
					'ffs_id_fse' 		=> 0,
					'ffs_id_wrk' 		=> $oWorkflow->Id,
					'ffs_seq' 			=> 0,
					'ffs_obrigatorio' 	=> (intval($_REQUEST["txt_workflow_".$oWorkflow->Id])>1?"'S'":"'N'")
				);
				FieldFaseBD::addCustom($arr_valor);
			}//if

		}//if
	}//foreach
	//txt_workflow_

	//======================================= contato ======



	//exit;

?><script>
	alert('<?=$alert_msg?>');
	top.location.href='./?mnu=<?=$_REQUEST["mnu"]?>&page=field';
</script><?
exit;
?>