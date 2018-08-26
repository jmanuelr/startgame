<?

	include(__DIR__."/ini.php");

	$usr_id = $obj_id;

	$oListaEquipeUsuario = array();

	if(is_object($oObjeto)){
		$oUsuario = $oObjeto;

		if($_SESSION["sss_usr_tipo"]=="A" || $oUsuario->_Cliente == $_SESSION["sss_usr_id_cln"]){
			//--
			//$oListaEquipeUsuario = EquipeUsuarioBD::getLista("esr_id_usr = ".$oUsuario->Id);
		}else{
			//falhar!
			$oUsuario = null;
		}//if

		$usr_id_cln                  = $oUsuario->_Cliente;

		$usr_nome                    = $oUsuario->Nome;
		$usr_email            		 = $oUsuario->Email;
		$usr_dt_nasc            	 = RN::NormalDate($oUsuario->DtNasc);
		$usr_status                  = $oUsuario->Status;
		$usr_supervisor              = $oUsuario->Supervisor;

	}else{
		//--------------------------------
		$usr_id = 0;
		$usr_id_cln                  = 0;
		$usr_nome                    = "";
		$usr_email            	 	 = "";
		$usr_status                  = "A";
		$usr_supervisor 			 = "N";
		//--------------------------------
	}//if

	$oListaEquipe = EquipeBD::getLista("eqp_id_cln = ".$_SESSION["sss_usr_id_cln"], "eqp_nome");

	$arr_equipes = array();
	foreach($oListaEquipeUsuario as $oEquipeUsuario){
		$arr_equipes[] = $oEquipeUsuario->_Equipe;
	}//foreach


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
											Dados do Usuário
											<a class="control-arrow" data-toggle="collapse" data-target="#demo1">
												<i class="icon-circle-down2"></i>
											</a>
										</legend>

										<div class="collapse in" id="demo1">

											<div class="form-group">
												<label>Nome:</label>
												<input type="text" class="form-control" placeholder="Nome" value="<?=$usr_nome?>" id="txt_nome" name="txt_nome" />
											</div>

											<div class="form-group">
												<label>E-mail:</label>
												<input type="text" class="form-control" placeholder="E-mail" value="<?=$usr_email?>" id="txt_email" name="txt_email" />
											</div>

											<div class="form-group">
												<label>Data Nascimento:</label>
												<input type="text" class="form-control mask_data" placeholder="" value="<?=$usr_dt_nasc?>" id="txt_dt_nasc" name="txt_dt_nasc" />
											</div>

											<? /* ?>

											<div class="form-group">
												<label class="display-block">É Supervisor?</label>

												<label class="radio-inline">
													<input type="radio" class="styled" name="txt_supervisor" name="txt_supervisor_S" value="S" <?=(($usr_supervisor=="S")?" checked=\"checked\"":"")?>>
													Sim
												</label>

												<label class="radio-inline">
													<input type="radio" class="styled" name="txt_supervisor"  name="txt_supervisor_N" value="N" <?=(($usr_supervisor!="S")?" checked=\"checked\"":"")?> />
													Não
												</label>

											</div>
											<? */ ?>

											<?
											if($_SESSION["sss_usr_id"] == $usr_id){
												//-- nao pode
											}else{
												?>
												<div class="form-group">
													<label class="display-block">Status</label>

													<label class="radio-inline">
														<input type="radio" class="styled" name="txt_status" id="txt_status_A" value="A" <?=(($usr_status=="A")?" checked=\"checked\"":"")?> />
														Ativo
													</label>

													<label class="radio-inline">
														<input type="radio" class="styled" name="txt_status"  id="txt_status_I" value="I" <?=(($usr_status!="A")?" checked=\"checked\"":"")?> />
														Inativo
													</label>

												</div>
												<?
											}//if
											?>



											<?
											if($usr_id > 0){
												?>
												<div class="form-group">
													<? /* <label class="display-block">&nbsp;</label> */ ?>

													<label class="display-block">
														<input type="checkbox" class="styled" name="chk_senha" name="chk_senha" value="1" onclick="showMudaSenha(this.checked);" />
														Alterar senha
													</label>

												</div>
												<div class="form-group" id="div_muda_senha" style="display:none;">
													<label class="display-block">Nova Senha</label>
													<input type="password" class="form-control" placeholder="Nova Senha" value="" id="txt_nova_senha" name="txt_nova_senha" />
												</div>
												<div class="form-group" id="div_muda_senha_confirma" style="display:none;">
													<label class="display-block">Nova Senha</label>
													<input type="password" class="form-control" placeholder="Confirma Senha" value="" id="txt_nova_senha_confirma" name="txt_nova_senha_confirma" />
												</div>
												<?
											}//if
											?>

										</div>
									</fieldset>

									<? /* ?>

									<fieldset>
										<legend class="text-semibold">
											<i class="icon-file-text2 position-left"></i>
											Membro das equipes
											<a class="control-arrow" data-toggle="collapse" data-target="#demo2">
												<i class="icon-circle-down2"></i>
											</a>
										</legend>

										<div class="collapse in" id="demo2">

											<div class="form-group">
												<label>Selecione...</label>
												<select multiple="multiple" data-placeholder="Selecione..." class="select-icons" name="slc_id_eqp[]" id="slc_id_eqp">

													<optgroup label="Pessoas">
														<?
														foreach($oListaEquipe as $oEquipe){
															$is_selected = (in_array($oEquipe->Id, $arr_equipes))?" selected":"";
															?>
															<option value="<?=$oEquipe->Id?>" data-icon="users4" <?=$is_selected?>><?=$oEquipe->Nome?></option>
															<?
														}//foreach
														?>
													</optgroup>
												</select>
											</div>

										</div>
									</fieldset>
									<? */ ?>


									<div class="text-right">
										<button type="submit" class="btn btn-primary">Salvar <i class="icon-arrow-right14 position-right"></i></button>
									</div>
								</div>
							</div>
						</form>
						<!-- /a legend -->

					</div>