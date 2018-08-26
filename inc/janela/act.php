<?
	include(__DIR__."/../key_control.php");

    $oJanela = $oObjeto;

    $jnl_id = $obj_id;

    if($sis_id == 0 && $_REQUEST["hdd_id_sis"] > 0) $sis_id = $_REQUEST["hdd_id_sis"];

function reordenaLista($id_objeto = 0, $slc_ordem = 0){
	global $sis_id;
    //======================================= ordem ======>>
    $condicao = "jnl_id_sis = " . $sis_id;
    if ($id_objeto > 0) {
        $condicao .= " AND jnl_id != " . $id_objeto;
    }
    
    $oListaJanela = JanelaBD::getLista($condicao, "jnl_ordem");
    $nova_ordem     = 0;
    foreach ($oListaJanela as $oJanela) {
        $nova_ordem++;
        if ($nova_ordem == $slc_ordem) {
            $nova_ordem++;
        }//if
        
        $oJanela->Ordem = $nova_ordem;
        JanelaBD::alter($oJanela);
    } //foreach
    //======================================= ordem ======<<
} //fnc

	//======================================= Janela ======
	$txt_nome 			= trim($_REQUEST["txt_nome"]);
	$txt_url 			= trim($_REQUEST["txt_url"]);
	$slc_ordem 			= intval($_REQUEST["slc_ordem"]);
	$txt_status 		= trim($_REQUEST["txt_status"]);

	if ($slc_ordem == 0) {
	    $condicao_seq = "jnl_id_sis = " . $sis_id;
	    $arr_seq      = JanelaBD::getCustomLista($condicao_seq, '', 'MAX(jnl_ordem) as ordem', '', '', '', '', false);
	    $slc_ordem    = is_numeric($arr_seq[0]["ordem"]) ? (intval($arr_seq[0]["ordem"]) + 1) : 1;
	} //if

	if(is_object($oJanela)){
		$bool_obj_novo = false;
	}else{
		$bool_obj_novo = true;
		$oJanela = new Janela;

		$oJanela->Sistema 			= $sis_id;
	}//if

	$oJanela->Nome 			= $txt_nome;
	$oJanela->Url 			= $txt_url;
	$oJanela->Ordem 		= $slc_ordem;
	$oJanela->Status 		= $txt_status;



	if($bool_obj_novo){
		$jnl_id = JanelaBD::add($oJanela);
		$alert_msg = "Registro criado com sucesso!";
	}else{
		JanelaBD::alter($oJanela);
		$alert_msg = "Registro alterado com sucesso!";
	}//if

	reordenaLista($jnl_id, $slc_ordem);

//mnu=11&page=telas&fonte=10&act=lst&sis=1
?><script>
	alert('<?=$alert_msg?>');
	top.location.href='./?mnu=<?=$_REQUEST["mnu"]?>&page=telas&fonte=<?=$_REQUEST["fonte"]?>&act=lst&sis=<?=$sis_id?>';
</script>