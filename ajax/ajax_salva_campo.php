<?
	require_once(__DIR__.'/../lib/includes/session.inc.php');
	require_once(__DIR__.'/../lib/classes/class.RN.php');

	require_once(__DIR__.'/../lib/classes/class.usuarioBD.php');
	require_once(__DIR__.'/../lib/classes/class.clienteBD.php');
	require_once(__DIR__.'/../lib/classes/class.contatoBD.php');
	require_once(__DIR__.'/../lib/classes/class.workflowBD.php');
	require_once(__DIR__.'/../lib/classes/class.faseBD.php');
	require_once(__DIR__.'/../lib/classes/class.fieldBD.php');
	require_once(__DIR__.'/../lib/classes/class.field_taskBD.php');
	require_once(__DIR__.'/../lib/classes/class.questionBD.php');
	require_once(__DIR__.'/../lib/classes/class.taskBD.php');

	require_once(__DIR__.'/../lib/classes/class.template_faseBD.php');

	require_once(__DIR__.'/../lib/classes/class.notaBD.php');

	session::start();

	//'&wrk='+wrk_id+'&fse='+fse_id+'&qst='+qst_id+'&input='+idInput+'&value='+valor;

	$wrk_id = preg_replace("/[^0-9]/i","", $_REQUEST["wrk"]);
	if($wrk_id=="")$wrk_id=0;

	$fse_id = preg_replace("/[^0-9]/i","", $_REQUEST["fse"]);
	if($fse_id=="")$fse_id=0;

	$qst_id = preg_replace("/[^0-9]/i","", $_REQUEST["qst"]);
	if($qst_id=="")$qst_id=0;

	$tsk_id = preg_replace("/[^0-9]/i","", $_REQUEST["tsk"]);
	if($tsk_id=="")$tsk_id=0;

	//--------------------------
	$input 	= $_REQUEST["input"];
	$value 	= $_REQUEST["value"];

	$oWorkflow = WorkflowBD::get($wrk_id);

	//------------------ workflow
	// txt_titulo_wrk_#

	if(strpos($input,"_wrk_")!==false){
		$oWorkflow->Titulo = $value;
		WorkflowBD::alter($oWorkflow);
		echo "[ok:".$wrk_id."]";
		exit;
	}//if

	//------------------ TASK
	// txt_titulo_wrk_#

	if(strpos($input,"_tsk_")!==false){
		$oTask = TaskBD::get($tsk_id);
		$oTask->Titulo = $value;
		TaskBD::alter($oTask);
		echo "[ok:".$tsk_id."]";
		exit;
	}//if

	//------------------ fase
	//txt_titulo_fse_0
	//txt_descricao_fse_0
	//txt_risco_fse_0

	if(strpos($input,"_fse_")!==false){

		if($fse_id == 0){
			$oFase = new Fase;
			$bool_fase_nova = true;
			$oFase->Tempo = 1;
		}else{
			$oFase = FaseBD::get($fse_id);
			$bool_fase_nova = false;
		}//if

		if(strpos($input,"_titulo_")!==false){
			$oFase->Titulo = $value;
		}elseif(strpos($input,"_descricao_")!==false){
			$oFase->Descricao = $value;
		}elseif(strpos($input,"_risco_")!==false){
			$oFase->Risco = $value;
		}elseif(strpos($input,"_tempo_")!==false){
			$oFase->Tempo = $value;
		}//if

		if($bool_fase_nova){
			$oFase->Workflow = $wrk_id;
			$oFase->Status = 'A';
			//----------------------
			$condicao_seq = 'fse_id_wrk = '.$wrk_id;
			$arr_seq = FaseBD::getCustomLista($condicao_seq, '', 'MAX(fse_seq) as ordem', '', '', '', '', false);
			$contador_seq = is_numeric($arr_seq[0]["ordem"])?(intval($arr_seq[0]["ordem"]) + 1):1;
			//----------------------
			$oFase->Seq = $contador_seq;
			$fse_id = FaseBD::add($oFase);
		}else{
			FaseBD::alter($oFase);
		}//if

		echo "[ok:".$fse_id."]";

		exit;
	}//if

	//------------------ question
	//txt_titulo_qst_0
	//txt_descricao_qst_0

	if(strpos($input,"_qst_")!==false){

		if($qst_id == 0){
			$oQuestion = new Question;
			$bool_question_nova = true;
		}else{
			$oQuestion = QuestionBD::get($qst_id);
			$bool_question_nova = false;
		}//if

		if(strpos($input,"_titulo_")!==false){
			$oQuestion->Titulo = $value;
		}elseif(strpos($input,"_descricao_")!==false){
			$oQuestion->Descricao = $value;
		}elseif(strpos($input,"_required_")!==false){
			$oQuestion->Required = $value;
		}//if

		if($bool_question_nova){
			$oQuestion->Workflow 	= $wrk_id;
			$oQuestion->Fase 		= $fse_id;
			$oQuestion->Status 		= 'A';
			//----------------------
			$condicao_seq = 'qst_id_wrk = '.$wrk_id.' AND qst_id_fse = '.$fse_id;
			$arr_seq = QuestionBD::getCustomLista($condicao_seq, '', 'MAX(qst_seq) as ordem', '', '', '', '', false);
			$contador_seq = is_numeric($arr_seq[0]["ordem"])?(intval($arr_seq[0]["ordem"]) + 1):1;
			//----------------------
			$oQuestion->Seq = $contador_seq;
			$qst_id = QuestionBD::add($oQuestion);
		}else{
			QuestionBD::alter($oQuestion);
		}//if

		echo "[ok:".$qst_id."]";

		exit;
	}//if



		if(strpos($input,'_email_dias_')!==false){

			$tmp_id = preg_replace("/[^0-9]/","",$input);

			$oListaTemplateFase = TemplateFaseBD::getLista("tfs_id_tmp = ".$tmp_id." AND tfs_id_fse = ".$fse_id." AND tfs_id_wrk = ".$wrk_id,"",0,1);

			if(count($oListaTemplateFase)>0){
				$oTemplateFase = $oListaTemplateFase[0];
				$oTemplateFase->SendTime = intval($value);
				TemplateFaseBD::alter($oTemplateFase);
			}//if

			/*
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
			*/
		}//if


		//------------------ TASK
	// txt_titulo_wrk_#

	if(strpos($input,"_field_")!==false){

		$fld_id = preg_replace("/[^0-9]/","",$input);

		$condicao = "fts_id_fld = ".$fld_id;
		$condicao.= " AND fts_id_cln = ".$_SESSION["sss_usr_id_cln"];
		$condicao.= " AND fts_id_wrk = ".$wrk_id;
		$condicao.= " AND fts_id_fse = 0";//.$fse_id;
		$condicao.= " AND fts_id_tsk = ".$tsk_id;

		FieldTaskBD::delByCondition($condicao);

		$oField = FieldBD::get($fld_id);
		if($oField->Tipo == "F"){

		}else{
			$value_numerico = floatval(str_replace(',', '.', str_replace('.', '', $value)));
		}//if



		$arr_valor = array(
			'fts_id_fld' 	=> $fld_id,
			'fts_id_cln' 	=> $_SESSION["sss_usr_id_cln"],
			'fts_id_wrk' 	=> $wrk_id,
			'fts_id_fse' 	=> 0,//$fse_id,
			'fts_id_tsk' 	=> $tsk_id,
			'fts_resposta' 	=> "'".$value."'",
			'fts_numerico' 	=> $value_numerico,
			'fts_id_usr' 	=> $_SESSION["sss_usr_id"]
		);

		FieldTaskBD::addCustom($arr_valor);

		echo "[ok:".$fld_id."]";

		exit;
	}//if

	//------------------ nota (log)
	// txt_nota

	if(strpos($input,"_nota_")!==false){
		$oNota = new Nota;
		$oNota->Nota = $value;
		$oNota->DtRegistro = date("Ymd");
		$oNota->HrRegistro = date("H:i");
		$oNota->Usuario = $_SESSION["sss_usr_id"];
		$oNota->Task = $tsk_id;
		$oNota->Fase = $fse_id;
		$ntt_id = NotaBD::add($oNota);
		echo "[ok:".$ntt_id."]";
		exit;
	}//if

?>