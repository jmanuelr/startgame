<?
	require_once(__DIR__.'/../lib/classes/class.usuarioBD.php');
	require_once(__DIR__.'/../lib/classes/class.clienteBD.php');
	require_once(__DIR__.'/../lib/classes/class.contatoBD.php');
	require_once(__DIR__.'/../lib/classes/class.workflowBD.php');
	require_once(__DIR__.'/../lib/classes/class.faseBD.php');
	require_once(__DIR__.'/../lib/classes/class.questionBD.php');
	require_once(__DIR__.'/../lib/classes/class.equipe_questionBD.php');
	require_once(__DIR__.'/../lib/classes/class.taskBD.php');

	//'&wrk='+wrk_id+'&fse='+fse_id+'&qst='+qst_id+'&input='+idInput+'&value='+valor;

	$wrk_id = $_REQUEST["wrk"];
	$fse_id = $_REQUEST["fse"];
	$qst_id = $_REQUEST["qst"];
	$input 	= $_REQUEST["input"];
	$slc_id_eqp 	= explode(",",$_REQUEST["value"]);//Array

	$oWorkflow = WorkflowBD::get($wrk_id);
	$oFase = FaseBD::get($fse_id);
	$oQuestion = QuestionBD::get($qst_id);

	//------------------ workflow
	// txt_titulo_wrk_#

	//------------------ fase
	//txt_titulo_fse_0
	//txt_descricao_fse_0
	//txt_risco_fse_0

	//------------------ question
	//txt_titulo_qst_0
	//txt_descricao_qst_0

	//slc_id_eqps

	EquipeQuestionBD::delByCondition("eqs_id_qst = ".$qst_id);

	if(is_array($slc_id_eqp)){
		foreach($slc_id_eqp as $equipe){
			$arr_equipe = explode(":",$equipe);
			$tipo = $arr_equipe[0];
			$identificador = $arr_equipe[1];

			$arr_valor = array(
				"eqs_id_eqp" => ($tipo=="t")?$identificador:0,
				"eqs_id_qst" => $qst_id,
				"eqs_id_usr" => ($tipo=="u")?$identificador:0
			);
			EquipeQuestionBD::addCustom($arr_valor);
		}//foreach
	}//if

	exit;

?>