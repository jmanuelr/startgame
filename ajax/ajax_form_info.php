<?
	require_once(__DIR__.'/../lib/includes/session.inc.php');

	require_once(__DIR__.'/../lib/classes/class.usuarioBD.php');
	require_once(__DIR__.'/../lib/classes/class.clienteBD.php');
	require_once(__DIR__.'/../lib/classes/class.workflowBD.php');
	require_once(__DIR__.'/../lib/classes/class.faseBD.php');
	require_once(__DIR__.'/../lib/classes/class.fieldBD.php');
	require_once(__DIR__.'/../lib/classes/class.field_faseBD.php');
	require_once(__DIR__.'/../lib/classes/class.field_taskBD.php');
	require_once(__DIR__.'/../lib/classes/class.questionBD.php');
	require_once(__DIR__.'/../lib/classes/class.taskBD.php');
	require_once(__DIR__.'/../lib/classes/class.task_questionBD.php');

	session::start();

	$wrk_id = preg_replace("/[^0-9]/i","", $_REQUEST["wrk"]);
	if($wrk_id == "")$wrk_id = 0;

	$fse_id = preg_replace("/[^0-9]/i","", $_REQUEST["fse"]);
	if($fse_id == "")$fse_id = 0;

	$tsk_id = preg_replace("/[^0-9]/i","", $_REQUEST["tsk"]);
	if($tsk_id == "")$tsk_id = 0;

	$oTask = TaskBD::get($tsk_id);
	$oFase = FaseBD::get($fse_id);

	$wrk_id = $oFase->_Workflow;

	//$oListaFieldFase = FieldFaseBD::getLista("ffs_id_fse = ".$fse_id);
	$oListaFieldFase = FieldFaseBD::getLista("ffs_id_wrk = ".$wrk_id." AND ffs_id_fse = 0");

	$arr_feito = array();

	$tsk_titulo = trim($oTask->Titulo);

	if($tsk_titulo=="" && is_object($oTask->Cliente))$tsk_titulo = $oTask->Cliente->Nome;

?>
<div class="row">
	<div id="divCustomFieldsList_fse_<?=$fse_id?>_tsk_<?=$tsk_id?>" class="col-md-10">
		<h5><?=$tsk_titulo?></h5>
		<p><?=$oTask->Descricao?></p>
		<?
		foreach($oListaFieldFase as $oFieldFase){

			$class_extra = "";

			$ffs_nome = trim($oFieldFase->Field->Nome);

			if($oFieldFase->Obrigatorio=="S"){
				$class_control = " has-warning";
				$ffs_nome.="*";
				$inpQuestionObrigatorio = " inpQuestionObrigatorio";
			}else{
				$class_control = "";
				$inpQuestionObrigatorio = "";
			}//if

			//$is_checked = (in_array($oQuestion->Id,$arr_feito))?"checked=\"checked\"":"";

			$oFieldTask = FieldTaskBD::get($oFieldFase->_Field, $_SESSION["sss_usr_id_cln"], $wrk_id, 0, $tsk_id);//fse = 0

			$tmp_value = is_object($oFieldTask)?$oFieldTask->Resposta:"";

			if($oFieldFase->Field->Tipo=="F"){
				$class_extra = " mask_data";
			}//if

			?>
			<div class="form-group has-feedback <?=$class_control?>">
				<label><?=$ffs_nome?></label>
				<input type="text" class="form-control <?=$class_extra.$inpQuestionObrigatorio?>" name="txt_field_<?=$oFieldFase->_Field?>" fse="<?=$fse_id?>" id="txt_field_<?=$oFieldFase->_Field?>" onfocus="inputAutoSave('focus',this);" onblur="inputAutoSave('blur',this);" onkeyup="if(TeclaEnter(event))this.blur();" original="<?=$tmp_value?>"  placeholder="<?=$ffs_nome?>" value="<?=$tmp_value?>" maxlength="150">
				<div class="form-control-feedback" style="display:none;">
					<i class="icon-edit"></i>
				</div>
			</div>

			<?
		}//foreach
		?>

	</div>

</div>