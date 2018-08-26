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

	$cln_id = preg_replace("/[^0-9]/i","", $_SESSION["sss_usr_id_cln"]);
	if($cln_id=="")$cln_id=0;

	$pipe_token = trim($_REQUEST["token"]);

	$oCliente = ClienteBD::get($cln_id);
	$oCliente->PipedriveToken = $pipe_token;

	ClienteBD::alter($oCliente);
?>