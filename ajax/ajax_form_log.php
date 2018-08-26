<?
	require_once(__DIR__.'/../lib/includes/session.inc.php');

	require_once(__DIR__.'/../lib/classes/class.RN.php');

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

	require_once(__DIR__.'/../lib/classes/class.logBD.php');
	require_once(__DIR__.'/../lib/classes/class.notaBD.php');



	session::start();

	$wrk_id = preg_replace("/[^0-9]/i","", $_REQUEST["wrk"]);
	if($wrk_id == "")$wrk_id = 0;

	$fse_id = preg_replace("/[^0-9]/i","", $_REQUEST["fse"]);
	if($fse_id == "")$fse_id = 0;

	$tsk_id = preg_replace("/[^0-9]/i","", $_REQUEST["tsk"]);
	if($tsk_id == "")$tsk_id = 0;

	$oTask = TaskBD::get($tsk_id);
	$oFase = FaseBD::get($fse_id);

	//$oListaLog = LogBD::getLista("mnu_id = 1");
	$oListaNota = NotaBD::getLista("ntt_id_tsk = ".$tsk_id,"ntt_id DESC");

?>
<div class="row">
	<div class="col-md-10">
		<div class="form-group has-feedback has-warning">
				<label>Comentário</label>
				<input type="text" class="form-control" name="txt_nota_0"  id="txt_nota_0" tsk="<?=$tsk_id?>"  fse="<?=$fse_id?>" onfocus="inputAutoSave('focus',this);" onblur="inputAutoSave('blur',this);" onkeyup="if(TeclaEnter(event))this.blur();" original=""  placeholder="Digite um comentário..." value="" maxlength="500" />
				<div class="form-control-feedback" style="display:none;">
					<i class="icon-edit"></i>
				</div>
			</div>
	</div>
</div>
<div class="row">
	<table class="table">
		<thead>
		<tr>
			<th width="160"><i class="icon-calendar22"></i></th>
			<th><i class="icon-pencil"></i></th>
		</tr>
		</thead>
		<tbody id="tbodyLog">
			<?
		foreach($oListaNota as $oNota){
			?>
			<tr>
				<td><span class="text-muted"><?=RN::NormalDate($oNota->DtRegistro)." - ".$oNota->HrRegistro?><br /><i><?=$oNota->Usuario->Nome?></i></span></td>
				<td><span><?=$oNota->Nota?></span></td>
			</tr>
			<?
		}//foreach
		?>
		</tbody>
	</table>
</div>