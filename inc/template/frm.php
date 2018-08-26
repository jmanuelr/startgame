<?

	include(__DIR__."/ini.php");

	$tmp_id = $obj_id;


	if(is_object($oObjeto)){
		$oTemplate = $oObjeto;

		if($_SESSION["sss_tmp_tipo"]=="A" || $_SESSION["sss_tmp_tipo"]=="G" || $oTemplate->_Cliente == $_SESSION["sss_usr_id_cln"]){
			//--

		}else{
			//falhar!
			$oTemplate = null;
		}//if

		$tmp_id_cln                 = $oTemplate->_Cliente;

		$tmp_titulo                 = $oTemplate->Titulo;
		$tmp_descricao            	= $oTemplate->Descricao;
		$tmp_conteudo            	= $oTemplate->Conteudo;
		$tmp_status                 = $oTemplate->Status;

	}else{
		//--------------------------------
		$tmp_id = 0;
		$tmp_id_cln                  = 0;
		$tmp_titulo                  = "";
		$tmp_descricao 				 = "";
		$tmp_conteudo            	 = "";
		$tmp_status                  = "A";
		//--------------------------------
	}//if



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
											Dados do Email
											<a class="control-arrow" data-toggle="collapse" data-target="#demo1">
												<i class="icon-circle-down2"></i>
											</a>
										</legend>

										<div class="collapse in" id="demo1">

											<div class="form-group">
												<label>Titulo:</label>
												<input type="text" class="form-control" placeholder="Título" value="<?=$tmp_titulo?>" id="txt_titulo" name="txt_titulo" maxlength="150" />
											</div>

											<div class="form-group">
												<label>Descrição:</label>
												<textarea class="form-control" placeholder="Descrição" id="txt_descricao" name="txt_descricao" maxlength="150"><?=$tmp_descricao?></textarea>
												<br clear="all" />
											</div>

											<div class="form-group">
												<label>Conteúdo:</label>
												<textarea class="form-control ysihtml5 wysihtml5-default" cols="18" rows="18" placeholder="Conteúdo" id="txt_conteudo" name="txt_conteudo"><?=$tmp_conteudo?></textarea>
											</div>

											<div class="form-group">
												<label class="display-block">Status</label>

												<label class="radio-inline">
													<input type="radio" class="styled" name="txt_status" id="txt_status_A" value="A" <?=(($tmp_status=="A")?" checked=\"checked\"":"")?> />
													Ativo
												</label>

												<label class="radio-inline">
													<input type="radio" class="styled" name="txt_status"  id="txt_status_I" value="I" <?=(($tmp_status!="A")?" checked=\"checked\"":"")?> />
													Inativo
												</label>

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
<div class="col-md-6">
	<div class="panel panel-flat">

		<div class="panel-body">

			<p>Campos dinâmicos disponíveis para template de e-mail.</p>

			<table class="table">
				<tr>
					<th>Dado</th>
					<th>Palavra-chave</th>
				</tr>
				<tr>
					<td>Nome Fantasia do Cliente</td>
					<td><strong>[CLIENTE_NOME_FANTASIA]</strong></td>
				</tr>
				<tr>
					<td>Razão Social do Cliente</td>
					<td><strong>[CLIENTE_RAZAO_SOCIAL]</strong></td>
				</tr>
				<tr>
					<td>CNPJ do Cliente</td>
					<td><strong>[CLIENTE_CNPJ]</strong></td>
				</tr>
				<tr>
					<td>Nome do Contato no Cliente</td>
					<td><strong>[CONTATO_NOME]</strong></td>
				</tr>
				<tr>
					<td>Email do Contato no Cliente</td>
					<td><strong>[CONTATO_EMAIL]</strong></td>
				</tr>
				<tr>
					<td>Nome do Responsável pela Tarefa</td>
					<td><strong>[USUARIO_NOME]</strong></td>
				</tr>
				<tr>
					<td>Email do Responsável pela Tarefa</td>
					<td><strong>[USUARIO_EMAIL]</strong></td>
				</tr>

				<tr>
					<td>Equipe Responsável pela Tarefa</td>
					<td><strong>[EQUIPE_NOME]</strong></td>
				</tr>
				<tr>
					<td>Título da Fase </td>
					<td><strong>[FASE_TITULO]</strong></td>
				</tr>
				<tr>
					<td>Descrição da Fase</td>
					<td><strong>[FASE_DESCRICAO]</strong></td>
				</tr>
				<tr>
					<td>Título do Negócio (Deal)</td>
					<td><strong>[DEAL_TITULO]</strong></td>
				</tr>
				<tr>
					<td>Descrição do Negócio (Deal)</td>
					<td><strong>[DEAL_DESCRICAO]</strong></td>
				</tr>
			</table>

		</div>
	</div>
</div>