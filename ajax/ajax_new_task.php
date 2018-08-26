<?
	date_default_timezone_set('America/Sao_Paulo');

	require_once(__DIR__.'/../lib/includes/session.inc.php');
	require_once(__DIR__.'/../lib/classes/class.taskBD.php');
	require_once(__DIR__.'/../lib/classes/class.task_faseBD.php');
	require_once(__DIR__.'/../lib/classes/class.usuarioBD.php');

	session::start();

	$dt_now = date("Ymd");

	$usr_id = preg_replace("/[^0-9]/i","", $_SESSION["sss_usr_id"]);
	if($usr_id=="")$usr_id=0;

	$wrk_id = preg_replace("/[^0-9]/i","", $_REQUEST["wrk"]);
	if($wrk_id=="")$wrk_id=0;

	$fse_id = preg_replace("/[^0-9]/i","", $_REQUEST["fse"]);
	if($fse_id=="")$fse_id=0;

	$oUsuario = UsuarioBD::get($usr_id);

	if(!is_object($oUsuario)){
		die("Usuário nao encontrado");
	}//if


	//----------------------
    $condicao_seq = 'tsk_id_wrk = '.$wrk_id;
    $arr_seq = TaskBD::getCustomLista($condicao_seq, '', 'MAX(tsk_seq) as ordem', '', '', '', '', false);
    $contador_seq = is_numeric($arr_seq[0]["ordem"])?(intval($arr_seq[0]["ordem"]) + 1):1;
    //----------------------

	$oTask = new Task;

	$oTask->Task 		= 0;

	$oTask->DtRegistro 	= date("Ymd");

	$oTask->Fase 		= $fse_id;
	$oTask->Workflow 	= $wrk_id;
	$oTask->Cliente 	= 0;
	$oTask->Usuario 	= $_SESSION["sss_usr_id"];
	$oTask->Seq 		= $contador_seq;
	$oTask->Titulo 		= "";
	$oTask->Descricao 	= "";
	$oTask->Tipo 		= "";
	$oTask->Option 		= "";
	$oTask->Required 	= "N";
	$oTask->Status 		= "A";

	$tsk_id = TaskBD::add($oTask);

	$arr_retorno = array(
		"tsk_id" => $tsk_id,
		"tsk_pai" => "0",
		"tsk_status" => "A",
		"tsk_class_alerta" => 'success',
		"tsk_titulo" => '-',
		"tsk_cln_nome" => 'Sem título...',
		"fse_id" => $fse_id,
		"condicao" => 0,
		"percentual" => 0
	);

	//------------------------------------------->>
	    $condicao_seq = "tfs_id_tsk = ".$tsk_id." AND tfs_id_fse = ".$fse_id;
	    $arr_seq = TaskFaseBD::getCustomLista($condicao_seq, '', 'MAX(tfs_seq) as ordem', '', '', '', '', false);
	    $contador_seq = is_numeric($arr_seq[0]["ordem"])?(intval($arr_seq[0]["ordem"]) + 1):1;
	    //----------------------

		$arr_valor = array(
			'tfs_id_tsk'			=> $tsk_id,
			'tfs_id_fse'			=> $fse_id,
			'tfs_seq'				=> $contador_seq,
			'tfs_dt_ini'			=> "'".$dt_now."'",
			'tfs_dt_fim'			=> "''",
			'tfs_dt_dif'			=> 0,
			'tfs_hr_ini'			=> "'".date("H:i")."'",
			'tfs_hr_fim'			=> "''",
			'tfs_id_usr_in'			=> $_SESSION["sss_usr_id"],
			'tfs_id_usr_out'		=> 0
		);

		TaskFaseBD::addCustom($arr_valor);
	//-------------------------------------------<<

	echo json_encode($arr_retorno);

?>