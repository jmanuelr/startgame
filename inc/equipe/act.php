<?
	include(__DIR__."/../key_control.php");

    $oEquipe = $oObjeto;

    $eqp_id = $obj_id;

	//======================================= Equipe ======
	$txt_nome 			= trim($_REQUEST["txt_nome"]);
	$txt_descricao 		= trim($_REQUEST["txt_descricao"]);
	$txt_status 		= trim($_REQUEST["txt_status"]);

	$slc_id_usr 		= $_REQUEST["slc_id_usr"];//Array

	if(is_object($oEquipe)){
		$bool_obj_novo = false;
	}else{
		$bool_obj_novo = true;
		$oEquipe = new Equipe;

		$oEquipe->Cliente 			= $_SESSION["sss_usr_id_cln"];
		$oEquipe->Usuario 			= $_SESSION["sss_usr_id"];
	}//if

	$oEquipe->Nome 			= $txt_nome;
	$oEquipe->Descricao 	= $txt_descricao;
	$oEquipe->Status 		= $txt_status;

	if($bool_obj_novo){
		$eqp_id = EquipeBD::add($oEquipe);
		$alert_msg = "Registro criado com sucesso!";
	}else{
		EquipeBD::alter($oEquipe);
		$alert_msg = "Registro alterado com sucesso!";
	}//if

	EquipeUsuarioBD::delByCondition("esr_id_eqp = ".$eqp_id);

	if(is_array($slc_id_usr)){
		foreach($slc_id_usr as $membro){
			$arr_valor = array(
				"esr_id_eqp" => $eqp_id,
				"esr_id_usr" => $membro,
				"esr_status" => "'A'"
			);
			EquipeUsuarioBD::addCustom($arr_valor);
		}//foreach
	}//if

?><script>
	alert('<?=$alert_msg?>');
	top.location.href='./?mnu=<?=$_REQUEST["mnu"]?>&page=team';
</script>