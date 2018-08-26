<?
	/*
	DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CalculaToDo`( `id_user` int)
BEGIN
    declare qtde_todo int(11);

    select count(*) INTO qtde_todo from (select tsk_id,qst_id
	from gnb_task
	inner join gnb_question on qst_id_fse = tsk_id_fse
	 left join gnb_task_question on tsk_id = tqs_id_tsk and qst_id = tqs_id_qst
	 inner join gnb_equipe_question on eqs_id_qst = qst_id
	where qst_status = 'A'
	AND tsk_status = 'A'
	AND (eqs_id_usr = 1 OR eqs_id_eqp in (select distinct(esr_id_eqp) from gnb_equipe_usuario where esr_id_usr = 1))
	AND tqs_id_tsk is null
	group by tsk_id,qst_id
	) as booh;

    UPDATE gnb_usuario SET usr_todo = qtde_todo WHERE usr_id = id_user;
END;;
DELIMITER ;

	select tsk_id, tsk_id_cln, tsk_titulo, tsk_descricao, tsk_id_fse, tsk_id_wrk, tsk_seq, qst_id, qst_titulo, qst_descricao
	from gnb_task
	 inner join gnb_question on qst_id_fse = tsk_id_fse
	 left join gnb_task_question on tsk_id = tqs_id_tsk and qst_id = tqs_id_qst
	 inner join gnb_equipe_question on eqs_id_qst = qst_id

	where qst_status = 'A'
	 AND tsk_status = 'A'
	 AND (eqs_id_usr = 1 OR eqs_id_eqp in (select distinct(esr_id_eqp) from gnb_equipe_usuario where esr_id_usr = 1))
	 AND tqs_id_tsk is null
	 group by tsk_id,qst_id
	 order by tsk_seq,qst_seq;
	*/

$paramCondicao = "qst_status = 'A'";

$paramCondicao.= " AND tsk_status = 'A'";
$paramCondicao.= " AND (eqs_id_usr = ".$_SESSION["sss_usr_id"]." OR eqs_id_eqp in (select distinct(esr_id_eqp) from gnb_equipe_usuario where esr_id_usr = ".$_SESSION["sss_usr_id"]."))";
$paramCondicao.= " AND tqs_id_tsk is null";

$paramOrderBy  = " tsk_seq,qst_seq";
$paramCampo    = " tsk_id,tsk_id_cln,tsk_titulo,tsk_descricao,tsk_id_fse,tsk_id_wrk,tsk_seq,qst_id,qst_titulo,qst_descricao";

$paramTabela   = " inner join gnb_question on qst_id_fse = tsk_id_fse";
$paramTabela  .= " left join gnb_task_question on tsk_id = tqs_id_tsk and qst_id = tqs_id_qst ";
$paramTabela  .= " inner join gnb_equipe_question on eqs_id_qst = qst_id";

$paramGroupBy  = "tsk_id,qst_id";//"qst_id";
$startRs       = "";
$maxRs         = "";
$boolGeraObj   = false;
$oListaTaskTodo    = TaskBD::getCustomLista($paramCondicao, $paramOrderBy, $paramCampo, $paramTabela, $paramGroupBy, $startRs, $maxRs, $boolGeraObj);


?>
<!-- Marketing campaigns -->
						<div class="panel panel-flat">
							<div class="panel-heading">
								<h6 class="panel-title">To Do</h6>
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
										$dt_now = date("Ymd");
										$count_todo = 0;
										foreach($oListaTaskTodo as $arrTask){
											$count_todo++;
											//-----------------
											$tsk_id = $arrTask["tsk_id"];
											$oTask = TaskBD::get($tsk_id);
											//-----------------
											$fse_id = $oTask->_Fase;
											$fse_tempo = intval($oTask->Fase->Tempo);
											$dias_diferenca = 0;

											$oListaTaskFase = TaskFaseBD::getLista("tfs_id_fse = ".$fse_id." AND tfs_id_tsk = ".$tsk_id,"tfs_dt_ini",0,1);
											$this_dt_ini = "";

											if(count($oListaTaskFase)>0){
												$this_dt_ini = $oListaTaskFase[0]->DtIni;
												$dias_diferenca = RN::dateDiff2($this_dt_ini,$dt_now);
											}//if

											$class_alerta = ($dias_diferenca > $fse_tempo)?"danger":(($dias_diferenca < $fse_tempo)?"success":"yellow");
											//$sort_dias_dif = $fse_tempo - $dias_diferenca;
											//-----------------

											?>
											<tr>
												<td>
													#<?=$count_todo?>
												</td>
												<td>
													<span class="text-default text-semibold"><?=$oTask->Titulo?></span><br />
													<span class="text-muted">
														<?=$oTask->Cliente->Nome?>
													</span>
												</td>
												<td>
													<div class="media-left">
														<span class="text-default text-semibold"><?=$oTask->Workflow->Titulo?></span><br />
														<span class="text-muted">
														<?=$oTask->Fase->Titulo?>
													</span>
													</div>
												</td>
												<td><a href="./?mnu=2&page=workflow&act=dtl&id=<?=$oTask->_Workflow?>&task=<?=$oTask->Id?>"><?=$arrTask["qst_titulo"]?><br /><span class="text-muted"><?=$oTask->Workflow->Titulo?></span></a></td>

												<td><label class="label label-<?=$class_alerta?>"><?=RN::NormalDate($this_dt_ini)?></label></td>
											</tr>
											<?
										}//foreach

										?>
									</tbody>
								</table>
							</div>
						</div>
						<!-- /marketing campaigns -->