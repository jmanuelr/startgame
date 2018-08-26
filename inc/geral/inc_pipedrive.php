<?
	$cln_id = preg_replace("/[^0-9]/i","", $_SESSION["sss_usr_id_cln"]);
	if($cln_id=="")$cln_id=0;

	$oCliente = ClienteBD::get($cln_id);
	$pipe_token = $oCliente->PipedriveToken;

	$oListaPipedrive = PipedriveBD::getLista("ppd_id_cln = ".$cln_id,"ppd_name");
?>
<div class="row">
	<div class="col-md-6">
		<form action="#" method="post">

			<div class="panel panel-flat">

				<div class="panel-body">

				<p class="text-muted">
					Informe seu Login e Senha, ou o TOKEN da sua empresa no Pipedrive
				</p>
				
			        <div class="form-group col-md-6">
			            <label>E-mail do Pipedrive:</label>
			            <input type="text" name="txt_pipe_email" id="txt_pipe_email" class="form-control noLimit" placeholder="Email do Pipedrive" value="" />
			        </div>

			        <div class="form-group col-md-6">
			            <label>Senha do Pipedrive:</label>
			            <input type="password" name="txt_pipe_password" id="txt_pipe_password" class="form-control noLimit" placeholder="Senha do Pipedrive" value="" />
			        </div>

			        <br clear="all" />

			        <div class="form-group">
			            <label>Token:</label>
			            <input type="text" name="txt_pipe_token" id="txt_pipe_token" class="form-control noLimit" placeholder="Token Pipedrive" value="<?=$pipe_token?>" />
			        </div>

			        <a class="btn btn-primary" name="btn_search" id="btn_search" onclick="getPipelines();return false;">
			            <i class="icon-search4"></i> Procurar Pipelines!
			        </a>

		    </div>
		</div>

	    </form>
	</div>
</div>
<div class="row">
	<div id="div_retorno" class="col-md-12">
		<div class="panel panel-flat">
			<div class="panel-body">
				<?
				$oListaWorkflow = WorkflowBD::getLista("wrk_id_cln = ".$_SESSION["sss_usr_id_cln"]." AND wrk_status = 'A'","wrk_id DESC");
				?>
				<table class="table">
					<tr>
						<th width="250">Fluxo</th>
						<th width="250">Pipeline</th>
						<th>&nbsp;</th>
					</tr>
					<?
					foreach($oListaWorkflow as $oWorkflow){
						$wrk_id_ppd = $oWorkflow->_Pipedrive;
						?>
						<tr>
							<td><?=$oWorkflow->Titulo?></td>
							<td>
								<select name="slc_id_ppl_<?=$oWorkflow->Id?>" id="slc_id_ppl_<?=$oWorkflow->Id?>" ppd="<?=$wrk_id_ppd?>" class="form-control slcPipe" onchange="savePipeVinculo(<?=$oWorkflow->Id?>,this.value);">
									<?
									if(count($oListaPipedrive)==0){
										?>
										<option disabled="disabled">Aguardando Pipelines...</option>
										<?
									}else{
										?>
										<option value=""<?=(($wrk_id_ppd==0)||($wrk_id_ppd==""))?>>NENHUM</option>
										<?
									}//if

									foreach($oListaPipedrive as $oPipedrive){
										?>
										<option value="<?=$oPipedrive->Pipeline?>"<?=(($oPipedrive->Pipeline==$wrk_id_ppd)?" selected":"")?>><?=$oPipedrive->Name?></option>
										<?
									}//foreach
									?>
								</select>
							</td>
							<td>
								<button id="btn_import_<?=$oWorkflow->Id?>" type="button" data-loading-text="<i class='icon-spinner4 spinner position-left'></i> Processando..." class="btn btn-danger btn-loading btn-labeled"  onclick="puxaDeals(<?=$oWorkflow->Id?>);return false;"><b><i class="icon-folder-download"></i></b> Importar</button>
								<? /* ?>
								<a class="btn btn-labeled btn-danger" data-spinner-color="#333" data-style="fade" name="btn_import_<?=$oWorkflow->Id?>" id="btn_import_<?=$oWorkflow->Id?>" onclick="puxaDeals(<?=$oWorkflow->Id?>);return false;">
									<b><i class="icon-folder-download"></i></b> Importar
								</a>
								<? */ ?>
							</td>
						</tr>
						<?
					}//foreach
					?>
				</table>
			</div>
		</div>
	</div>

</div>

