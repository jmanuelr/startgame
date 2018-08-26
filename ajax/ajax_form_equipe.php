<?
	require_once(__DIR__.'/../lib/classes/class.usuarioBD.php');
	require_once(__DIR__.'/../lib/classes/class.clienteBD.php');
	require_once(__DIR__.'/../lib/classes/class.workflowBD.php');
	require_once(__DIR__.'/../lib/classes/class.faseBD.php');
	require_once(__DIR__.'/../lib/classes/class.questionBD.php');
	require_once(__DIR__.'/../lib/classes/class.equipe_questionBD.php');
	require_once(__DIR__.'/../lib/classes/class.usuarioBD.php');
	require_once(__DIR__.'/../lib/classes/class.taskBD.php');

	$wrk_id = 0;//$_REQUEST["wrk"];
	$fse_id = $_REQUEST["fse"];
	$tsk_id = $_REQUEST["tsk"];

	$oTask = TaskBD::get($tsk_id);

	$oListaQuestion = QuestionBD::getLista("qst_id_fse = ".$fse_id, "qst_seq");

	$arr_equipe = array();
	$arr_usuario = array();

	foreach($oListaQuestion as $oQuestion){
		$oListaEquipeQuestion = EquipeQuestionBD::getLista("eqs_id_qst = ".$oQuestion->Id);
		foreach($oListaEquipeQuestion as $oEquipeQuestion){
			if(is_object($oEquipeQuestion->Equipe)){
				if(!array_key_exists($oEquipeQuestion->_Equipe, $arr_equipe)){//!in_array($oEquipeQuestion->_Equipe, $arr_equipe_ids)
					$arr_equipe[$oEquipeQuestion->_Equipe] = $oEquipeQuestion->Equipe;
				}//if
			}//if
			if(is_object($oEquipeQuestion->Usuario)){
				if(!array_key_exists($oEquipeQuestion->_Usuario, $arr_usuario)){//!in_array($oEquipeQuestion->_Equipe, $arr_equipe_ids)
					$arr_usuario[$oEquipeQuestion->_Usuario] = $oEquipeQuestion->Usuario;
				}//if
			}//if
		}//foreach
	}//foreach



?>
<div class="row">
	<div class="col-md-12">
		<h5><?=$oTask->Titulo?></h5>
		<p>Equipes e/ou membros responsáveis pelas atividades nesta etapa</p>

			<div>
				<?
				if(count($arr_equipe)>0){
					?>
					<ul>
						<?
						foreach($arr_equipe as $oEquipe){
							?>
							<li><?=$oEquipe->Nome?></li>
							<?
						}//foreach
						?>
					</ul>
					<?
				}//if
				?>
				<?
				if(count($arr_usuario)>0){
					?>
					<ul>
						<?
						foreach($arr_usuario as $oUsuario){
							?>
							<li><?=$oUsuario->Nome?></li>
							<?
						}//foreach
						?>
					</ul>
					<?
				}//if
				?>
			</div>


	</div>

</div>