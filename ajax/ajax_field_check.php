<?
	require_once(__DIR__.'/../lib/includes/session.inc.php');
	require_once(__DIR__.'/../lib/classes/class.usuarioBD.php');
	require_once(__DIR__.'/../lib/classes/class.clienteBD.php');
	require_once(__DIR__.'/../lib/classes/class.workflowBD.php');
	require_once(__DIR__.'/../lib/classes/class.faseBD.php');
	require_once(__DIR__.'/../lib/classes/class.field_faseBD.php');

	session::start();

	$wrk_id = preg_replace("/[^0-9]/i","", $_REQUEST["wrk"]);
	if($wrk_id == "")$wrk_id = 0;

	$fse_id = preg_replace("/[^0-9]/i","", $_REQUEST["fse"]);
	if($fse_id == "")$fse_id = 0;

	$fld_id = preg_replace("/[^0-9]/i","", $_REQUEST["fld"]);
	if($fld_id == "")$fld_id = 0;

	$status = trim($_REQUEST["status"]);
	$required = (trim($_REQUEST["req"])=='true')?"S":"N";

	if($wrk_id == 0)die("sem pipeline");
	if($fse_id == 0)die("sem fase");
	if($fld_id == 0)die("sem campo");

	FieldFaseBD::delByCondition("ffs_id_fld = ".$fld_id." AND ffs_id_fse = ".$fse_id);

	if($status == 'true'){
		$arr_valor = array(
			'ffs_id_fld' 		=> $fld_id,
			'ffs_id_fse' 		=> $fse_id,
			'ffs_id_wrk' 		=> $wrk_id,
			'ffs_seq' 			=> 0,
			'ffs_obrigatorio' 	=> "'".$required."'"
		);

		FieldFaseBD::addCustom($arr_valor);
	}//if
?>