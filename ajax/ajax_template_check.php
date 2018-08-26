<?
	require_once(__DIR__.'/../lib/includes/session.inc.php');
	require_once(__DIR__.'/../lib/classes/class.usuarioBD.php');
	require_once(__DIR__.'/../lib/classes/class.clienteBD.php');
	require_once(__DIR__.'/../lib/classes/class.workflowBD.php');
	require_once(__DIR__.'/../lib/classes/class.faseBD.php');
	require_once(__DIR__.'/../lib/classes/class.template_faseBD.php');

	session::start();

	$wrk_id = preg_replace("/[^0-9]/i","", $_REQUEST["wrk"]);
	if($wrk_id == "")$wrk_id = 0;

	$fse_id = preg_replace("/[^0-9]/i","", $_REQUEST["fse"]);
	if($fse_id == "")$fse_id = 0;

	$tmp_id = preg_replace("/[^0-9]/i","", $_REQUEST["tmp"]);
	if($tmp_id == "")$tmp_id = 0;

	$status     = trim($_REQUEST["status"]);
	$flag_in    = (trim($_REQUEST["in"])=='true')?"S":"N";
	$flag_out   = (trim($_REQUEST["out"])=='true')?"S":"N";
	$int_tempo 	= intval($_REQUEST["tempo"]);
	$flag_team  = (trim($_REQUEST["team"])=='true')?"S":"N";
	$flag_resp  = (trim($_REQUEST["resp"])=='true')?"S":"N";
	$flag_cln   = (trim($_REQUEST["cln"])=='true')?"S":"N";
	$txt_emails = trim($_REQUEST["emails"]);

	if($wrk_id == 0)die("sem pipeline");
	if($fse_id == 0)die("sem fase");
	if($tmp_id == 0)die("sem campo");

	TemplateFaseBD::delByCondition("tfs_id_tmp = ".$tmp_id." AND tfs_id_fse = ".$fse_id);

	if($status == 'true'){
		$arr_valor = array(

			'tfs_id_tmp' 	=> $tmp_id,
			'tfs_id_fse' 	=> $fse_id,
			'tfs_id_wrk'	=> $wrk_id,
			'tfs_seq' 		=> 0,
			'tfs_send_in'	=> "'".$flag_in."'",
			'tfs_send_out'	=> "'".$flag_out."'",
			'tfs_send_time'	=> $int_tempo,
			'tfs_send_team'	=> "'".$flag_team."'",
			'tfs_send_resp'	=> "'".$flag_resp."'",
			'tfs_send_cln'	=> "'".$flag_cln."'",
			'tfs_send_mail'	=> "'".$txt_emails."'"
		);

		TemplateFaseBD::addCustom($arr_valor);
	}//if
?>