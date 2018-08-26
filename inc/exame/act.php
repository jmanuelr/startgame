<?
	include(__DIR__."/../key_control.php");

    $oExame = $oObjeto;

    $exm_id = $obj_id;

	//======================================= Exame ======
	$txt_nome 			= trim($_REQUEST["txt_nome"]);
	$txt_dt_registro 	= trim($_REQUEST["txt_dt_registro"]);
	$txt_dt_registro 	= (strlen($txt_dt_registro)==10)?RN::StringDate($txt_dt_registro):"";
	$txt_descricao 		= trim($_REQUEST["txt_descricao"]);
	$txt_status 		= trim($_REQUEST["txt_status"]);

	$slc_id_usr 		= $_REQUEST["slc_id_usr"];//Arrays

	if(is_object($oExame)){
		$bool_obj_novo = false;
	}else{
		$bool_obj_novo = true;
		$oExame = new Exame;

		//$oExame->Cliente 			= $_SESSION["sss_usr_id_cln"];
		$oExame->Usuario 			= $_SESSION["sss_usr_id"];
	}//if

	$oExame->Nome 			= $txt_nome;
	$oExame->DtRegistro 	= $txt_dt_registro;
	$oExame->Descricao 		= $txt_descricao;
	$oExame->Status 		= 'A';//$txt_status;

	if($bool_obj_novo){
		$exm_id = ExameBD::add($oExame);
		$alert_msg = "Registro criado com sucesso!";
	}else{
		ExameBD::alter($oExame);
		$alert_msg = "Registro alterado com sucesso!";
	}//if

	ResultadoBD::delByCondition("rst_id_exm = ".$exm_id);//." AND rsl_id_exm = ".$exm_id

	//1:2]23:56]
	$hdd_antropometria = trim(str_replace("[","",$_REQUEST["hdd_antropometria"]));
	$arr_antropometria = explode("]",$hdd_antropometria);

	foreach($arr_antropometria as $antropometria){
		$arr_dados = explode(":",$antropometria);
		if(trim($arr_dados[1])!=""){
			$arr_valor = array(
				"rst_id_exm" => $exm_id,
				"rst_id_usr" => $_SESSION["sss_usr_id"],
				"rst_id_ant" => intval($arr_dados[0]),
				"rst_valor"  => "'".$arr_dados[1]."'",
				"rst_string" => "'".$arr_dados[1]."'"
			);
			ResultadoBD::addCustom($arr_valor);
		}//if
	}//if

?><script>
	alert('<?=$alert_msg?>');
	//top.location.href='./?mnu=<?=$_REQUEST["mnu"]?>&page=exame';
</script>