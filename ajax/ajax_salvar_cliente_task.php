<?
	date_default_timezone_set('America/Sao_Paulo');

	require_once(__DIR__.'/../lib/includes/session.inc.php');
	require_once(__DIR__.'/../lib/classes/class.usuarioBD.php');
	require_once(__DIR__.'/../lib/classes/class.clienteBD.php');
	require_once(__DIR__.'/../lib/classes/class.contatoBD.php');
	require_once(__DIR__.'/../lib/classes/class.workflowBD.php');
	require_once(__DIR__.'/../lib/classes/class.faseBD.php');
	require_once(__DIR__.'/../lib/classes/class.questionBD.php');
	require_once(__DIR__.'/../lib/classes/class.taskBD.php');

	session::start();

	$wrk_id = 0;//$_REQUEST["wrk"];

	$tsk_id = preg_replace("/[^0-9]/i","", $_REQUEST["tsk"]);
	if($tsk_id=="")$tsk_id=0;

	$cln_id = preg_replace("/[^0-9]/i","", $_REQUEST["cln"]);
	if($cln_id=="")$cln_id=0;

	$oTask = TaskBD::get($tsk_id);

	//$oListaQuestion = QuestionBD::getLista("qst_id_fse = ".$fse_id, "qst_seq");


	if($oTask->_Cliente == 0){

		$oTask->Cliente = $cln_id;

		TaskBD::alter($oTask);
	}//if

	echo $oTask->Cliente->Nome;
?>