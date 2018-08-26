<?
	include(__DIR__."/ini.php");
?>
<!-- Basic responsive table -->
				<div class="panel panel-flat">

					<div class="panel-body">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>Janela</th>
										<th>&nbsp;</th>
										<th>Status</th>
										<th width="100">
											<button class="btn btn-labeled btn-warning" onclick="addRegistro('&fonte=<?=$_REQUEST["mnu"]?>&sis=<?=$_REQUEST["sis"]?>&jnl=0');"><b><i class="icon-plus-circle2"></i></b>&nbsp;Adicionar</button>
										</th>
									</tr>
								</thead>
								<tbody>
									<?
									if(count($oListaObjetos)==0){
									?>
									<tr>
										<td colspan="3">Não foram encontrados registros</td>
									</tr>
									<?
									}//if
									foreach($oListaObjetos as $oJanela){
										if($oJanela->Status == "A"){
											$status_label = "Ativo";
											$status_class = "success";
										}else{
											$status_label = "Inativo";
											$status_class = "default";
										}//if
										?>
										<tr>
											<td>
												<strong><?=$oJanela->Nome?></strong><br />
												<span class="text-muted"><?=$oJanela->Url?></span>
											</td>
											<td>
												<a href="javascript:verElementos(<?=$oJanela->Id?>,'<?=$oJanela->Url?>');" class="btn btn-labeled btn-default"><b><i class="icon-select2"></i></b>Elementos</a>
											</td>
											<td><span class="label label-<?=$status_class?>"><?=$status_label?></span></td>
											<td class="text-center">
												<a href="./?mnu=<?=$page_id_mnu?>&page=team&id=<?=$oJanela->Id?>&act=frm" class="btn btn-labeled btn-primary"><b><i class="icon-pencil"></i></b>Editar</a>
											</td>
										</tr>
										<?
									}//foreach
									?>
								</tbody>
							</table>
						</div>
					</div>


				</div>
				<!-- /basic responsive table -->

				<?
				include(__DIR__."/modal.php");
				?>