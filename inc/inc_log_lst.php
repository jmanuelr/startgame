<?
	require_once(__DIR__."/../lib/classes/class.logBD.php");

	$oListaLog = LogBD::getLista();
?>
<!-- Daily financials -->
								<div class="panel panel-flat">
									<div class="panel-heading">
										<h6 class="panel-title">Últimas Atividades</h6>
										<div class="heading-elements">
											<span class="badge bg-danger-400 heading-text">+86</span>
										</div>
									</div>

									<div class="panel-body">
										<div class="content-group-xs" id="bullets"></div>

										<ul class="media-list">
											<?
											foreach($oListaLog as $oLog){
												switch($oLog->Acao){
													case "signup":
														$log_icon = "user-plus";
														$log_label = "Usuário cadastrado";
														$log_link = "";
														$log_color = "green";
													break;
													case "edit_profile":
														$log_icon = "pencil4";
														$log_label = "Perfil editado";
														$log_link = "";
														$log_color = "pink";
													break;
													default:
														$log_icon = "checkmark3";
														$log_label = $oLog->Obs;
														$log_link = "";
														$log_color = "";
													break;
												}//sw
												$log_data = substr(RN::NormalDate($oLog->DtRegistro),0,5);
												?>
												<li class="media">
													<div class="media-left">
														<a href="#" class="btn border-<?=$log_color?> text-<?=$log_color?> btn-flat btn-rounded btn-icon btn-xs"><i class="icon-<?=$log_icon?>"></i></a>
													</div>

													<div class="media-body">
														<?=$log_label?>
														<div class="media-annotation"><?=$log_data?></div>
													</div>

													<div class="media-right media-middle">
														<ul class="icons-list">
															<li>
										                    	<a href="#"><i class="icon-arrow-right13"></i></a>
									                    	</li>
								                    	</ul>
													</div>
												</li>
												<?
											}//foreach
											?>



										</ul>
									</div>
								</div>
								<!-- /daily financials -->