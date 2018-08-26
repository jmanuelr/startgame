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
										<th>User</th>
										<th>e-mail</th>
										<th>Status</th>
										<th width="100">
											<button class="btn btn-labeled btn-warning" onclick="addRegistro();"><b><i class="icon-plus-circle2"></i></b>&nbsp;Adicionar</button>
										</th>
									</tr>
								</thead>
								<tbody>
									<?
									foreach($oListaObjetos as $oUsuario){
										if($oUsuario->Status == "A"){
											$status_label = "Ativo";
											$status_class = "success";
										}else{
											$status_label = "Inativo";
											$status_class = "default";
										}//if
										?>
										<tr>
											<td><?=$oUsuario->Nome?></td>
											<td><a href="#"><?=$oUsuario->Email?></a></td>
											<td><span class="label label-<?=$status_class?>"><?=$status_label?></span></td>
											<td class="text-center">
												<a href="./?mnu=<?=$page_id_mnu?>&page=user&id=<?=$oUsuario->Id?>&act=frm" class="btn btn-labeled btn-primary"><b><i class="icon-pencil"></i></b>Editar</a>
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