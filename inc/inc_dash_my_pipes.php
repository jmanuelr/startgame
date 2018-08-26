
<!-- Marketing campaigns -->
						<div class="panel panel-flat">
							<div class="panel-heading">
								<h6 class="panel-title">Meus Processos</h6>
								<div class="heading-elements">
									<? /* ?>
									<span class="label bg-success heading-text"><?=count($oListaTask)?> ativos</span>

									<ul class="icons-list">
				                		<li class="dropdown">
				                			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i> <span class="caret"></span></a>
											<ul class="dropdown-menu dropdown-menu-right">
												<li><a href="#"><i class="icon-sync"></i> Update data</a></li>
												<li><a href="#"><i class="icon-list-unordered"></i> Detailed log</a></li>
												<li><a href="#"><i class="icon-pie5"></i> Statistics</a></li>
												<li class="divider"></li>
												<li><a href="#"><i class="icon-cross3"></i> Clear list</a></li>
											</ul>
				                		</li>
				                	</ul>
				                	<? */ ?>
			                	</div>
							</div>

							<? /* ?>

							<div class="table-responsive">
								<table class="table table-lg text-nowrap">
									<tbody>
										<tr>
											<td class="col-md-5">
												<div class="media-left">
													<div id="campaigns-donut"></div>
												</div>

												<div class="media-left">
													<h5 class="text-semibold no-margin">38,289 <small class="text-success text-size-base"><i class="icon-arrow-up12"></i> (+16.2%)</small></h5>
													<ul class="list-inline list-inline-condensed no-margin">
														<li>
															<span class="status-mark border-success"></span>
														</li>
														<li>
															<span class="text-muted">May 12, 12:30 am</span>
														</li>
													</ul>
												</div>
											</td>

											<td class="col-md-5">
												<div class="media-left">
													<div id="campaign-status-pie"></div>
												</div>

												<div class="media-left">
													<h5 class="text-semibold no-margin">2,458 <small class="text-danger text-size-base"><i class="icon-arrow-down12"></i> (- 4.9%)</small></h5>
													<ul class="list-inline list-inline-condensed no-margin">
														<li>
															<span class="status-mark border-danger"></span>
														</li>
														<li>
															<span class="text-muted">Jun 4, 4:00 am</span>
														</li>
													</ul>
												</div>
											</td>

											<td class="text-right col-md-2">
												<? / * <a href="#" class="btn bg-indigo-300"><i class="icon-statistics position-left"></i> View report</a> * / ?>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<? */ ?>

							<div class="table-responsive">
								<table class="table text-nowrap" border="0" width="100%">
									<tbody>
										<?
										foreach($oListaWorkflow as $oWorkflow){

											$oListaFieldFase = FieldFaseBD::getLista("ffs_id_wrk = ".$oWorkflow->Id." AND ffs_id_fse = 0");//.$oFase->Id
											$count_extra_fields = count($oListaFieldFase);
											//foreach($oListaFieldFase as $oFieldFase){
											//	$oFieldFase->_Field;
											//}//for

											?>
											<tr class="active border-double">
												<td><strong><?=$oWorkflow->Titulo?></strong></td>
												<?
												foreach($oListaFieldFase as $oFieldFase){
													?><td><strong><?=$oFieldFase->Field->Nome?></strong></td><?
												}//foreach
												?>
												<td colspan="2">&nbsp;</td>
											</tr>
											<?

											$oListaFase = FaseBD::getLista("fse_id_wrk = ".$oWorkflow->Id." AND fse_status = 'A'","fse_seq");
											if(count($oListaFase)>0){
												foreach($oListaFase as $oFase){

													$tempo_limite = intval($oFase->Tempo);

													$oListaTask = TaskBD::getLista("tsk_id_fse = ".$oFase->Id." AND tsk_status = 'A'");
													$qntde_task_in_fase = count($oListaTask);
													$label_negocios = ($qntde_task_in_fase>0)?(($qntde_task_in_fase>1)?$qntde_task_in_fase." negócios":"1 negócio"):"Sem negócios";

													$arr_this_fase = array();

													foreach($oListaTask as $oTask){
														$arr_this_fase[] = $oTask->Id;
													}//id

													$condicao_task_fase = "tfs_id_fse = ".$oFase->Id;
													//if(count($arr_this_fase)>0)$condicao_task_fase.=" AND tfs_id_tsk IN(".implode(",",$arr_this_fase).")";

													$oListaTaskFase = TaskFaseBD::getLista($condicao_task_fase);

													$arr_tmp_tsk = array();
													$arr_tmp_tsk_unicas = array();

													$int_total_dias = 0;

													foreach($oListaTaskFase as $oTaskFase){

														if($oTaskFase->DtFim == ''){
															$dias_diferenca = RN::dateDiff2($oTaskFase->DtIni,$dt_now);
														}else{
															$dias_diferenca = intval($oTaskFase->DtDif);
														}//if


														if(in_array($oTaskFase->_Task,$arr_this_fase)){

															if(!isset($arr_tmp_tsk[$oTaskFase->_Task])){
																$arr_tmp_tsk[$oTaskFase->_Task] = $dias_diferenca;
															}else{
																$arr_tmp_tsk[$oTaskFase->_Task] += $dias_diferenca;
															}//if

														}//if

														if(!in_array($oTaskFase->_Task,$arr_tmp_tsk_unicas)){
															$arr_tmp_tsk_unicas[$oTaskFase->_Task] = $oTaskFase->_Task;
														}//if

														$int_total_dias += $dias_diferenca;

													}//foreach

													$int_task_no_prazo = 0;
													$int_task_fora_do_prazo = 0;
													$int_total_tasks = count($arr_tmp_tsk);

													foreach($arr_tmp_tsk as $tmp_id_tsk => $dias_na_fase){
														if($dias_na_fase > $tempo_limite){
															$int_task_fora_do_prazo++;
														}else{
															$int_task_no_prazo++;
														}//if
													}//foreach


													$int_unicas_tasks = count($arr_tmp_tsk_unicas);

													$media_dias_x_task = ($int_unicas_tasks > 0)?($int_total_dias / $int_unicas_tasks):0;

													$percentual_negativo = ($int_total_tasks>0)?floor(100 * $int_task_fora_do_prazo / $int_total_tasks):0;

													/////////////////////// RESPOSTAS FIELD_TASK
														/*
														select SUM(fts_numerico) as soma from gnb_field_task
														inner join gnb_task on tsk_id = fts_id_tsk
														where  tsk_status = 'A' and tsk_id_wrk = 2 and tsk_id_fse = 28;
														*/
														$paramCondicao = "tsk_status = 'A' and tsk_id_wrk = ".$oWorkflow->Id ." AND tsk_id_fse = ".$oFase->Id;//." AND fts_id_fld = 1";
														$paramOrderBy  = "";
														$paramCampo    = "fts_id_fld, SUM(fts_numerico) AS soma";
														$paramTabela   = " INNER JOIN gnb_task ON tsk_id = fts_id_tsk ";
														$paramGroupBy  = "fts_id_fld";
														$startRs       = "";
														$maxRs         = "";
														$boolGeraObj   = false;
														$oCustomFieldTask = FieldTaskBD::getCustomLista($paramCondicao, $paramOrderBy, $paramCampo, $paramTabela, $paramGroupBy, $startRs, $maxRs, $boolGeraObj);
														//$oCustomFieldTask["soma"];
													///////////////////////
													?>
													<tr>
														<td><?=$oFase->Titulo?><br /><span class="text-muted"><?=$label_negocios?></span></td>
														<?
														foreach($oListaFieldFase as $oFieldFase){
															$conteudo_cell = "";
															foreach($oCustomFieldTask as $chave => $valor){
																if($oFieldFase->_Field == $valor["fts_id_fld"]){
																	$conteudo_cell = $valor["soma"];
																	break;
																}//if
															}//foreach
															?>
															<td><?=$conteudo_cell?></td>
															<?
														}//foreach
														?>
														<td width="120">
															<? /* =$int_total_tasks." = ".$int_task_no_prazo." + ".$int_task_fora_do_prazo." (".$int_unicas_tasks."/".$int_total_dias.")" */ ?>
															<span class="progress-meter taskprogress" id="today-progress" data-progress="<?=$percentual_negativo?>" data-color="#F00"></span>
															<?
															$class_label = ($percentual_negativo > 0)?"danger":"success";
															?>
															<small class="text-<?=$class_label?> text-size-base"><?=$percentual_negativo?>%</small>

														</td>
														<td><span class="text-muted"><?=number_format($media_dias_x_task,2,",",".")?> dias</span></td>
													</tr>
													<?
												}//foreach
											}else{
												?>
												<tr>
													<td colspan="3">
														<span class="text-muted">Esta pipeline não possui fases ativas. <a href="#">Cadastre as fases aqui</a>.</span>
													</td>
												</tr>
												<?
											}//if

										}//foreach
										/*
										foreach($oListaTask as $oTask){
											?>
											<tr>
												<td>
													<div class="media-left media-middle">
														<a href="#"><img src="assets/images/placeholder.jpg" class="img-circle img-xs" alt=""></a>
													</div>
													<div class="media-left">
														<div class=""><a href="#" class="text-default text-semibold"><?=$oTask->Titulo?></a></div>
														<div class="text-muted text-size-small">
															<span class="status-mark border-blue position-left"></span>
															02:00 - 03:00
														</div>
													</div>
												</td>
												<td><span class="text-muted"><?=$oTask->Cliente->Nome?></span></td>
												<td><span class="text-success-600"><a href="./?page=workflow&id=<?=$oTask->_Workflow?>"><?=$oTask->Workflow->Titulo?></a></span></td>

												<td><span class="label bg-blue">Active</span></td>
												<td class="text-center">
													<ul class="icons-list">
														<li class="dropdown">
															<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>
															<ul class="dropdown-menu dropdown-menu-right">
																<li><a href="#"><i class="icon-file-stats"></i> View statement</a></li>
																<li><a href="#"><i class="icon-file-text2"></i> Edit campaign</a></li>
																<li><a href="#"><i class="icon-file-locked"></i> Disable campaign</a></li>
																<li class="divider"></li>
																<li><a href="#"><i class="icon-gear"></i> Settings</a></li>
															</ul>
														</li>
													</ul>
												</td>
											</tr>
											<?
										}//foreach
										*/
										?>
									</tbody>
								</table>
							</div>
						</div>
						<!-- /marketing campaigns -->