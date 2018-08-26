<?

	include(__DIR__."/ini.php");

	$cln_id = $obj_id;

	if(is_object($oObjeto)){
		$oCliente = $oObjeto;
	}else{
		//--
	}//if
	//--------------------------------
	$oListaContato = array();
	//--------------------------------
	$cln_id_cln                  = 0;
	$cln_id_usr                  = 0;
	$cln_tipo                    = "";
	$cln_cnpj_cpf                = "";
	$cln_nome                    = "";
	$cln_razao_social            = "";
	$cln_id_cdd                  = 0;
	$cln_uf                      = "";
	$cln_end_rua                 = "";
	$cln_end_nro                 = "";
	$cln_end_compl               = "";
	$cln_end_cep                 = "";
	$cln_bairro                  = "";
	$cln_fone                    = "";
	$cln_tipo_assinatura         = "";
	$cln_id_reg                  = 0;
	$cln_id_atv                  = 0;
	$cln_num_empregados_anterior = "";
	$cln_id_prt                  = 0;
	$cln_relacao_parceiro        = "";
	$cln_parceiros               = "";
	$cln_autoriza_divulgacao     = "";
	$cln_dt_cadastro             = "";
	$cln_hr_cadastro             = "";
	$cln_obs                     = "";
	$cln_id_mdl                  = 0;
	$cln_validacao_dados         = "";
	$cln_status                  = "A";
	$cln_int_pagamento           = "";
	$cln_dt_venc_anuidade        = "";
	$cln_id_ffn                  = 0;
	//--------------------------------
	$cnt_id = 0;
	$cnt_nome = "";
	$cnt_email = "";
	$cnt_fone = "";
	//--------------------------------

	if(is_object($oCliente)){

		if($_SESSION["sss_usr_tipo"]=="A" || $oCliente->_Cliente == $_SESSION["sss_usr_id_cln"]){
			//--
		}else{
			//falhar!
			$oCliente = null;
		}//if

		//$cln_id                      = $oCliente->Id;
		$cln_id_cln                  = $oCliente->_Cliente;
		$cln_id_usr                  = $oCliente->_Usuario;
		$cln_tipo                    = $oCliente->Tipo;
		$cln_cnpj_cpf                = $oFormata->getCNPJ($oCliente->CnpjCpf);
		$cln_nome                    = $oCliente->Nome;
		$cln_razao_social            = $oCliente->RazaoSocial;
		$cln_id_cdd                  = $oCliente->_Cidade;
		$cln_uf                      = $oCliente->Uf;
		$cln_end_rua                 = $oCliente->EndRua;
		$cln_end_nro                 = $oCliente->EndNro;
		$cln_end_compl               = $oCliente->EndCompl;
		$cln_end_cep                 = $oCliente->EndCep;
		$cln_bairro                  = $oCliente->Bairro;
		$cln_fone                    = $oCliente->Fone;
		$cln_tipo_assinatura         = $oCliente->TipoAssinatura;
		$cln_id_reg                  = $oCliente->_Regiao;
		$cln_id_atv                  = $oCliente->_Atividade;
		$cln_num_empregados_anterior = $oCliente->NumEmpregadosAnterior;
		$cln_id_prt                  = $oCliente->_PorteEmpresa;
		$cln_relacao_parceiro        = $oCliente->RelacaoParceiro;
		$cln_parceiros               = $oCliente->Parceiros;
		$cln_autoriza_divulgacao     = $oCliente->AutorizaDivulgacao;
		$cln_dt_cadastro             = $oCliente->DtCadastro;
		$cln_hr_cadastro             = $oCliente->HrCadastro;
		$cln_obs                     = $oCliente->Obs;
		$cln_id_mdl                  = $oCliente->_Modalidade;
		$cln_validacao_dados         = $oCliente->ValidacaoDados;
		$cln_status                  = $oCliente->Status;
		$cln_int_pagamento           = $oCliente->IntPagamento;
		$cln_dt_venc_anuidade        = $oCliente->DtVencAnuidade;
		$cln_id_ffn                  = $oCliente->FaixaFuncionario;

		$oListaContato = ContatoBD::getLista("cnt_id_cln = ".$cln_id,"cnt_nome");


		if(count($oListaContato)>0){
			$oContato 	= $oListaContato[0];
			$cnt_id = $oContato->Id;
			$cnt_nome 	= $oContato->Nome;
			$cnt_email 	= $oContato->Email;
			$cnt_fone 	= $oContato->Fone;
		}//if
	}//if

	$oListaField = FieldBD::getLista("fld_id_cln = ".$_SESSION["sss_usr_id_cln"]." AND fld_status = 'A' AND fld_cadastro > 0","fld_nome");

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
											Dados do Cliente
											<a class="control-arrow" data-toggle="collapse" data-target="#demo1">
												<i class="icon-circle-down2"></i>
											</a>
										</legend>

										<div class="collapse in" id="demo1">

											<div class="form-group">
												<label>Razão Social:</label>
												<input type="text" class="form-control" placeholder="Razão Social" value="<?=$cln_razao_social?>" id="txt_razao_social" name="txt_razao_social" />
											</div>

											<div class="form-group">
												<label>Nome Fantasia:</label>
												<input type="text" class="form-control" placeholder="Nome Fantasia" value="<?=$cln_nome?>" id="txt_nome" name="txt_nome" />
											</div>

											<div class="form-group">
												<label>CNPJ/CPF:</label>
												<input type="text" class="form-control" placeholder="CNPJ/CPF"  value="<?=$cln_cnpj_cpf?>" id="txt_cnpj_cpf" name="txt_cnpj_cpf" >
											</div>

											<div class="form-group">
												<label>Observações:</label>
												<textarea rows="5" cols="5" class="form-control" placeholder="Observações..." id="txt_obs" name="txt_obs"><?=$cln_obs?></textarea>
											</div>

											<div class="form-group">
												<label class="display-block">Status</label>

												<label class="radio-inline">
													<input type="radio" class="styled" name="txt_status" id="txt_status_A" value="A" <?=(($cln_status=="A")?" checked=\"checked\"":"")?>>
													Ativo
												</label>

												<label class="radio-inline">
													<input type="radio" class="styled" name="txt_status"  id="txt_status_I" value="I" <?=(($cln_status!="A")?" checked=\"checked\"":"")?> />
													Inativo
												</label>

											</div>

										</div>
									</fieldset>

									<fieldset>
										<legend class="text-semibold">
											<i class="icon-reading position-left"></i>
											Contato
											<a class="control-arrow" data-toggle="collapse" data-target="#demo2">
												<i class="icon-circle-down2"></i>
											</a>
										</legend>

										<div class="collapse in" id="demo2">
											<input type="hidden" name="hdd_id_cnt" id="hdd_id_cnt" value="<?=$cnt_id?>" />
				                			<div class="form-group">
												<label>Nome:</label>
												<input type="text" class="form-control" placeholder="Nome" value="<?=$cnt_nome?>" id="txt_cnt_nome" name="txt_cnt_nome" />
											</div>

											<div class="form-group">
												<label>E-mail:</label>
												<input type="text" class="form-control" placeholder="E-mail" value="<?=$cnt_email?>" id="txt_cnt_email" name="txt_cnt_email" />
											</div>

											<div class="form-group">
												<label>Telefone:</label>
												<input type="text" class="form-control" placeholder="Telefone" value="<?=$cnt_fone?>" id="txt_cnt_fone" name="txt_cnt_fone" />
											</div>
			                			</div>
									</fieldset>

									<?
									if(count($oListaField)>0){
										?>
										<fieldset>
											<legend class="text-semibold">
												<i class="icon-puzzle2 position-left"></i>
												Outros dados
												<a class="control-arrow" data-toggle="collapse" data-target="#demo3">
													<i class="icon-circle-down2"></i>
												</a>
											</legend>
											<div class="collapse in" id="demo3">
												<?
												foreach($oListaField as $oField){

													$condicao = "fts_id_fld = ".$oField->Id;
													$condicao.= " AND fts_id_cln = ".$cln_id;
													$condicao.= " AND fts_id_wrk = 0";
													$condicao.= " AND fts_id_fse = 0";
													$condicao.= " AND fts_id_tsk = 0";

													$oListaFieldTask = FieldTaskBD::getLista($condicao,"",0,1);

													$tmp_value = (count($oListaFieldTask)>0)?$oListaFieldTask[0]->Resposta:"";

													//switch($oField->Tipo){//I,T,N,D,S,R,C
													//	case "":
													//	break;
													//}//sw
													?>
													<div class="form-group">
														<label><?=$oField->Nome?>:</label>
														<input type="text" class="form-control" placeholder="<?=$oField->Nome?>" value="<?=$tmp_value?>" id="txt_field_<?=$oField->Id?>" name="txt_field_<?=$oField->Id?>" />
													</div>
													<?
												}//foreach
												?>
											</div>
										</fieldset>
										<?
									}//if
									?>



									<div class="text-right">
										<button type="submit" class="btn btn-primary">Salvar <i class="icon-arrow-right14 position-right"></i></button>
									</div>
								</div>
							</div>
						</form>
						<!-- /a legend -->

					</div>