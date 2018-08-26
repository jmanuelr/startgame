<?

	include(__DIR__."/ini.php");

	$jnl_id = $obj_id;

	//$oListaJanelaUsuario = array();

	if(is_object($oObjeto)){
		$oJanela = $oObjeto;

		$jnl_id_sis                  = $oJanela->_Sistema;
		$jnl_nome                    = $oJanela->Nome;
		$jnl_url                    = $oJanela->Url;
		$jnl_ordem            	 	 = $oJanela->Ordem;
		$jnl_status                  = $oJanela->Status;

		if($_SESSION["sss_usr_tipo"]=="A" || $oJanela->_Cliente == $_SESSION["sss_usr_id_cln"]){
			//--
			//$oListaJanelaUsuario = JanelaUsuarioBD::getLista("esr_id_cln = ".$jnl_id);
		}else{
			//falhar!
			$oJanela = null;
		}//if

	}else{
		$jnl_id_sis                  = 0;
		$jnl_nome                    = "";
		$jnl_url                     = "";
		$jnl_ordem            	 	 = "";
		$jnl_status                  = "A";
	}//if

	// $oListaMembros = UsuarioBD::getLista("usr_id_cln = ".$_SESSION["sss_usr_id_cln"]." AND usr_status = 'A'", "usr_nome");
	// $arr_membros = array();
	// foreach($oListaJanelaUsuario as $oJanelaUsuario){
	// 	$arr_membros[] = $oJanelaUsuario->_Usuario;
	// }//foreach

?>
<div class="col-md-6">

						<!-- Advanced legend -->
						<form action="./?mnu=<?=$page_id_mnu?>&act=act&id=<?=$obj_id?>&key=<?=$frm_key?>&fonte=<?=$_REQUEST["fonte"]?>&sis=<?=$_REQUEST["sis"]?>" method="POST" target="ifr_action">
							<div class="panel panel-flat">

								<div class="panel-body">

									<input type="hidden" name="hdd_id" id="hdd_id" value="<?=$obj_id?>">
									<input type="hidden" name="hdd_id_sis" id="hdd_id_sis" value="<?=$sis_id?>">

									<fieldset>
										<legend class="text-semibold">
											<i class="icon-file-text2 position-left"></i>
											Dados do Janela
											<a class="control-arrow" data-toggle="collapse" data-target="#demo1">
												<i class="icon-circle-down2"></i>
											</a>
										</legend>

										<div class="collapse in" id="demo1">

											<div class="form-group">
												<label>Nome:</label>
												<input type="text" class="form-control" placeholder="Nome" value="<?=$jnl_nome?>" id="txt_nome" name="txt_nome" />
											</div>

											<div class="form-group">
												<label>URL:</label>
												<input type="text" class="form-control" placeholder="URL" value="<?=$jnl_url?>" id="txt_url" name="txt_url" />
											</div>

											<div class="form-group">
												<label>Ordem:</label>
												<?
												$oListaDemaisJanelas = JanelaBD::getLista("jnl_id_sis = ".$sis_id);
												$int_qtde_jnl = count($oListaDemaisJanelas);
												?>
												<select class="form-control" id="slc_ordem" name="slc_ordem">
													<?
													if($obj_id == 0){
														?>
														<option value="0">Automático (último)</option>
														<?
														$ate_onde = $int_qtde_jnl;
													}else{
														$ate_onde = $int_qtde_jnl - 1;
													}//if
													for($i = 0;$i<=$ate_onde;$i++){
														$j = $i + 1;
														?>
														<option value="<?=$j?>"<?=(($txt_ordem==$j)?" selected":"")?>><?=$j?></option>
														<?
													}//for
													?>
												</select>
											</div>

											<div class="form-group">
												<label class="display-block">Status</label>

												<label class="radio-inline">
													<input type="radio" class="styled" name="txt_status" id="txt_status_A" value="A" <?=(($jnl_status=="A")?" checked=\"checked\"":"")?>>
													Ativo
												</label>

												<label class="radio-inline">
													<input type="radio" class="styled" name="txt_status"  id="txt_status_I" value="I" <?=(($jnl_status!="A")?" checked=\"checked\"":"")?> />
													Inativo
												</label>

											</div>

										</div>


									</fieldset>

									<? /* ?>

									<fieldset>
										<legend class="text-semibold">
											<i class="icon-file-text2 position-left"></i>
											Membros da janela
											<a class="control-arrow" data-toggle="collapse" data-target="#demo2">
												<i class="icon-circle-down2"></i>
											</a>
										</legend>

										<div class="collapse in" id="demo2">

											<div class="form-group">
												<label>Selecione...</label>
												<select multiple="multiple" data-placeholder="Selecione..." class="select-icons" name="slc_id_usr[]" id="slc_id_usr">

													<optgroup label="Pessoas">
														<?
														foreach($oListaMembros as $oMembro){
															$is_selected = (in_array($oMembro->Id, $arr_membros))?" selected":"";
															?>
															<option value="<?=$oMembro->Id?>" data-icon="user" <?=$is_selected?>><?=$oMembro->Nome?></option>
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