<?

	include(__DIR__."/ini.php");
	//--------------------------------
	$fld_id = $obj_id;


	//var_dump($oObjeto);
	//--------------------------------
	if(is_object($oObjeto)){
		$oField = $oObjeto;

		//var_dump($oField);

		if($_SESSION["sss_usr_tipo"]=="A" || $oField->_Cliente == $_SESSION["sss_usr_id_cln"]){
			//--
		}else{
			//falhar!
			//echo "[falhar] ".$_SESSION["sss_usr_tipo"]." | ".$_SESSION["sss_usr_id_cln"];
			$oField = null;
		}//if

		//$fld_id      =		$oField->Id;
		//$fld_id_cln    = 		$oField->_Cliente;
		$fld_nome      = 		$oField->Nome;
		$fld_descricao = 		$oField->Descricao;
		$fld_default   = 		$oField->Default;
		$fld_tipo      = 		$oField->Tipo;
		$fld_decimal   = 		$oField->Decimal;
		$fld_status    = 		$oField->Status;
		$fld_cadastro    = 		intval($oField->Cadastro);

	}else{
		$fld_id_cln              = 0;
		$fld_nome                = "";
		$fld_descricao           = "";
		$fld_default             = "";
		$fld_tipo                = "I";// [I]nput [T]extarea [N]umero inteiro [D]ecimal [S]elect [R]adio [C]heckbox
	 	$fld_decimal             = 0;//0 nao, > 0 precisao
		$fld_status              = "A";
		$fld_cadastro    = 		0;
	}//if
	//--------------------------------
?>
<div class="col-md-6">

						<!-- Advanced legend -->
						<form action="./?mnu=<?=$page_id_mnu?>&act=act&id=<?=$obj_id?>&key=<?=$frm_key?>" method="POST" target="ifr_action">
							<div class="panel panel-flat">

								<div class="panel-body">

									<input type="hidden" name="hdd_id" id="hdd_id" value="<?=$obj_id?>">

									<fieldset>
										<legend class="text-semibold">
											<i class="icon-file-text2 position-left"></i>
											Dados do Campo
											<a class="control-arrow" data-toggle="collapse" data-target="#demo1">
												<i class="icon-circle-down2"></i>
											</a>
										</legend>

										<div class="collapse in" id="demo1">

											<div class="form-group">
												<label>Identificação:</label>
												<input type="text" class="form-control" placeholder="Nome do Campo" value="<?=$fld_nome?>" id="txt_nome" name="txt_nome" />
											</div>

											<div class="form-group">
												<label>Descrição:</label>
												<textarea rows="5" cols="5" class="form-control" placeholder="Descrição..." id="txt_descricao" name="txt_descricao"><?=$fld_descricao?></textarea>
											</div>

											<div class="form-group">
												<label>Tipo de resposta:</label>
												<select name="slc_tipo" id="slc_tipo">
													<option value="I"<?=$fld_tipo=="I"?" selected":""?>>Texto Curto</option>
													<? /* <option value="T"<?=$fld_tipo=="T"?" selected":""?>>Textarea</option> */ ?>
													<option value="N"<?=$fld_tipo=="N"?" selected":""?>>Númerico (Inteiro)</option>
													<? /* ?>
													<option value="D"<?=$fld_tipo=="D"?" selected":""?>>Númerico (Decimal)</option>
													<option value="S"<?=$fld_tipo=="S"?" selected":""?>>Select</option>
													<option value="R"<?=$fld_tipo=="R"?" selected":""?>>Radio</option>
													<option value="C"<?=$fld_tipo=="C"?" selected":""?>>Checkbox</option>
													<? */ ?>
													<option value="F"<?=$fld_tipo=="F"?" selected":""?>>Data</option>
												</select>
											</div>





											<div class="form-group">
												<label class="display-block">Status</label>

												<label class="radio-inline">
													<input type="radio" class="styled" name="txt_status" id="txt_status_A" value="A" <?=(($fld_status=="A")?" checked=\"checked\"":"")?>>
													Ativo
												</label>

												<label class="radio-inline">
													<input type="radio" class="styled" name="txt_status"  id="txt_status_I" value="I" <?=(($fld_status!="A")?" checked=\"checked\"":"")?> />
													Inativo
												</label>

											</div>

										</div>
									</fieldset>

									<fieldset>

										<legend class="text-semibold">
											<i class="icon-file-text2 position-left"></i>
											Usar no Cadastro do Cliente
											<a class="control-arrow" data-toggle="collapse" data-target="#demo2">
												<i class="icon-circle-down2"></i>
											</a>
										</legend>

										<div class="collapse in" id="demo2">

												<div class="form-group">

													<label class="radio-inline">
														<input type="radio" class="styled" name="txt_cadastro" name="txt_cadastro_0" value="0" <?=(($fld_cadastro < 1)?" checked=\"checked\"":"")?>>
														Não
													</label>

													<label class="radio-inline">
														<input type="radio" class="styled" name="txt_cadastro"  name="txt_cadastro_1" value="1" <?=(($fld_cadastro==1)?" checked=\"checked\"":"")?> />
														Sim, opcional
													</label>

													<label class="radio-inline">
														<input type="radio" class="styled" name="txt_cadastro"  name="txt_cadastro_2" value="2" <?=(($fld_cadastro==2)?" checked=\"checked\"":"")?> />
														Sim, obrigatório
													</label>

												</div>
										</div>
									</fieldset>

									<fieldset>

										<legend class="text-semibold">
											<i class="icon-file-text2 position-left"></i>
											Usar nas Pipelines
											<a class="control-arrow" data-toggle="collapse" data-target="#demo3">
												<i class="icon-circle-down2"></i>
											</a>
										</legend>

										<div class="collapse in" id="demo3">

												<div class="form-group">

														<?
														$oListaWorkflow = WorkflowBD::getLista("wrk_status = 'A' AND wrk_id_cln = ".$_SESSION["sss_usr_id_cln"],"wrk_titulo");

														//$fld_workflow[$oWorkflow->Id]

														foreach($oListaWorkflow as $oWorkflow){

															$oListaFieldFase = FieldFaseBD::getLista("ffs_id_fld = ".$fld_id." AND ffs_id_wrk = ".$oWorkflow->Id." AND ffs_id_fse = 0");

															if(count($oListaFieldFase)>0){
																$fld_workflow = ($oListaFieldFase[0]->Obrigatorio=="S")?2:1;
															}else{
																$fld_workflow = 0;
															}//if

															?>
															<div class="col-md-12">

																	<label class="display-block"><strong><?=$oWorkflow->Titulo?></strong></label>

																	<label class="radio-inline">
																		<input type="radio" class="styled" name="txt_workflow_<?=$oWorkflow->Id?>" name="txt_workflow_<?=$oWorkflow->Id?>_0" value="0" <?=(($fld_workflow < 1)?" checked=\"checked\"":"")?>>
																		Não
																	</label>

																	<label class="radio-inline">
																		<input type="radio" class="styled" name="txt_workflow_<?=$oWorkflow->Id?>"  name="txt_workflow_<?=$oWorkflow->Id?>_1" value="1" <?=(($fld_workflow==1)?" checked=\"checked\"":"")?> />
																		Sim, opcional
																	</label>

																	<label class="radio-inline">
																		<input type="radio" class="styled" name="txt_workflow_<?=$oWorkflow->Id?>"  name="txt_workflow_<?=$oWorkflow->Id?>_2" value="2" <?=(($fld_workflow==2)?" checked=\"checked\"":"")?> />
																		Sim, obrigatório
																	</label>
															</div><br /><br />
															<?
														}//foreach
														?>

													</div>
											</div>
									</fieldset>


									<div class="text-right">
										<button type="submit" class="btn btn-primary">Salvar <i class="icon-arrow-right14 position-right"></i></button>
									</div>
								</div>
							</div>
						</form>
						<!-- /a legend -->

					</div>