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
										<th>Sistema</th>
										<th>&nbsp;</th>
										<th>Status</th>
										<th width="100">
											<button class="btn btn-labeled btn-warning" onclick="addRegistro();"><b><i class="icon-plus-circle2"></i></b>&nbsp;Adicionar</button>
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
									foreach($oListaObjetos as $oSistema){
										if($oSistema->Status == "A"){
											$status_label = "Ativo";
											$status_class = "success";
										}else{
											$status_label = "Inativo";
											$status_class = "default";
										}//if
										?>
										<tr>
											<td><?=$oSistema->Nome?></td>
											<td><a href="./?mnu=11&page=telas&fonte=<?=$page_id_mnu?>&act=lst&sis=<?=$oSistema->Id?>" class="btn btn-labeled btn-default"><b><i class="icon-windows2"></i></b>Telas</a></td>
											<td><span class="label label-<?=$status_class?>"><?=$status_label?></span></td>
											<td class="text-center">
												<a href="./?mnu=<?=$page_id_mnu?>&page=team&id=<?=$oSistema->Id?>&act=frm" class="btn btn-labeled btn-primary"><b><i class="icon-pencil"></i></b>Editar</a>
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