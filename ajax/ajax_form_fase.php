<?
	require_once(__DIR__.'/../lib/includes/session.inc.php');

	require_once(__DIR__.'/../lib/classes/class.usuarioBD.php');
	require_once(__DIR__.'/../lib/classes/class.clienteBD.php');
	require_once(__DIR__.'/../lib/classes/class.workflowBD.php');
	require_once(__DIR__.'/../lib/classes/class.faseBD.php');
	require_once(__DIR__.'/../lib/classes/class.questionBD.php');
	require_once(__DIR__.'/../lib/classes/class.taskBD.php');
	require_once(__DIR__.'/../lib/classes/class.task_questionBD.php');
	require_once(__DIR__.'/../lib/classes/class.equipe_questionBD.php');
	require_once(__DIR__.'/../lib/classes/class.equipe_usuarioBD.php');

	session::start();

	$wrk_id = 0;//$_REQUEST["wrk"];

	$fse_id = preg_replace("/[^0-9]/i","", $_REQUEST["fse"]);
	if($fse_id == "")$fse_id = 0;

	$tsk_id = preg_replace("/[^0-9]/i","", $_REQUEST["tsk"]);
	if($tsk_id == "")$tsk_id = 0;

	$oTask = TaskBD::get($tsk_id);

	$oListaQuestion = QuestionBD::getLista("qst_id_fse = ".$fse_id, "qst_seq");

	$oListaTaskQuestion = TaskQuestionBD::getLista("tqs_id_tsk = ".$tsk_id);//." AND tsk_id_qst = ".$qst_id

	$oListaEquipeUsuario = EquipeUsuarioBD::getLista("esr_id_usr = ".$_SESSION["sss_usr_id"]);
	$arr_my_teams = array();
	foreach($oListaEquipeUsuario as $oEquipeUsuario){
		if($oEquipeUsuario->_Equipe > 0){
			$arr_my_teams[] = $oEquipeUsuario->_Equipe;
		}//if
	}//foreach

	$arr_feito = array();

	foreach($oListaTaskQuestion as $oTaskQuestion){
		$arr_feito[] = $oTaskQuestion->_Question;
	}//foreach

	$tsk_titulo = trim($oTask->Titulo);

	if($tsk_titulo=="" && is_object($oTask->Cliente))$tsk_titulo = $oTask->Cliente->Nome;

?>
<div class="row">
	<div id="divQuestionList_fse_<?=$fse_id?>_tsk_<?=$tsk_id?>" class="col-md-12">
		<h5><?=$tsk_titulo?></h5>
		<p><?=$oTask->Descricao?></p>
		<?
		foreach($oListaQuestion as $oQuestion){

			$oListaEquipeQuestion = EquipeQuestionBD::getLista("eqs_id_qst = ".$oQuestion->Id);

			if($oQuestion->Required=="S"){
				$class_control = "danger";
				$chkQuestionObrigatorio = "chkQuestionObrigatorio";
			}else{
				$class_control = "success";
				$chkQuestionObrigatorio = "";
			}//if

			$arr_equipes = array();
			$arr_responsaveis = array();
			$bool_tarefa_minha = false;
			$bool_label_responsaveis = "";

			if(count($oListaEquipeQuestion)>0){

					foreach($oListaEquipeQuestion as $oEquipeQuestion){
						//echo " ". $oEquipeQuestion->Equipe->Nome . " / " . $oEquipeQuestion->Usuario->Nome."";
						if( in_array($oEquipeQuestion->_Equipe,$arr_my_teams) || ($oEquipeQuestion->_Usuario == $_SESSION["sss_usr_id"])  ){
							$bool_tarefa_minha = true;
						}//if

						if($oEquipeQuestion->_Equipe > 0){
							$arr_equipes[$oEquipeQuestion->_Equipe] = $oEquipeQuestion->Equipe->Nome;
						}//if

						if($oEquipeQuestion->_Usuario > 0){
							$arr_responsaveis[$oEquipeQuestion->_Usuario] = $oEquipeQuestion->Usuario->Nome;
						}//if
						//--
					}//foreach

				$bool_label_responsaveis .= "<br /><span class='text-responsaveis'>";
				foreach($arr_equipes as $eq => $equipe){
					$bool_label_responsaveis .= "<i class='icon-users4'></i>&nbsp;".$equipe." ";
				}//foreach
				foreach($arr_responsaveis as $us => $usuario){
					$bool_label_responsaveis .= "<i class='icon-user'></i>&nbsp;".$usuario." ";
				}//foreach
				$bool_label_responsaveis .= "</span>";
			}//if

			$is_checked = (in_array($oQuestion->Id,$arr_feito))?"checked=\"checked\"":"";

			?>
			<div class="checkbox">
				<label style="<?=(($bool_tarefa_minha)?"font-weight: bold;":"")?>">
					<input type="checkbox" class="control-<?=$class_control?> chkQuestion <?=$chkQuestionObrigatorio?>" <?=$is_checked?>  name="txt_tsk_<?=$tsk_id?>_qst_<?=$oQuestion->Id?>" onclick="setTaskQuestion(<?=$oQuestion->Id?>,<?=$tsk_id?>,this.checked);" obrigatorio="<?=$oQuestion->Required?>" />
					<?=$oQuestion->Titulo?>
				</label><?=$bool_label_responsaveis?>

			</div>
	        <?
		}//foreach
		?>

	</div>

</div>