<?
	include(__DIR__."/../key_control.php");

    $oCliente = $oObjeto;
    $cln_id = $obj_id;

	$txt_razao_social 	= trim($_REQUEST["txt_razao_social"]);
	$txt_nome 			= trim($_REQUEST["txt_nome"]);
	$txt_cnpj_cpf 		= preg_replace("/[^0-9]/i","",$_REQUEST["txt_cnpj_cpf"]);
	$txt_obs	 		= trim($_REQUEST["txt_obs"]);
	$txt_status 		= trim($_REQUEST["txt_status"]);

	if(is_object($oCliente)){
		$bool_obj_novo = false;
	}else{
		$bool_obj_novo = true;
		$oCliente = new Cliente;
		//$oCliente->Status 			= "A";
		$oCliente->DtCadastro 		= date("Ymd");
		$oCliente->HrCadastro 		= date("H:i");
		$oCliente->Cliente 			= $_SESSION["sss_usr_id_cln"];
		$oCliente->Usuario 			= $_SESSION["sss_usr_id"];
	}//if

	$oCliente->Nome 		= $txt_nome;
	$oCliente->RazaoSocial 	= $txt_razao_social;
	$oCliente->CnpjCpf 		= $txt_cnpj_cpf;
	$oCliente->Obs 			= $txt_obs;
	$oCliente->Status 		= $txt_status;

	if($bool_obj_novo){
		$cln_id = ClienteBD::add($oCliente);
		$alert_msg = "Registro criado com sucesso!";
	}else{
		ClienteBD::alter($oCliente);
		$alert_msg = "Registro alterado com sucesso!";
	}//if

	//======================================= contato ======

	$hdd_id_cnt = preg_replace("/[^0-9]/i","",$_REQUEST["hdd_id_cnt"]);
	if($hdd_id_cnt=="")$hdd_id_cnt = 0;

	$txt_cnt_nome 		= trim($_REQUEST["txt_cnt_nome"]);
	$txt_cnt_email 		= trim($_REQUEST["txt_cnt_email"]);
	$txt_cnt_fone 		= trim($_REQUEST["txt_cnt_fone"]);

	if($hdd_id_cnt > 0){
		$oContato = ContatoBD::get($hdd_id_cnt);
	}//if

	if(is_object($oContato)){
		$bool_contato_novo = false;
	}else{
		$bool_contato_novo = true;
		$oContato = new Contato;
		$oContato->Cliente  = $cln_id;
		$oContato->Status 	= "A";
	}//if

	$oContato->Nome 	= $txt_cnt_nome;
	$oContato->Email 	= $txt_cnt_email;
	$oContato->Fone 	= $txt_cnt_fone;

	if($bool_contato_novo){
		$cnt_id = ContatoBD::add($oContato);
	}else{
		ContatoBD::alter($oContato);
	}//if

	$oListaField = FieldBD::getLista("fld_id_cln = ".$_SESSION["sss_usr_id_cln"]." AND fld_status = 'A' AND fld_cadastro > 0","fld_nome");

	foreach($oListaField as $oField){
		$fld_id = $oField->Id;
		$value = trim($_REQUEST["txt_field_".$fld_id]);
		//-------------
		$condicao = "fts_id_fld = ".$fld_id;
		$condicao.= " AND fts_id_cln = ".$cln_id;
		$condicao.= " AND fts_id_wrk = 0";
		$condicao.= " AND fts_id_fse = 0";
		$condicao.= " AND fts_id_tsk = 0";

		FieldTaskBD::delByCondition($condicao);

		$value_numerico = floatval(str_replace(',', '.', str_replace('.', '', $value)));

		$arr_valor = array(
			'fts_id_fld' 	=> $fld_id,
			'fts_id_cln' 	=> $cln_id,
			'fts_id_wrk' 	=> 0,
			'fts_id_fse' 	=> 0,
			'fts_id_tsk' 	=> 0,
			'fts_resposta' 	=> "'".$value."'",
			'fts_numerico' 	=> "'".$value_numerico."'",
			'fts_id_usr' 	=> $_SESSION["sss_usr_id"]
		);

		FieldTaskBD::addCustom($arr_valor);
		//-------------
	}//foreach


	//exit;

?><script>
	alert('<?=$alert_msg?>');
	top.location.href='./?mnu=<?=$_REQUEST["mnu"]?>&page=customer';
</script><?
exit;
?>