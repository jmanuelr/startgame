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

	$fse_id = preg_replace("/[^0-9]/i","", $_REQUEST["fse"]);
	if($fse_id=="")$fse_id=0;

	$replica = preg_replace("/[^0-9]/i","", $_REQUEST["destino"]);
	if($replica=="")$replica=0;

	if($replica == $fse_id)die("nada a fazer");

	$oFase = FaseBD::get($fse_id);

	$oFase->Replica = $replica;

	FaseBD::alter($oFase);

	echo $oFase->Replica;
?>