<?

	include(__DIR__."/ini.php");

	$sis_id = $obj_id;

	$oListaSistemaUsuario = array();

	if(is_object($oObjeto)){
		$oSistema = $oObjeto;

		$sis_id_cln                  = $oSistema->_Cliente;
		$sis_id_usr                  = $oSistema->_Usuario;
		$sis_nome                    = $oSistema->Nome;
		$sis_info            	 = $oSistema->Info;
		$sis_status                  = $oSistema->Status;

		if($_SESSION["sss_usr_tipo"]=="A" || $oSistema->_Cliente == $_SESSION["sss_usr_id_cln"]){
			//--
			//$oListaSistemaUsuario = SistemaUsuarioBD::getLista("esr_id_sis = ".$sis_id);
		}else{
			//falhar!
			$oSistema = null;
		}//if

	}else{
		$sis_id_cln                  = 0;
		$sis_id_usr                  = 0;
		$sis_nome                    = "";
		$sis_info            	 = "";
		$sis_status                  = "A";
	}//if

	//$oListaMembros = UsuarioBD::getLista("usr_id_cln = ".$_SESSION["sss_usr_id_cln"]." AND usr_status = 'A'", "usr_nome");

	// $arr_membros = array();
	// foreach($oListaSistemaUsuario as $oSistemaUsuario){
	// 	$arr_membros[] = $oSistemaUsuario->_Usuario;
	// }//foreach

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
											Dados do Sistema
											<a class="control-arrow" data-toggle="collapse" data-target="#demo1">
												<i class="icon-circle-down2"></i>
											</a>
										</legend>

										<div class="collapse in" id="demo1">

											<div class="form-group">
												<label>Nome:</label>
												<input type="text" class="form-control" placeholder="Nome" value="<?=$sis_nome?>" id="txt_nome" name="txt_nome" />
											</div>

											<div class="form-group">
												<label>Descrição:</label>
												<textarea rows="5" cols="5" class="form-control" placeholder="Descrição..." id="txt_info" name="txt_info"><?=$sis_obs?></textarea>
											</div>

											<div class="form-group">
												<label class="display-block">Status</label>

												<label class="radio-inline">
													<input type="radio" class="styled" name="txt_status" id="txt_status_A" value="A" <?=(($sis_status=="A")?" checked=\"checked\"":"")?>>
													Ativo
												</label>

												<label class="radio-inline">
													<input type="radio" class="styled" name="txt_status"  id="txt_status_I" value="I" <?=(($sis_status!="A")?" checked=\"checked\"":"")?> />
													Inativo
												</label>

											</div>

										</div>


									</fieldset>

									<? /* ?>

									<fieldset>
										<legend class="text-semibold">
											<i class="icon-file-text2 position-left"></i>
											Membros da sistema
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