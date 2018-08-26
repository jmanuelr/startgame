<?
	require_once(__DIR__.'/../lib/includes/session.inc.php');

	require_once(__DIR__."/../lib/classes/class.RN.php");
	require_once(__DIR__."/../lib/classes/class.faseBD.php");
	require_once(__DIR__."/../lib/classes/class.taskBD.php");
	require_once(__DIR__."/../lib/classes/class.task_faseBD.php");

	session::start();

	$condicao_filtro = "";

	$wrk_id = $_REQUEST["wrk"];
	$search = trim($_REQUEST["q"]);
	if( strlen( $search ) > 2 ){
		$condicao_filtro.= " AND ( ";
			$condicao_filtro.= " tsk_titulo like '%".$search."%'";
			$condicao_filtro.= " OR tsk_descricao like '%".$search."%'";
			$condicao_filtro.= " OR tsk_id_cln IN (select cln_id from gnb_cliente where cln_nome like '%".$search."%' OR cln_razao_social = '%".$search."%' and cln_id_cln = ".$_SESSION["sss_usr_id_cln"].")";
		$condicao_filtro.= " )";

	}else{
		echo "[]";
		exit;
	}//if

	//tsk_id_wrk = ".$wrk_id." AND

	$oListaTask = TaskBD::getLista("tsk_status = 'A'".$condicao_filtro." AND tsk_id_wrk IN (select wrk_id from gnb_workflow where wrk_id_cln = ".$_SESSION["sss_usr_id_cln"].")");//,"tsk_dt_registro DESC" //." AND tsk_id_cln = ".$_SESSION["sss_usr_id_cln"]

	$arr_retorno = array();

	foreach($oListaTask as $oTask){
		$arr_task = array(
			"tsk_id" 		=> $oTask->Id,
			"tsk_pai" 		=> $oTask->_Task,
			"tsk_status" 	=> "'".$oTask->Status."'",
			"tsk_class_alerta" => 'primary',
			"tsk_titulo" 	=> $oTask->Titulo,
			"tsk_cln_nome" 	=> $oTask->Cliente->Nome,
			"fse_id" 		=> $oTask->_Fase,
			"wrk_id" 		=> $oTask->_Workflow
		);

		$arr_retorno[] = $arr_task;

	}//foreach



	echo json_encode($arr_retorno);

?>