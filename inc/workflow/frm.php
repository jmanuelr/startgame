<?
	$wrk_id = $obj_id;
	$wrk_titulo = "";

	if($wrk_id > 0){
		$oWorkflow = WorkflowBD::get($wrk_id);
		$oListaFase = FaseBD::getLista("fse_id_wrk = ".$wrk_id." AND fse_status = 'A'","fse_seq");
		$wrk_titulo = $oWorkflow->Titulo;
	}else{
		$oListaFase = array();
	}//if


	if( ($oWorkflow->_Cliente != $_SESSION["sss_usr_id_cln"]) || !is_object($oWorkflow)  ){//|| ($oWorkflow->Status != "A"
		?>
		<div class="alert alert-danger">
			<h6><i class="icon-warning"></i>&nbsp;Erro!</h6>
			<span>Não achei sua permissão :(</span>
		</div>
		<?
		return;
	}//if

?>
<input type="hidden" name="hdd_id_wrk" id="hdd_id_wrk" value="<?=$wrk_id?>" />

<div class="row">
				<div class="col-md-3">

						<div class="panel panel-body border-top-info">
							<div class="text-center">
								<h6 class="no-margin text-semibold">Dados do Pipeline</h6>
								<p class="content-group-sm text-muted">Edite os dados e as fases do Pipeline</p>
							</div>

							<div class="form-group has-feedback">
								<label>Título do Pipeline:</label>
								<input type="text" class="form-control" name="txt_titulo_wrk_<?=$wrk_id?>" id="txt_titulo_wrk_<?=$wrk_id?>" placeholder="Nome do Pipeline" value="<?=($wrk_id>0)?$wrk_titulo:""?>" original="<?=($wrk_id>0)?$wrk_titulo:""?>" onfocus="inputAutoSave('focus',this);" onblur="inputAutoSave('blur',this);" onkeyup="if(TeclaEnter(event))this.blur();"  />
								<div class="form-control-feedback" style="display:none;">
									<i class="icon-edit"></i>
								</div>
							</div>

							<div class="form-group">
								<label>Fases do Pipeline:</label>
								<a href="#" class="pull-right" onclick="addElement('fse',<?=$wrk_id?>);return false;"><b><i class="icon-plus-circle2"></i></b> Adicionar Fase</a>

								<div class="text-center">
									<ul id="ul_lst_fse_<?=$wrk_id?>" class="selectable-demo-list"<? /* id="sortable-list-placeholder" selectable-demo-list */ ?>>
										<?
										$contador = 0;
										foreach($oListaFase as $oFase){
											$fse_id = $oFase->Id;
											$contador++;
											$class_active = "";//($contador==1)?"active":"";

											$oListaFieldFase = FieldFaseBD::getLista("ffs_id_fse = ".$fse_id);
											$str_fields = "";
											foreach ($oListaFieldFase as $oFieldFase) {
												if($str_fields !="")$str_fields.=",";
												$str_fields.=$oFieldFase->_Field.":".$oFieldFase->Obrigatorio;
											}//foreach

											$oListaTemplateFase = TemplateFaseBD::getLista("tfs_id_fse = ".$fse_id);
											$str_emails = "";
											foreach ($oListaTemplateFase as $oEmailFase) {
												if($str_emails !="")$str_emails.=",";
												$str_emails.= $oEmailFase->_Template;//.":".$oEmailFase->Obrigatorio;
												$str_emails.= ":".$oEmailFase->SendIn;
												$str_emails.= ":".$oEmailFase->SendOut;
												$str_emails.= ":".$oEmailFase->SendTime;
												$str_emails.= ":".$oEmailFase->SendTeam;
												$str_emails.= ":".$oEmailFase->SendResp;
												$str_emails.= ":".$oEmailFase->SendCln;
												$str_emails.= ":".$oEmailFase->SendMail;

											}//foreach

											?>
											<li class="<?=$class_active?> has-feedback liItem" id="li_fse_<?=$contador?>" fse="<?=$oFase->Id?>" titulo="<?=$oFase->Titulo?>"  descricao="<?=$oFase->Descricao?>" risco="<?=$oFase->Risco?>" tempo="<?=intval($oFase->Tempo)?>" fields="<?=$str_fields?>" emails="<?=$str_emails?>" replica="<?=$oFase->Replica?>">
												<a id="a_titulo_fse_<?=$contador?>" href="#" onclick="selectItem(this.id,true, <?=$contador?>);return false;">
													<span class="badgecontador badge badge-primary pull-left"><?=$contador?></span>
													<i class="icon-dots dragula-handle pull-right"></i>
													<span id="spn_titulo_fse_<?=$contador?>" onclick="editItem(this,true, <?=$contador?>);">
														<?=$oFase->Titulo?>
													</span>
												</a>
												<input id="txt_titulo_fse_<?=$contador?>" type="text" class="form-control faseHiddenText inputAutoSave" value="<?=$oFase->Titulo?>" onfocus="inputAutoSave('focus',this);" onblur="editItem(this,false, <?=$contador?>);inputAutoSave('blur',this);" original="" onkeyup="if(TeclaEnter(event))this.blur();" onchange="changeText(this);" />
												<div class="form-control-feedback" style="display:none;">
													<i class="icon-edit"></i>
												</div>
												<span class="dropdown pull-right spanOptions">
													<a href="#" class="text-default dropdown-toggle" data-toggle="dropdown"><i class="icon-cog"></i> <span class="caret"></span></a>
													<ul class="dropdown-menu dropdown-menu-right">
														<li><a href="#" onclick="selectItem('a_titulo_fse_<?=$contador?>',true, <?=$contador?>);return false;"><i class="icon-pencil7"></i> Editar</a></li>
														<li><a href="#" onclick="arquivaItem('fse', <?=$contador?>);return false;"><i class="icon-drawer-in"></i> Arquivar</a></li>
													</ul>
												</span>
											</li>
											<?
										}//foreach
										?>
									</ul>
									<br clear="all" /><br clear="all" />
									<?
									if($oWorkflow->Status == "A"){
										$label_class_work_status = "danger";
										$label_text_work = "Arquivar Pipeline";
										$label_icon_work = "drawer-in";
										$str_reativa = 'false';
									}else{
										$label_class_work_status = "success";
										$label_text_work = "Ativar Pipeline";
										$label_icon_work = "drawer-out";
										$str_reativa = 'true';
									}//if

									?>
									<a class="btn btn-sm btn-<?=$label_class_work_status?>" id="a_arquivar_wrk" onclick="arquivaItem('wrk',<?=$wrk_id?>, <?=$str_reativa?>);return false;" href="#"><i class="icon-<?=$label_icon_work?>"></i>&nbsp;<?=$label_text_work?></a>
								</div>
							</div>
						</div>

				</div>

				<div class="col-md-9">
								<?
								/* fase# */
								$contador = 0;
								//foreach($oListaFase as $oFase){
								//	$contador++;
								//	$style_display = ($contador==1)?"":"none";
//
//								//	$fse_id 		= $oFase->Id;
//								//	$fse_titulo 	= $oFase->Titulo;
//								//	$fse_descricao 	= $oFase->Descricao;
//								//	$fse_risco 		= $oFase->Risco;
								//}//foreach($oListaFase as $oFase)

								$fse_id 		= 0;
								$fse_titulo 	= "";
								$fse_descricao 	= "";
								$fse_risco 		= "";

								?>
									<!-- Advanced legend -->
									<div class="col-lg-12" style="display:;">

											<div class="panel panel-flat">
												<div class="panel-heading">
													<h5 id="h5_titulo_fse_<?=$fse_id?>" class="panel-title classNomeFase"></h5>
												</div>

												<div class="panel-body">

													<div id="divSelecioneUmaFase" class="alert alert-warning">
														<i class="icon-warning"></i>  <span class="text-muted">Selecione uma fase do processo...</span>
													</div>

													<? /* ============================ DADOS BASICOS DA FASE ======================== */ ?>

													<div class="col-lg-12">

															<fieldset>
																<legend class="text-semibold">
																	<i class="icon-file-text2 position-left"></i>
																	Dados da Fase <span class="classNomeFase"></span>
																	<a class="control-arrow" data-toggle="collapse" data-target="#divDadosFase<?=$fse_id?>">
																		<i class="icon-circle-down2"></i>
																	</a>
																</legend>

																<div class="collapse" id="divDadosFase<?=$fse_id?>">

																	<div class="col-lg-4">
																		<div class="form-group has-feedback">
																			<label>Nome da Fase:</label>
																			<input type="hidden" name="hdd_id_fse_selected" id="hdd_id_fse_selected" value="0" contador="0" />
																			<input type="text" class="form-control inputAutoSave" name="txt_titulo_fse_<?=$fse_id?>" id="txt_titulo_fse_<?=$fse_id?>" placeholder="Title" value="<?=($fse_id>0)?$fse_titulo:""?>" onkeyup="mudaTitulo(<?=$fse_id?>,this.value,'fse');" original="<?=($fse_id>0)?$fse_titulo:""?>" onfocus="inputAutoSave('focus',this);" onblur="inputAutoSave('blur',this);" <? /* onblur="salvarItem('fse');" */ ?> onkeyup="if(TeclaEnter(event))this.blur();" onchange="changeText(this);" />
																			<div class="form-control-feedback" style="display:none;">
																				<i class="icon-edit"></i>
																			</div>
																		</div>


																		<div class="form-group has-feedback">
																			<label>Descrição da Fase:</label>
																			<textarea name="txt_descricao_fse_<?=$fse_id?>" id="txt_descricao_fse_<?=$fse_id?>" rows="5" cols="5" class="form-control inputAutoSave" placeholder="Description..." original=""  onfocus="inputAutoSave('focus',this);" onblur="inputAutoSave('blur',this);"><?=$fse_descricao?></textarea>
																			<div class="form-control-feedback" style="display:none;">
																				<i class="icon-edit"></i>
																			</div>
																		</div>
																	</div>
																	<div class="col-lg-4">
																		<div class="form-group has-feedback">
																			<label>Dias estimados nesta Fase:</label>
																			<input type="text" class="form-control inputAutoSave" name="txt_tempo_fse_<?=$fse_id?>" id="txt_tempo_fse_<?=$fse_id?>" placeholder="Dias" value="<?=($fse_id>0)?$fse_titulo:""?>" original="" onfocus="inputAutoSave('focus',this);" onblur="inputAutoSave('blur',this);" <? /* onblur="salvarItem('fse');" */ ?> onkeyup="if(TeclaEnter(event))this.blur();" />
																			<div class="form-control-feedback" style="display:none;">
																				<i class="icon-edit"></i>
																			</div>
																		</div>
																		<div class="form-group has-feedback">
																			<label>Observações Importantes:</label>
										                                    <textarea  name="txt_risco_fse_<?=$fse_id?>" id="txt_risco_fse_<?=$fse_id?>" rows="5" cols="5" placeholder="..." class="form-control inputAutoSave" original=""  onfocus="inputAutoSave('focus',this);" onblur="inputAutoSave('blur',this);"><?=$fse_risco?></textarea>
										                                    <div class="form-control-feedback" style="display:none;">
																				<i class="icon-edit"></i>
																			</div>
											                			</div>
											                			<div class="form-group">
											                				<select id="slc_replica" name="slc_replica" class="select2" onchange="salvarReplica(this.value);">
											                					<option value="0">Não replica</option>
											                					<?
											                					foreach($oListaFase as $oTempFase){
											                						?>
											                						<option value="<?=$oTempFase->Id?>"><?=$oTempFase->Titulo?></option>
											                						<?
											                					}//foreach
											                					?>
											                				</select>
											                			</div>
										                			</div>

																</div>

															</fieldset>


													</div>
													<? /* ============================ CAMPOS CUSTOMIZADOS ======================== */ ?>
													<div class="col-lg-12">
														<legend class="text-semibold">
															<i class="icon-puzzle3 position-left"></i>
															Campos Customizados <span class="classNomeFase"></span>
															<a class="control-arrow" data-toggle="collapse" data-target="#divFields<?=$fse_id?>">
																<i class="icon-circle-down2"></i>
															</a>
														</legend>
														<div id="divFields<?=$fse_id?>" class="collapse">
																<div class="col-lg-8">
																	<table class="table">
																		<tr>
																			<th>Campos disponíveis</th>
																			<th>Obrigatório?</th>
																		</tr>
																		<?
																		$oListaField = FieldBD::getLista("fld_id_cln = ".$_SESSION["sss_usr_id_cln"]." AND fld_status = 'A'","fld_nome");
																		foreach($oListaField as $oField){
																			?>
																			<tr>
																				<td>
																					<div class="checkbox">
																						<label>
																							<input type="checkbox" class="control-info classFields"  name="chk_field_id_<?=$oField->Id?>" id="chk_field_id_<?=$oField->Id?>" onclick="setFieldFase(<?=$oField->Id?>,'field',this.checked);" />
																							&nbsp;<?=$oField->Nome?>&nbsp;<i class="icon-<?=$arr_field_tipos[$oField->Tipo][0]?> text-info-800"></i>
																						</label>
																					</div>
																				</td>
																				<td>
																					<div class="checkbox">
																						<label>
																							<input type="checkbox" class="control-info classFields"  name="chk_field_required_<?=$oField->Id?>" id="chk_field_required_<?=$oField->Id?>" onclick="setFieldFase(<?=$oField->Id?>,'req',this.checked);" />
																						</label>
																					</div>
																				</td>
																			</tr>
																			<?
																		}//foreach
																		?>
																	</table>

										                		</div>
														</div>
													</div>
													<? /* ============================ E-MAILS AUTOMATICOS ======================== */ ?>
													<div class="col-lg-12">
														<legend class="text-semibold">
															<i class="icon-envelop3 position-left"></i>
															E-mails Automáticos <span class="classNomeFase"></span>
															<a class="control-arrow" data-toggle="collapse" data-target="#divEmails<?=$fse_id?>">
																<i class="icon-circle-down2"></i>
															</a>
														</legend>
														<div id="divEmails<?=$fse_id?>" class="collapse">
																<div class="col-lg-12">
																	<table class="table">
																		<tr>
																			<th rowspan="2">Templates disponíveis</th>
																			<th rowspan="2" class="text-center">Ao entrar<br />na Fase</th>
																			<th rowspan="2" class="text-center">Dias<br />na Fase</th>
																			<th rowspan="2" class="text-center">Ao sair<br />da Fase</th>
																			<th colspan="3" class="text-center">Destinatários</th>
																		</tr>
																		<tr>
																			<th class="text-center">Equipe</th>
																			<th class="text-center">Responsáveis</th>
																			<th class="text-center">Cliente</th>
																		</tr>
																		<?
																		$oListaTemplate = TemplateBD::getLista("tmp_id_cln = ".$_SESSION["sss_usr_id_cln"]." AND tmp_tipo = 'E' AND tmp_status = 'A'","tmp_titulo");
																		foreach($oListaTemplate as $oTemplate){
																			?>
																			<tr>
																				<td>
																					<div class="checkbox">
																						<label>
																							<input type="checkbox" class="control-info classEmails"  name="chk_email_id_<?=$oTemplate->Id?>" id="chk_email_id_<?=$oTemplate->Id?>" onclick="setEmailFase(<?=$oTemplate->Id?>,'id',this.checked);" />
																							&nbsp;<?=$oTemplate->Titulo?>&nbsp;<i class="icon-envelop3 text-info-800"></i>
																						</label>
																					</div>
																				</td>
																				<td class="text-center">
																					<div class="checkbox">
																						<label>
																							<input type="checkbox" class="control-info classEmails"  name="chk_email_in_<?=$oTemplate->Id?>" id="chk_email_in_<?=$oTemplate->Id?>" onclick="setEmailFase(<?=$oTemplate->Id?>,'in',this.checked);" />
																						</label>
																					</div>
																				</td>
																				<td class="text-center">
																					<div class="form-group has-feedback">
																						<input type="text" class="form-control inputAutoSave classEmailsText" name="txt_email_dias_<?=$oTemplate->Id?>" id="txt_email_dias_<?=$oTemplate->Id?>" placeholder="Dias" value="" maxlength="3" size="3" original=""  onfocus="inputAutoSave('focus',this);" onblur="inputAutoSave('blur',this);" onkeyup="if(TeclaEnter(event))this.blur();" />
																						<div class="form-control-feedback" style="display:none;">
																							<i class="icon-edit"></i>
																						</div>
																					</div>
																				</td>
																				<td class="text-center">
																					<div class="checkbox">
																						<label>
																							<input type="checkbox" class="control-info classEmails"  name="chk_email_out_<?=$oTemplate->Id?>" id="chk_email_out_<?=$oTemplate->Id?>" onclick="setEmailFase(<?=$oTemplate->Id?>,'out',this.checked);" />
																						</label>
																					</div>
																				</td>
																				<td class="text-center">
																					<div class="checkbox">
																						<label>
																							<input type="checkbox" class="control-info classEmails"  name="chk_email_team_<?=$oTemplate->Id?>" id="chk_email_team_<?=$oTemplate->Id?>" onclick="setEmailFase(<?=$oTemplate->Id?>,'team',this.checked);" />
																						</label>
																					</div>
																				</td>
																				<td class="text-center">
																					<div class="checkbox">
																						<label>
																							<input type="checkbox" class="control-info classEmails"  name="chk_email_resp_<?=$oTemplate->Id?>" id="chk_email_resp_<?=$oTemplate->Id?>" onclick="setEmailFase(<?=$oTemplate->Id?>,'resp',this.checked);" />
																						</label>
																					</div>
																				</td>
																				<td class="text-center">
																					<div class="checkbox">
																						<label>
																							<input type="checkbox" class="control-info classEmails"  name="chk_email_cln_<?=$oTemplate->Id?>" id="chk_email_cln_<?=$oTemplate->Id?>" onclick="setEmailFase(<?=$oTemplate->Id?>,'dest_cln',this.checked);" />
																						</label>
																					</div>
																				</td>
																			</tr>
																			<?
																		}//foreach
																		?>
																	</table>

										                		</div>
														</div>
													</div>
													<? /* ============================ TAREFAS DA FASE ======================== */ ?>
													<div class="col-lg-12">

															<legend class="text-semibold">
																<i class="icon-reading position-left"></i>
																Tarefas da Fase <span class="classNomeFase"></span>
																<a class="control-arrow" data-toggle="collapse" data-target="#divTarefas<?=$fse_id?>">
																	<i class="icon-circle-down2"></i>
																</a>
															</legend>

															<div id="divTarefas<?=$fse_id?>" class="collapse">

																<div  class="col-lg-4">
																	<fieldset>

																			<div class="form-group">
																				<label>&nbsp;</label>
																				<a href="#" class="pull-right" onclick="addElement('qst',<?=$fse_id?>);return false;">
																					<b><i class="icon-plus-circle2"></i></b> Adicionar Tarefa
																				</a>
																				<ul id="ul_lst_qst_<?=$fse_id?>" class="selectable-demo-list text-center<? /* dropdown-menu dropdown-menu-sortable */ ?>" style="display: block; position: static; width: 100%; margin-top: 0; float: none;">
																				</ul>
																			</div>

																	</fieldset>
																</div>
																<div class="col-lg-8">

																		<div class="panel panel-white">


																				<div class="panel-body">
																					<? /* <form action="act/question.php?fse=<?=$fse_id?>&wrk=<?=$wrk_id?>" onsubmit="return validaQuestion(<?=$fse_id?>);" method="POST" target="ifr_action"> */ ?>
																						<fieldset>
																							<legend class="text-semibold">
																								<i class="icon-file-text2 position-left"></i>
																								Dados da Tarefa
																								<a class="control-arrow" data-toggle="collapse" data-target="#question<?=$fse_id?>">
																									<i class="icon-circle-down2"></i>
																								</a>
																							</legend>

																							<div class="collapse" id="question<?=$fse_id?>">
																								<div class="form-group has-feedback">
																									<label>Tarefa:</label>
																									<? /* <input type="hidden" name="hdd_id_task_<?=$fse_id?>" id="hdd_id_task_<?=$fse_id?>" value="" /> */ ?>
																									<input type="hidden" name="hdd_id_qst_selected" id="hdd_id_qst_selected" value="0" contador="0" />
																									<input type="text" class="form-control inputAutoSave" name="txt_titulo_qst_<?=$fse_id?>" id="txt_titulo_qst_<?=$fse_id?>" placeholder="Tarefa..." value="" original=""  onkeyup="mudaTitulo(<?=$fse_id?>,this.value,'qst');"  onfocus="inputAutoSave('focus',this);" onblur="inputAutoSave('blur',this);" <? /* onblur="salvarItem('qst');" */ ?>onkeyup="if(TeclaEnter(event))this.blur();" onchange="changeText(this);" />
																									<div class="form-control-feedback" style="display:none;">
																										<i class="icon-edit"></i>
																									</div>
																								</div>

																								<div class="form-group has-feedback">
																									<label>Informação complementar</label>
																									<textarea name="txt_descricao_qst_<?=$fse_id?>" id="txt_descricao_qst_<?=$fse_id?>" rows="5" cols="5" class="form-control inputAutoSave" placeholder="Descrição (opcional)..." original=""  onfocus="inputAutoSave('focus',this);" onblur="inputAutoSave('blur',this);"></textarea>
																									<div class="form-control-feedback" style="display:none;">
																										<i class="icon-edit"></i>
																									</div>
																								</div>


																								<!-- Basic example -->
																								<? /* ?>
																								<div class="form-group">
																									<label>Sub-tarefas:</label>
																									<input type="text" name="txt_tags_qst_<?=$fse_id?>" id="txt_tags_qst_<?=$fse_id?>" class="form-control tokenfield" value="">
																								</div>
																								<? */ ?>

																								<div class="form-group">
																									<label>Responsáveis:</label>
																									<?
																									$oListaEquipe = EquipeBD::getLista("eqp_id_cln = ".$_SESSION["sss_usr_id_cln"],"eqp_nome");
																									$oListaMembro = UsuarioBD::getLista("usr_id_cln = ".$_SESSION["sss_usr_id_cln"],"usr_nome");
																									?>
																									<select multiple="multiple" data-placeholder="Responsáveis..." class="select-icons" name="slc_id_eqps" id="slc_id_eqps" onchange="salvarEquipeTarefa(this);" original="">
																										<?
																										if(count($oListaEquipe)>0){
																											?>
																											<optgroup label="Equipes">
																												<?
																												foreach($oListaEquipe as $oEquipe){
																													?><option value="t:<?=$oEquipe->Id?>" data-icon="users4"><?=$oEquipe->Nome?></option><?
																												}//foreach
																												?>
																											</optgroup>
																											<?
																										}//if
																										?>
																										<?
																										if(count($oListaMembro)>0){
																											?>
																											<optgroup label="Pessoas">
																												<?
																												foreach($oListaMembro as $oMembro){
																													?><option value="u:<?=$oMembro->Id?>" data-icon="user"><?=$oMembro->Nome?></option><?
																												}//foreach
																												?>
																											</optgroup>
																											<?
																										}//if
																										?>
																									</select>
																								</div>
																								<!-- /basic example -->

																								<div class="form-group">
																									<label class="display-block">É Obrigatório?</label>

																									<label class="radio-inline">
																										<input type="radio" class="styled" name="txt_required_qst_<?=$fse_id?>" value="S" onclick="salvaObrigatorio('S');">
																										Sim
																									</label>

																									<label class="radio-inline">
																										<input type="radio" class="styled" name="txt_required_qst_<?=$fse_id?>" value="N" checked="checked" onclick="salvaObrigatorio('N');" />
																										Não
																									</label>

																								</div>
																								<? /* ?>

																								<div class="text-right">
																									<button type="submit" class="btn btn-primary">Adicionar</button>
																								</div>
																								<? */?>

																							</div>
																						</fieldset>
																					<? /* </form> */ ?>
																					<p class="text-muted">Selecione uma tarefa ao lado.</p>
																				</div>

																	</div>
																</div>
															</div>
													</div>


												</div>
											</div>

									</div>
									<!-- /a legend -->


				</div>
</div>