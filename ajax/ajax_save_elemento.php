<?
	date_default_timezone_set('America/Sao_Paulo');

	require_once(__DIR__.'/../lib/includes/session.inc.php');
	require_once(__DIR__.'/../lib/classes/class.usuarioBD.php');
	require_once(__DIR__.'/../lib/classes/class.clienteBD.php');
	require_once(__DIR__.'/../lib/classes/class.workflowBD.php');
	require_once(__DIR__.'/../lib/classes/class.janelaBD.php');
	require_once(__DIR__.'/../lib/classes/class.sistemaBD.php');
	require_once(__DIR__.'/../lib/classes/class.elementoBD.php');

	session::start();


	$sis_id = preg_replace("[^0-9]","", $_REQUEST["sis"]);
	if($sis_id=="")$sis_id=0;

	$jnl_id = preg_replace("[^0-9]","", $_REQUEST["jnl"]);
	if($jnl_id=="")$jnl_id=0;

	$elm_id = preg_replace("[^0-9]","", $_REQUEST["elm"]);
	if($elm_id=="")$elm_id=0;

	$usr_id = preg_replace("[^0-9]","", $_SESSION["sss_usr_id"]);
	if($usr_id=="")$usr_id=0;

	$cln_id = preg_replace("[^0-9]","", $_SESSION["sss_usr_id_cln"]);
	if($cln_id=="")$cln_id=0;

	$bool_erro = false;

	if($usr_id == 0){
		$arr_retorno = array(
			"success" => false,
			"msg" => "Error: User not found"
		);
	}//if
	if($sis_id == 0){
		$arr_retorno = array(
			"success" => false,
			"msg" => "Error: System not found"
		);
	}//if
	if($jnl_id == 0){
		$arr_retorno = array(
			"success" => false,
			"msg" => "Error: Window not found"
		);
	}//if

	$oSistema = SistemaBD::get($sis_id);

	if($cln_id != $oSistema->_Cliente){
		$arr_retorno = array(
			"success" => false,
			"msg" => "Error: Sistema not allowed"
		);
	}//if

	if($bool_erro){
		echo json_encode($arr_retorno);
		exit;
	}//if

	//-----------------------------
	$elm_by_id   	= $_REQUEST["byid"];
	$elm_by_name 	= $_REQUEST["byname"];
	$elm_path 	 	= $_REQUEST["path"];
	$elm_titulo  	= $_REQUEST["titulo"];
	$elm_descricao  = $_REQUEST["descricao"];
	//-----------------------------

	if($elm_id > 0){
		$oElemento = ElementoBD::get($elm_id);
		$bool_new_object = false;
	}else{

		$oListaElemento = ElementoBD::getLista("elm_id_sis = ".$sis_id." AND elm_id_jnl = ".$jnl_id." AND elm_by_id = '".$elm_by_id."'");
		if(count($oListaElemento)>0){
			$arr_retorno = array(
				"success" => false,
				"msg" => "Error: Elemento já foi adicionado"
			);
			echo json_encode($arr_retorno);
			exit;
		}//if


		$oElemento = new Elemento;
		$bool_new_object = true;
		//----------------------
        $condicao_seq = "elm_id_sis = ".$sis_id." AND elm_id_jnl = ".$jnl_id;
        $arr_seq = ElementoBD::getCustomLista($condicao_seq, '', 'MAX(elm_ordem) as ordem', '', '', '', '', false);
        $contador_seq = is_numeric($arr_seq[0]["ordem"])?(intval($arr_seq[0]["ordem"]) + 1):1;
        //----------------------
        $oElemento->Ordem 		= $contador_seq;
	}//if

	$oElemento->Sistema 	= $sis_id;
	$oElemento->Janela 		= $jnl_id;
	$oElemento->Type 		= "";
	$oElemento->ById 		= $elm_by_id;
	$oElemento->ByName 		= $elm_by_name;
	$oElemento->Path 		= $elm_path;
	$oElemento->Trigger 	= "";
	$oElemento->Callback 	= "";
	$oElemento->Status 		= 1;
	$oElemento->Titulo 		= $elm_titulo;
	$oElemento->Desc 		= $elm_descricao;

	if($bool_new_object){
		ElementoBD::add($oElemento);
		$msg = "Elemento adicionado";
	}else{
		ElementoBD::alter($oElemento);
		$msg = "Elemento modificado";
	}//if

	$arr_retorno = array(
		"success" => true,
		"msg" => $msg
	);
	echo json_encode($arr_retorno);
?>