<?
	require_once(__DIR__.'/../lib/includes/session.inc.php');
	require_once(__DIR__.'/../lib/classes/class.usuarioBD.php');
	require_once(__DIR__.'/../lib/classes/class.clienteBD.php');
	require_once(__DIR__.'/../lib/classes/class.faseBD.php');
	require_once(__DIR__.'/../lib/classes/class.workflowBD.php');
	require_once(__DIR__.'/../lib/classes/class.questionBD.php');
	require_once(__DIR__.'/../lib/classes/class.taskBD.php');
	require_once(__DIR__.'/../lib/classes/class.task_questionBD.php');
	//----------------------------------------------------------
	session::start();
	//echo "<pre>";
	//print_r($_REQUEST);
	//echo "</pre>";
	//----------------------------------------------------------
	//$usr_id = $_SESSION["sss_usr_id"];
	//$usr_id = $_SESSION["sss_usr_id_cln"];

	$wrk_tipo = trim($_REQUEST["tipo"]);
	$fse_id = $_REQUEST["fse"];
	$tsk_id = $_REQUEST["tsk"];

	$oWorkflow = new Workflow;

	$oWorkflow->Workflow 	= 0;
	$oWorkflow->Cliente 	= $_SESSION["sss_usr_id_cln"];
	$oWorkflow->Usuario 	= $_SESSION["sss_usr_id"];
	$oWorkflow->Titulo 		= "Processo Novo";
	$oWorkflow->Status 		= "A";

	$wrk_id = WorkflowBD::add($oWorkflow);

	echo $wrk_id;
?>