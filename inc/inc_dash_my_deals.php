
<!-- Marketing campaigns -->
						<div class="panel panel-flat">
							<div class="panel-heading">
								<h6 class="panel-title">Meus Negócios</h6>
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



							<div class="panel-body"><? // ?>


							<div class="tabbable">
									<ul class="nav nav-tabs nav-tabs-highlight">
										<?
										$contador_tabs = 0;
										foreach($oListaWorkflow as $oWorkflow){
											$contador_tabs++;
											$class_li = ($contador_tabs == 1)?"active":"";
											?>
											<li class="<?=$class_li?>"><a href="#highlight-tab<?=$oWorkflow->Id?>" data-toggle="tab"><?=$oWorkflow->Titulo?></a></li>
											<?
										}//foreach
										?>
									</ul>

									<div class="tab-content">
										<?
										$contador_tabs = 0;
										foreach($oListaWorkflow as $oWorkflow){
											$contador_tabs++;
											$class_li = ($contador_tabs == 1)?"active":"";
											?>
											<div class="tab-pane <?=$class_li?>" id="highlight-tab<?=$oWorkflow->Id?>">
												<div class="row">
													<div class="col-md-3 col-sm-10">
														<div class="form-group has-feedback">
															<input type="text" class="form-control filtroTask noLimit" placeholder="Buscar..." value="" wrk="<?=$oWorkflow->Id?>" />
															<div class="form-control-feedback">
																<i class="icon-search4 text-size-base"></i>
															</div>
														</div>
													</div>
												</div>

												<div class="outer">
													<div class="inner">
															<table id="table_wrk_<?=$oWorkflow->Id?>" class="table tbScroolH"><? // text-nowrap ?>

																<? include(__DIR__."/../ajax/ajax_dash_find_tasks.php"); ?>

															</table>
													</div>
												</div>
											</div>
											<?
										}//foreach
										?>
									</div>
							</div>



							</div>
						</div>
						<!-- /marketing campaigns -->