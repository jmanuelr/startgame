<?
	date_default_timezone_set('America/Sao_Paulo');

	require_once(__DIR__.'/../lib/includes/session.inc.php');
	require_once(__DIR__.'/../lib/classes/class.usuarioBD.php');
	require_once(__DIR__.'/../lib/classes/class.clienteBD.php');
	require_once(__DIR__.'/../lib/classes/class.contatoBD.php');
	require_once(__DIR__.'/../lib/classes/class.workflowBD.php');
	require_once(__DIR__.'/../lib/classes/class.faseBD.php');
	require_once(__DIR__.'/../lib/classes/class.questionBD.php');
	require_once(__DIR__.'/../lib/classes/class.taskBD.php');

	session::start();

	$wrk_id = 0;//$_REQUEST["wrk"];

	$tsk_id = preg_replace("/[^0-9]/i","", $_REQUEST["tsk"]);
	if($tsk_id=="")$tsk_id=0;

	$fse_id = preg_replace("/[^0-9]/i","", $_REQUEST["fse"]);
	if($fse_id=="")$fse_id=0;

	$oTask = TaskBD::get($tsk_id);

	//$oListaQuestion = QuestionBD::getLista("qst_id_fse = ".$fse_id, "qst_seq");

	?>
	<div class="row">
		<div class="col-md-10">
			<div class="form-group has-feedback">
				<label>Título</label>
				<input type="text" class="form-control" name="txt_titulo_tsk_<?=$tsk_id?>" id="txt_titulo_tsk_<?=$tsk_id?>" onfocus="inputAutoSave('focus',this);" onblur="inputAutoSave('blur',this);" onkeyup="if(TeclaEnter(event))this.blur();" original="<?=$oTask->Titulo?>" value="<?=$oTask->Titulo?>" maxlength="150">
				<div class="form-control-feedback" style="display:none;">
					<i class="icon-edit"></i>
				</div>
			</div>
		</div>
	</div>
	<?


	if($oTask->_Cliente == 0){

		$oListaCliente = ClienteBD::getLista("cln_id_cln = ".$_SESSION["sss_usr_id_cln"]." AND cln_status = 'A'","cln_nome");
		?>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label>Cliente</label>
					<select id="slc_id_cln_<?=$tsk_id?>" class="select" data-placeholder="Selecionar..." onchange="salvarClienteTask(<?=$tsk_id?>,this.value);">
						<option value="0">Selecione...</option>
						<?
						foreach($oListaCliente as $oCliente){
							?><option value="<?=$oCliente->Id?>"><?=$oCliente->Nome?></option><?
						}//foreach
						?>
					</select>
				</div>
			</div>
		</div>
		<?
	}else{

		$oListaContato = ContatoBD::getLista("cnt_id_cln = ".$oTask->_Cliente);
		?>
		<div class="row">
			<div class="col-md-12">
				<h5><?=$oTask->Cliente->Nome?></h5>
				<?
				foreach($oListaContato as $oContato){
					echo "<br /><span>".$oContato->Nome."</span>";
					echo "<br /><span class='text-muted'>".$oContato->Email.", ".$oContato->Fone."</span>";
				}//foerach
				?>
			</div>

		</div>
		<?
	}//if
?>