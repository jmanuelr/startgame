<?
	require_once(__DIR__.'/../lib/includes/session.inc.php');
	require_once(__DIR__.'/../lib/classes/class.usuarioBD.php');
	require_once(__DIR__.'/../lib/classes/class.clienteBD.php');
	require_once(__DIR__.'/../lib/classes/class.questionBD.php');
	//----------------------------------------------------------
	session::start();
	//echo "<pre>";
	//print_r($_REQUEST);
	//echo "</pre>";
	//----------------------------------------------------------
	$fse_id 	= preg_replace("/[^0-9]/i", "", $_REQUEST["fse"]);
	if($fse_id==""){
		?>
		<script>
			alert('Error #1: code incorrect.');
		</script>
		<?
		exit;
	}//if

	$wrk_id 	= preg_replace("/[^0-9]/i", "", $_REQUEST["wrk"]);
	if($wrk_id==""){
		?>
		<script>
			alert('Error #2: code incorrect.');
		</script>
		<?
		exit;
	}//if

	//----------------------------------------------------------
	$qst_id 	= preg_replace("/[^0-9]/i", "", $_REQUEST["hdd_id_task_".$fse_id]);
	if($qst_id=="")$qst_id = 0;
	//----------------------------------------------------------
	$txt_titulo 	= trim($_REQUEST["txt_task_question_".$fse_id]);
	$txt_descricao 	= trim($_REQUEST["txt_task_question_desc_".$fse_id]);
	$txt_tipo 		= trim($_REQUEST["txt_task_question_type_".$fse_id]);
	$txt_tags 		= trim($_REQUEST["txt_task_question_tags_".$fse_id]);
	$txt_required 	= trim($_REQUEST["txt_task_question_required_".$fse_id]);
	//----------------------------------------------------------
	
	if($qst_id > 0){
		$oQuestion = QuestionBD::get($qst_id);
		$bool_qst_nova = false;
	}else{
		$bool_qst_nova 	= true;

		$oQuestion = new Question;
		$oQuestion->Workflow 	= $wrk_id;
		$oQuestion->Fase 		= $fse_id;
		$oQuestion->Cliente 	= 0;
		$oQuestion->Usuario 	= 0;
		//----------------------
        $condicao_seq = 'qst_id_fse = '.$fse_id;
        $arr_seq = QuestionBD::getCustomLista($condicao_seq, '', 'MAX(qst_seq) as ordem', '', '', '', '', false);
        $contador_seq = is_numeric($arr_seq[0]["ordem"])?(intval($arr_seq[0]["ordem"]) + 1):1;
        //----------------------
		$oQuestion->Seq 	= $contador_seq;

	}//if

	$oQuestion->Titulo 		= $txt_titulo;
	$oQuestion->Descricao 	= $txt_descricao;
	$oQuestion->Tipo 		= $txt_tipo;
	$oQuestion->Option 		= $txt_tags;
	$oQuestion->Required 	= ($txt_required=="S")?"S":"N";
	$oQuestion->Status		= "A";



	if($bool_qst_nova){
		$qst_id = QuestionBD::add($oQuestion);
		$mensagem = "Question added!";

		//exit;
		?>
		<script>
			top.location.href = '../?page=workflow&id=<?=$wrk_id?>&edit=ok';
		</script>
		<?
	}else{
		QuestionBD::alter($oQuestion);
		$mensagem = "Question Updated!";
			?>
		<script>
			//alert('<?=$mensagem?>');
			top.location.href = '../?page=workflow&id=<?=$wrk_id?>&edit=ok';
		</script>
		<?
	}//if
	//-----------------------------------------------------------------------------------[ END ]
?>