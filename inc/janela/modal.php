<input type="hidden" name="hdd_id_sis" id="hdd_id_sis" value="<?=$oJanela->_Sistema?>" />
<input type="hidden" name="hdd_id_jnl" id="hdd_id_jnl" value="" />
<!-- Remote source -->
				<div id="modal_janela" class="modal">
					<div class="modal-dialog modal-full">
						<div class="modal-content" style="height: 95%;">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h5 class="modal-title">Elementos</h5>
							</div>

							<div class="modal-body">

								<div class="col-md-12">
									<div class="panel panel-flat">

										<div class="panel-body">
											<div class="tabbable nav-tabs-vertical nav-tabs-left">
												<ul class="nav nav-tabs nav-tabs-highlight">
													<li class="active"><a href="#div_panel_selecionar" data-toggle="tab"><i class="icon-select2 position-left"></i> Adicionar Elemento...</a></li>
													<li><a href="#div_panel_acoes" onclick="loadElementos();" data-toggle="tab"><i class="icon-list-numbered position-left"></i> Lista de Elementos</a></li>
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
													<li>
														<div style="padding: 10px;" class="text-muted">
															<ul id="ul_element_list">
															</ul>
														</div>
													</li>
												</ul>
												

												<div class="tab-content">
													<div class="tab-pane has-padding active" id="div_panel_selecionar">
														<? /* <i class="spinner icon-spinner"></i> Carregando... */ ?>
														<div id="divIfrLogger" class="alert alert-default">
															<input type="hidden" name="hdd_elm_selecionado" id="hdd_elm_selecionado" value="" />
															<i class="icon-select2 2x"></i>&nbsp;
															<strong>Selecione um Elemento (o elemento deve possuir ID):</strong> <span id="spn_elm_selecionado" class="text-muted">-</span><br />
															<strong>Caminho do Elemento:</strong> <span id="path_elm_selecionado" class="text-muted"></span><br />
															<strong>ID do Elemento:</strong> <span id="id_elm_selecionado" class="text-muted"></span>&nbsp;&nbsp;
															<strong>NAME do Elemento:</strong> <span id="name_elm_selecionado" class="text-muted"></span>
															<br />
															<button class="btn btn-success btnAcao" onclick="adicionarALista();"><i class="icon-plus-circle2"></i>&nbsp;Adicionar à lista</button>
															<button class="btn btn-danger btnAcao" onclick="deselecionaElemento();"><i class="icon-cross"></i>&nbsp;Deselecionar</button>
														</div>
														<div id="divIfrContainer">
															<iframe name="ifr_janela" id="ifr_janela" src="" frameborder="0" width="100%" height="100%"></iframe>
														</div>
													</div>

													<div class="tab-pane has-padding" id="div_panel_acoes">
														&nbsp;
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