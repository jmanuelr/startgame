<?
	//$cln_id = preg_replace("/[^0-9]/i","", $_SESSION["sss_usr_id_cln"]);
	//if($cln_id=="")$cln_id=0;
	$oListaCliente = ClienteBD::getLista("cln_id_cln = 0","cln_dt_cadastro DESC, cln_hr_cadastro DESC");
	//$pipe_token = $oCliente->PipedriveToken;
	//$oListaPipedrive = PipedriveBD::getLista("ppd_id_cln = ".$cln_id,"ppd_name");


?>
<div class="row">
	<div id="div_retorno" class="col-md-12">
		<div class="panel panel-flat">
			<div class="panel-body">
				<?
				
				?>
				<table class="table">
					<tr>
						<th width="250">Empresa</th>
						<th width="100">Data</th>
						<th>Usuário/Email/Newsletter/Confirmado</th>
						<th>Workflows</th>
					</tr>
					<?
					foreach($oListaCliente as $oCliente){
						$oListaUsuario = UsuarioBD::getLista("usr_id_cln = ".$oCliente->Id);
						$oListaWorkflow = WorkflowBD::getLista("wrk_id_cln = ".$oCliente->Id);
						?>
						<tr>
							<td><strong><?=$oCliente->Nome?></strong></td>
							<td>
								<?=RN::NormalDate($oCliente->DtCadastro)?>
							</td>
							<td>
								<?
								foreach($oListaUsuario as $oUsuario){
									echo "".$oUsuario->Nome." / ".$oUsuario->Email."<br />";
									echo "<span class='text-muted'>Newsletter: ".(($oUsuario->Newsletter=="S")?"Sim":"Não");
									echo " / Email confirmado: ".(($oUsuario->Confirmado==1)?"Sim":"Não");
									echo "</span><br>";
								}//foreach
								?>
							</td>
							<td>
								<?
								if(count($oListaWorkflow)<1){
									echo "<span class='text-muted'>Sem workflows</span>";
								}else{
									foreach($oListaWorkflow as $oWorkflow){
										$oListaFase = FaseBD::getLista("fse_id_wrk = ".$oWorkflow->Id);
										$oListaTask = TaskBD::getLista("tsk_id_wrk = ".$oWorkflow->Id);
										echo "".$oWorkflow->Titulo." <span class='text-muted'>/ <b>".count($oListaFase)."</b> fases / <b>".count($oListaTask)."</b> cards </span><br />";
									}//foreach
								}//if
								?>
							</td>
						</tr>
						<?
					}//foreach
					?>
				</table>
			</div>
		</div>
	</div>

</div>

