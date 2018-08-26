<?
	//$arr_alertas = array("primary", "danger", "success", "info", "warning");

	if( ($oWorkflow->_Cliente != $_SESSION["sss_usr_id_cln"]) || !is_object($oWorkflow) || ($oWorkflow->Status != "A") ){
		?>
		<div class="alert alert-danger">
			<h6><i class="icon-warning"></i>&nbsp;Erro!</h6>
			<span>Não achei sua permissão ou a Pipe está desativada :(</span>
		</div>
		<?
		return;
	}//if

	$oListaFase = FaseBD::getLista("fse_id_wrk = ".$wrk_id." AND fse_status = 'A'","fse_seq");

	if(count($oListaFase)==0){
		?>
		<div class="alert alert-warning">
			<h6><i class="icon-warning"></i>&nbsp;Erro!</h6>
			<span>Esta Pipe ainda não possui fases cadastradas :(</span>
		</div>
		<?
		return;
	}//if

	$template_card = file_get_contents(__DIR__."/../../htm/task.htm");

?>
<div id="workflow" fse="<?=$oListaFase[0]->Id?>" style="z-index: 900;">
	<?
	$contador_x = 0;
	foreach($oListaFase as $oFase){
		$contador_x++;
		$fse_id = $oFase->Id;
		$fse_seq = $oFase->Seq;
		$fse_tempo = intval($oFase->Tempo);
		$oListaTask = TaskBD::getLista("tsk_id_fse = ".$fse_id." AND tsk_status = 'A'");

		$arr_new_order = array();

		foreach($oListaTask as $oTask){

			$tsk_id = $oTask->Id;

			$dias_diferenca = 0;

			$oListaTaskFase = TaskFaseBD::getLista("tfs_id_fse = ".$fse_id." AND tfs_id_tsk = ".$tsk_id,"tfs_dt_ini",0,1);

			if(count($oListaTaskFase)>0){
				$dias_diferenca = RN::dateDiff2($oListaTaskFase[0]->DtIni,$dt_now);
			}//if


			$class_alerta = ($dias_diferenca > $fse_tempo)?"danger":(($dias_diferenca < $fse_tempo)?"success":"yellow");

			$sort_dias_dif = $fse_tempo - $dias_diferenca;

			$arr_new_order[$tsk_id] = array($dias_diferenca, $class_alerta, $oTask);

		}//foreach

		$tmp_diferenca = array();
		//$tmp_alerta = array();
		//$tmp_objeto = array();

		foreach ($arr_new_order as $key => $row) {
		    $tmp_diferenca[$key]  	= $row[0];
		    //$tmp_alerta[$key] 		= $row[1];
		    //$tmp_objeto[$key] 		= $row[2];
		}//foreach

		array_multisort($tmp_diferenca, SORT_DESC, $arr_new_order);


		?>
		<div class="list-wrapper">
			<div class="box media boxHeader">
					<h5 class="no-margin-top no-margin-bottom">
						<i class="icon-arrow-right15"></i>&nbsp;<?=$oFase->Titulo?>
					</h5>
			</div>
			<div id="divContainer_<?=$fse_id?>" class="list media-list media-list-target media-list-container" replica="<?=$oFase->Replica?>">

				<?
				//var_dump($arr_new_order);
				if($contador_x==1){
					/*
					?>
					<a href="#" class="btn btn-labeled btn-danger pull-right"><b><i class="icon-plus-circle2"></i></b>Adicionar Negócio</a>
					<?
					*/
				}//if

				$contador_y = 0;

				foreach($arr_new_order as $tsk_id => $arr_task){

					$oTask = $arr_task[2];
					$class_alerta = $arr_task[1];

					$contador_y++;

					$tsk_id = $oTask->Id;


					$tsk_titulo = trim($oTask->Titulo);
					$tsk_nome_cliente = "Sem Cliente definido";

					if( is_object($oTask->Cliente) ){
						$tsk_nome_cliente = $oTask->Cliente->Nome;
					}//if

					if( $tsk_titulo=="" ){
						$tsk_titulo = "Sem título";
					}//if

					//--------- percentuais ----->>
					$oListaQuestion = QuestionBD::getLista("qst_id_fse = ".$fse_id." AND qst_status = 'A'", "qst_seq");
					$arr_ids_qst = array();
					$arr_ids_qst_obrigatorio = array();
					foreach($oListaQuestion as $oQuestion){
						$arr_ids_qst[] = $oQuestion->Id;
						if($oQuestion->Required=="S")$arr_ids_qst_obrigatorio[] = $oQuestion->Id;
					}//foreach

					$total_qst = count($arr_ids_qst);
					$total_feito = 0;
					$percentual_feito = 0;
					$arr_condicoes_cumpridas = array();

					if($total_qst > 0){
						$oListaTaskQuestion = TaskQuestionBD::getLista("tqs_id_tsk = ".$tsk_id." AND tqs_id_qst IN(".implode(",",$arr_ids_qst).")");//." AND tsk_id_qst = ".$qst_id
						$total_feito = count($oListaTaskQuestion);
						$percentual_feito = $total_feito * 100 / $total_qst;

						foreach($oListaTaskQuestion as $oTaskQuestion){
							if(in_array($oTaskQuestion->_Question,$arr_ids_qst_obrigatorio)){
								$arr_condicoes_cumpridas[] = $oTaskQuestion->_Question;
							}//if
						}//foreach

					}else{
						$percentual_feito = 100;
					}//if

					$int_condicao_cumprida = ($percentual_feito==100 || ( count($arr_ids_qst_obrigatorio) == count($arr_condicoes_cumpridas) ) ) ? 1: 0;

					//--------- percentuais -----<<
					/*

					$class_alerta = "success";
					$dias_diferenca = 0;

					$oListaTaskFase = TaskFaseBD::getLista("tfs_id_fse = ".$fse_id." AND tfs_id_tsk = ".$tsk_id,"tfs_dt_ini",0,1);

					if(count($oListaTaskFase)>0){
						$dias_diferenca = RN::dateDiff2($oListaTaskFase[0]->DtIni,$dt_now);
					}//if

					if($dias_diferenca > $fse_tempo)$class_alerta = "danger";

					//$int_alerta = rand(0,4);
					//$class_alerta = $arr_alertas[$int_alerta];
					*/


					$string_this_card = $template_card;
					$string_this_card = str_replace("{tsk_id}",$oTask->Id,$string_this_card);
					$string_this_card = str_replace("{tsk_pai}",$oTask->_Task,$string_this_card);
					$string_this_card = str_replace("{tsk_titulo}",$tsk_titulo,$string_this_card);
					$string_this_card = str_replace("{tsk_status}",$oTask->Status,$string_this_card);
					$string_this_card = str_replace("{tsk_class_alerta}",$class_alerta,$string_this_card);
					$string_this_card = str_replace("{tsk_cln_nome}",$tsk_nome_cliente,$string_this_card);
					$string_this_card = str_replace("{fse_id}",$fse_id,$string_this_card);
					$string_this_card = str_replace("{condicao}",$int_condicao_cumprida,$string_this_card);
					$string_this_card = str_replace("{percentual_feito}",$percentual_feito,$string_this_card);

					echo $string_this_card;

					/*
					?>
					<div class="box media taskDiv" id="divTsk_<?=$oTask->Id?>" status="<?=$oTask->Status?>" fase="<?=$fse_id?>" tsk="<?=$oTask->Id?>" pai="<?=$oTask->_Task?>" condicao="<?=$int_condicao_cumprida?>">

							<div class="panel border-left-lg border-left-<?=$class_alerta?> {{class_extra}}">
								<div class="panel-body">
									<div class="row">
										<div class="col-md-12">
											<h6 class="no-margin-top no-margin-bottom">
												<a id="a_tsk_<?=$oTask->Id?>_title" href="#" data-toggle="modal" data-target="#modal_remote" tsk="<?=$oTask->Id?>"><?=$tsk_nome_cliente?></a>
												<i class="icon-dots dragula-handle pull-right"></i>
											</h6>
										</div>
									</div>
								</div>

								<div class="panel-footer panel-footer-condensed">
									<a class="heading-elements-toggle"><i class="icon-more"></i></a>
									<div class="heading-elements">

										<span class="heading-text classFooterBox"> <span class="text-semibold" id="spn_tsk_<?=$oTask->Id?>_subtitle"><?=$tsk_titulo?></span></span>

										<ul class="list-inline list-inline-condensed heading-text pull-right">

											<li>
												<span class="progress-meter taskprogress" data-progress="<?=$percentual_feito?>" data-color="#4CAF50"></span>
											</li>
											<li class="dropdown">
												<a href="#" class="text-default dropdown-toggle" data-toggle="dropdown"><i class="icon-cog"></i> <span class="caret"></span></a>
												<ul class="dropdown-menu dropdown-menu-right">
													<li><a href="#" onclick="arquivaTask(<?=$oTask->Id?>);return false;"><i class="icon-drawer-in"></i> Arquivar</a></li>
												</ul>
											</li>
										</ul>
									</div>
								</div>
							</div>


					</div>
					<?
					*/
				}//for
				?>
			</div>
		</div>
		<?
	}//for fase
	?>
</div>




<!-- Remote source -->
				<div id="modal_remote" class="modal">
					<div class="modal-dialog modal-full">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h5 class="modal-title">Detalhes do Processo</h5>
							</div>

							<div class="modal-body">

								<div class="col-md-12">
									<div class="panel panel-flat">

										<div class="panel-body">
											<div class="tabbable nav-tabs-vertical nav-tabs-left">
												<ul class="nav nav-tabs nav-tabs-highlight">
													<li><a href="#div_panel_cliente" data-toggle="tab"><i class="icon-profile position-left"></i> Cliente</a></li>
													<li class="active"><a href="#div_panel_atividades" data-toggle="tab"><i class="icon-checkmark position-left"></i> Atividades</a></li>
													<li><a href="#div_panel_info" data-toggle="tab"><i class="icon-info3 position-left"></i> Informações</a></li>
													<li><a href="#div_panel_equipe" data-toggle="tab"><i class="icon-users position-left"></i> Equipe</a></li>
													<li><a href="#div_panel_log" data-toggle="tab"><i class="icon-file-text position-left"></i> Log</a></li>
													<? /* ?>
													<li class="dropdown">
														<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-file-eye position-left"></i> Log do Negócio <span class="caret"></span></a>
														<ul class="dropdown-menu">
															<?
															foreach($oListaFase as $oFase){
																?>
																<li><a href="#div_panel_log" data-toggle="tab"><?=$oFase->Titulo?></a></li>
																<?
															}//foreach
															?>
														</ul>
													</li>
													<? */ ?>
												</ul>

												<div class="tab-content">
													<div class="tab-pane has-padding" id="div_panel_cliente">
														<i class="spinner icon-spinner"></i> Carregando...
													</div>

													<div class="tab-pane active has-padding" id="div_panel_atividades">
														<i class="spinner icon-spinner"></i> Carregando...
													</div>

													<div class="tab-pane has-padding" id="div_panel_info">
														<i class="spinner icon-spinner"></i> Carregando...
													</div>

													<div class="tab-pane has-padding" id="div_panel_equipe">
														<i class="spinner icon-spinner"></i> Carregando...
													</div>

													<div class="tab-pane has-padding" id="div_panel_log">
														Log...
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<br clear="all" />
							</div><!-- modal body -->

							<div class="modal-footer">
								<? /* <button type="button" class="btn btn-link" data-dismiss="modal">Cancelar</button>
								<button type="button" class="btn btn-primary">Salvar</button> */ ?>
							</div>
						</div>
					</div>
				</div>
				<!-- /remote source -->
				<div id="divTemplateTask" style="display:none;"><? include("htm/task.htm"); ?></div>
				<input type="hidden" name="hdd_id_wrk" id="hdd_id_wrk" value="<?=$wrk_id?>" />
				<input type="hidden" name="hdd_id_wrk_selected" id="hdd_id_wrk_selected" value="<?=$wrk_id?>" />
				<input type="hidden" name="hdd_id_fse_selected" id="hdd_id_fse_selected" value="" />
				<input type="hidden" name="hdd_id_tsk_selected" id="hdd_id_tsk_selected" value="" />
