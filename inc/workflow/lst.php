<?
	$oListaWorkflow = WorkflowBD::getLista("wrk_id_cln = ".$_SESSION["sss_usr_id_cln"],"wrk_id DESC");
?>
<input type="hidden" name="hdd_url_new" id="hdd_url_new" value="./?page=<?=$_REQUES["page"]?>&edit=ok&=0">

<div class="col-md-8">
<!-- Basic responsive table -->
				<div class="panel panel-flat">
					<? /* ?>
					<div class="panel-heading">
						<h5 class="panel-title">Basic responsive table</h5>
						<div class="heading-elements">
							<ul class="icons-list">
		                		<li><a data-action="collapse"></a></li>
		                		<li><a data-action="reload"></a></li>
		                		<li><a data-action="close"></a></li>
		                	</ul>
	                	</div>
					</div>
					<? */ ?>

					<div class="panel-body">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>Processos</th>
										<?
										if(count($oListaWorkflow) > 0){
											?>
											<th width="70">Fases</th>
											<th width="70">Status</th>
											<th width="100">
												&nbsp;
												<? /* <button class="btn btn-labeled btn-warning" onclick="addRegistro();"><b><i class="icon-plus-circle2"></i></b>&nbsp;Adicionar</button> */ ?>
											</th>
											<?
										}//if
										?>
									</tr>
								</thead>
								<tbody>
									<?
									if(count($oListaWorkflow) > 0){
										foreach($oListaWorkflow as $oWorkflow){

											$oListaFase = FaseBD::getLista("fse_id_wrk = ".$oWorkflow->Id);

											if($oWorkflow->Status == "A"){
												$status_label = "Ativo";
												$status_class = "success";
											}else{
												$status_label = "Inativo";
												$status_class = "default";
											}//if
											?>
											<tr>
												<td><a href="./?page=workflow&id=<?=$oWorkflow->Id?>"><?=$oWorkflow->Titulo?></a></td>
												<td align="center" width="70"><span class="label label-primary"><?=count($oListaFase)?></span></td>
												<td><span class="label label-<?=$status_class?>"><?=$status_label?></span></td>
												<td align="right" width="70">
													<a href="./?mnu=<?=$page_id_mnu?>&page=workflow&id=<?=$oWorkflow->Id?>&act=frm" class="btn btn-labeled btn-primary"><b><i class="icon-pencil"></i></b> Editar</a>
												</td>
											</tr>
											<?
										}//foreach
									}else{
										?>
										<tr>
											<td><span><i class="icon-warning"></i>&nbsp;Você ainda não criou nenhum Processo</span></td>
										</tr>
										<?
									}//if
									?>
								</tbody>
							</table>




						</div>
					</div>


				</div>
				<!-- /basic responsive table -->
</div>
<div class="col-md-4">
	<div class="row">
	<? include(__DIR__."/new.php"); ?>
	</div>
</div>