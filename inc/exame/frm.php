<?

	include(__DIR__."/ini.php");

	$exm_id = $obj_id;

	$oListaResultado = array();


	if(is_object($oObjeto)){
		$oExame = $oObjeto;

		$exm_id_usr                  = $oExame->_Usuario;
		$exm_nome                    = $oExame->Nome;
		$exm_descricao            	 = $oExame->Descricao;
		$exm_dt_registro           	 = $oExame->DtRegistro;
		$exm_status                  = $oExame->Status;

		$oListaResultado = ResultadoBD::getLista("rst_id_exm = ".$exm_id);

	}else{
		$exm_id_cln                  = 0;
		$exm_id_usr                  = 0;
		$exm_nome                    = "";
		$exm_descricao            	 = "";
		$exm_status                  = "A";
	}//if

	$oListaMembros = array();//

	$arr_membros = array();

	if($exm_dt_registro=="")$exm_dt_registro = date("d/m/Y");

?>
<div class="col-md-6">

						<!-- Advanced legend -->
						<form action="./?mnu=<?=$page_id_mnu?>&act=act&id=<?=$obj_id?>&key=<?=$frm_key?>" method="POST" target="ifr_action" onsubmit="lerAntro();">
							<div class="panel panel-flat">

								<div class="panel-body">

									<input type="hidden" name="hdd_id" id="hdd_id" value="<?=$obj_id?>">

									<fieldset>
										<legend class="text-semibold">
											<i class="icon-file-text2 position-left"></i>
											Dados do Exame
											<a class="control-arrow" data-toggle="collapse" data-target="#demo1">
												<i class="icon-circle-down2"></i>
											</a>
										</legend>

										<div class="collapse in" id="demo1">

											<div class="form-group">
												<label>Data do exame:</label>
												<input type="text" class="form-control mask_data" placeholder="" value="<?=$exm_dt_registro?>" id="txt_dt_registro" name="txt_dt_registro" />
											</div>

											<div class="form-group">
												<label>Desc:</label>
												<input type="text" class="form-control" placeholder="Nome" value="<?=$exm_nome?>" id="txt_nome" name="txt_nome" maxlength="150" />
											</div>

											<div class="form-group">
												<label>Obs:</label>
												<textarea rows="5" cols="5" class="form-control" placeholder="Descrição..." id="txt_descricao" name="txt_descricao" maxlength="500"><?=$exm_descricao?></textarea>
											</div>
											<? /* ?>
											<div class="form-group">
												<label class="display-block">Status</label>

												<label class="radio-inline">
													<input type="radio" class="styled" name="txt_status" id="txt_status_A" value="A" <?=(($exm_status=="A")?" checked=\"checked\"":"")?>>
													Ativo
												</label>

												<label class="radio-inline">
													<input type="radio" class="styled" name="txt_status"  id="txt_status_I" value="I" <?=(($exm_status!="A")?" checked=\"checked\"":"")?> />
													Inativo
												</label>

											</div>
											<? */ ?>

										</div>


									</fieldset>
									<? /* ?>
									<fieldset>
										<legend class="text-semibold">
											<i class="icon-file-text2 position-left"></i>
											Membros da Exame
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

									<input type="hidden" name="hdd_antropometria" id="hdd_antropometria" value="" />

									<div class="text-right">
										<button type="submit" class="btn btn-primary">Salvar <i class="icon-arrow-right14 position-right"></i></button>
									</div>
								</div>
							</div>
						</form>
						<!-- /a legend -->

					</div>


<div class="col-md-6">
	<div class="panel panel-flat">

		<div class="panel-body">

			<fieldset>
								<legend class="text-semibold">
									<i class="icon-file-text2 position-left"></i>
									Inserir Dados
									<a class="control-arrow" data-toggle="collapse" data-target="#demo1">
										<i class="icon-circle-down2"></i>
									</a>
								</legend>

								<div class="collapse in" id="demo2">

											<div id="divSearchContainer" class="col-md-12 col-sm-12 col-xs-12">
													<div class="form-group has-feedback" style="margin:5px 0;">
														<input id="txt_search" name="txt_search" type="text" class="form-control noLimit" placeholder="Buscar..." value="" wrk="0" />
														<div class="form-control-feedback">
															<i class="icon-search4 text-size-base"></i>
														</div>
													</div>
													<div id="divSearchResult">
														<table class="table">
															<thead>
																<tr>
																	<th id="thSearchResult"></th>
																</tr>
															</thead>
															<tbody id="tbodySearchResults"></tbody>
														</table>
													</div>
												</div>
												<div class="col-md-1">
													<span id="msg_busca" class="text-muted" style="display:inline;"></span>
												</div>


											<table class="table" id="tbAntropometria">
												<tr>
													<th>Dado</th>
													<th>Valor</th>
													<th>&nbsp;</th>
												</tr>
												<?
												foreach($oListaResultado as $oResultado){
													?>
													<tr id="tr_ant_<?=$oResultado->_Antropometria?>">
													    <td><?=$oResultado->Antropometria->Nome?></td>
													    <td><input type="text" class="form-control inpAntro" id="txt_ant_<?=$oResultado->_Antropometria?>" size="5" value="<?=$oResultado->String?>" placeholder="Valor..." /></td>
													    <td><a href="#" onclick="removeAntro(<?=$oResultado->_Antropometria?>);"><i class="icon-trash"></i></a></td>
													 </tr>
													<?
												}//foreach
												?>
											</table>
								</div>
			</fieldset>
		</div>
	</div>
</div>