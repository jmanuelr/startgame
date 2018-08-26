<?
	require_once(__DIR__.'/../lib/classes/class.usuarioBD.php');
	require_once(__DIR__.'/../lib/classes/class.clienteBD.php');
	require_once(__DIR__.'/../lib/classes/class.contatoBD.php');
	require_once(__DIR__.'/../lib/classes/class.workflowBD.php');
	require_once(__DIR__.'/../lib/classes/class.faseBD.php');
	require_once(__DIR__.'/../lib/classes/class.questionBD.php');
	require_once(__DIR__.'/../lib/classes/class.taskBD.php');

	//'&tipo'+tipo+'&ordem='+ordem+'&wrk='+wrk_id+'&fse='+fse_id+'&qst='+qst_id;

	$wrk_id = $_REQUEST["wrk"];
	$fse_id = $_REQUEST["fse"];
	$qst_id = $_REQUEST["qst"];
	$tipo 	= $_REQUEST["tipo"];
	$ordem 	= $_REQUEST["ordem"];

	$oWorkflow = WorkflowBD::get($wrk_id);

	//------------------ workflow
	//
	$arr_ordem = explode(",",$ordem);
	$arr_new_ordem = array();
	foreach($arr_ordem as $tmp_ordem){
		if($tmp_ordem!=""){
			$arr_new_ordem[] = $tmp_ordem;
		}//if
	}//foreach

	//------------------ fase
	//txt_titulo_fse_0
	//txt_descricao_fse_0
	//txt_risco_fse_0

	if($tipo == "fse"){
		$oListaFase = FaseBD::getLista("fse_id_wrk = ".$wrk_id);
		foreach($oListaFase as $oFase){
			$int_ordem = array_search($oFase->Id,$arr_new_ordem);
			$oFase->Seq = is_numeric($int_ordem)?$int_ordem:1;
			FaseBD::alter($oFase);
		}//foreach
	}elseif($tipo == "qst"){
		$oListaQuestion = QuestionBD::getLista("qst_id_wrk = ".$wrk_id." AND qst_id_fse = ".$fse_id);
		foreach($oListaQuestion as $oQuestion){
			$int_ordem = array_search($oQuestion->Id,$arr_new_ordem);
			$oQuestion->Seq = is_numeric($int_ordem)?$int_ordem:1;
			QuestionBD::alter($oQuestion);
		}//foreach
	}//if


?>