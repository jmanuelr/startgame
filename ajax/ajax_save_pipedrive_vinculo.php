<?
	date_default_timezone_set('America/Sao_Paulo');

	require_once(__DIR__.'/../lib/includes/session.inc.php');
	require_once(__DIR__.'/../lib/classes/class.usuarioBD.php');
	require_once(__DIR__.'/../lib/classes/class.clienteBD.php');
	require_once(__DIR__.'/../lib/classes/class.contatoBD.php');
	require_once(__DIR__.'/../lib/classes/class.workflowBD.php');
	require_once(__DIR__.'/../lib/classes/class.pipedriveBD.php');
	require_once(__DIR__.'/../lib/classes/class.faseBD.php');
	require_once(__DIR__.'/../lib/classes/class.questionBD.php');
	require_once(__DIR__.'/../lib/classes/class.taskBD.php');

	session::start();

	$cln_id = preg_replace("/[^0-9]/i","", $_SESSION["sss_usr_id_cln"]);
	if($cln_id=="")$cln_id=0;

	$wrk_id = trim($_REQUEST["wrk"]);
	$ppl_id = trim($_REQUEST["ppl"]);

	$ppl_id = preg_replace("/[^0-9]/i","", $ppl_id);
	if($ppl_id=="")$ppl_id=0;

	$oWorkflow = WorkflowBD::get($wrk_id);
	if($oWorkflow->_Cliente != $cln_id){
		die("Erro: sem permissao");
	}//if

	//procurar ppd_id, pois so tenho ppl_id

	$oWorkflow->Pipedrive = $ppl_id;

	WorkflowBD::alter($oWorkflow);
?>