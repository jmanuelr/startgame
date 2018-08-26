<?
	require_once(__DIR__.'/../lib/includes/session.inc.php');
	require_once(__DIR__.'/../lib/classes/class.usuarioBD.php');
	require_once(__DIR__.'/../lib/classes/class.clienteBD.php');
	require_once(__DIR__.'/../lib/classes/class.workflowBD.php');
	require_once(__DIR__.'/../lib/classes/class.faseBD.php');
	require_once(__DIR__.'/../lib/classes/class.questionBD.php');
	require_once(__DIR__.'/../lib/classes/class.task_questionBD.php');
	require_once(__DIR__.'/../lib/classes/class.taskBD.php');

	session::start();

	$wrk_id = preg_replace("/[^0-9]/i","", $_REQUEST["wrk"]);
	if($wrk_id == "")$wrk_id = 0;

	$fse_id = preg_replace("/[^0-9]/i","", $_REQUEST["fse"]);
	if($fse_id == "")$fse_id = 0;

	$tsk_id = preg_replace("/[^0-9]/i","", $_REQUEST["tsk"]);
	if($tsk_id == "")$tsk_id = 0;

	$qst_id = preg_replace("/[^0-9]/i","", $_REQUEST["qst"]);
	if($qst_id == "")$qst_id = 0;

	$status = trim($_REQUEST["status"]);

	//$oListaTaskQuestion = QuestionBD::getLista("qst_id_fse = ".$fse_id, "qst_seq");

	TaskQuestionBD::delByCondition("tqs_id_tsk = ".$tsk_id." AND tqs_id_qst = ".$qst_id);

	if($status == 'true'){
		$arr_valor = array(
			'tqs_id_tsk' => $tsk_id,
			'tqs_id_qst' => $qst_id,
			'tqs_id_usr' => $_SESSION["sss_usr_id"]
		);

		TaskQuestionBD::addCustom($arr_valor);
	}//if

?>