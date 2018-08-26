<?
	date_default_timezone_set('America/Sao_Paulo');

	require_once(__DIR__.'/../lib/includes/session.inc.php');
	require_once(__DIR__.'/../lib/classes/class.RN.php');

	require_once(__DIR__.'/../lib/classes/class.usuarioBD.php');
	require_once(__DIR__.'/../lib/classes/class.clienteBD.php');
	require_once(__DIR__.'/../lib/classes/class.contatoBD.php');
	require_once(__DIR__.'/../lib/classes/class.workflowBD.php');
	require_once(__DIR__.'/../lib/classes/class.faseBD.php');
	require_once(__DIR__.'/../lib/classes/class.questionBD.php');
	require_once(__DIR__.'/../lib/classes/class.taskBD.php');

	session::start();

	//'&tipo='+tipo+'&itm='+idItem;

	$itm_id = preg_replace("/[^0-9]/i","", $_REQUEST["itm"]);
	if($itm_id==""){
		die("error: sem identificador");
	}//if

	$onoff = intval($_REQUEST["onoff"]);

	$tipo 	= $_REQUEST["tipo"];

	switch($tipo){
		case "wrk":
			$oWorkflow = WorkflowBD::get($itm_id);
			$oWorkflow->Status = ($onoff==1)?'A':'I';
			WorkflowBD::alter($oWorkflow);
		break;
		case "fse":
			$oFase = FaseBD::get($itm_id);
			$oFase->Status = ($onoff==1)?'A':'I';
			FaseBD::alter($oFase);
		break;
		case "tsk":
			$oTask = TaskBD::get($itm_id);
			$oTask->Status = ($onoff==1)?'A':'I';
			TaskBD::alter($oTask);
		break;
		case "qst":
			$oQuestion = QuestionBD::get($itm_id);
			$oQuestion->Status = ($onoff==1)?'A':'I';
			QuestionBD::alter($oQuestion);
		break;
	}//sw



	echo "[ok:".$onoff."]";


?>