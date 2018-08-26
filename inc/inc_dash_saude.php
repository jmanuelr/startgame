<div class="row">
	<div class="col-md-6">
		<div class="panel panel-flat">
			<div class="panel-body">
				<table class="table">
					<tr>
						<th>Nome</th>
						<td><?=$oMainUsuario->Nome?></td>
					</tr>
					<tr>
						<th>Data de Nasc.</th>
						<td><?=RN::NormalDate($oMainUsuario->DtNasc)?></td>
					</tr>
					<tr>
						<th>Email</th>
						<td><?=$oMainUsuario->Email?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-flat">
			<div class="panel-body">
				<?
				$oListaAntropometria = AntropometriaBD::getLista("","ant_nome");

				foreach($oListaAntropometria as $oAntropometria){
					$bool_print_this = false;
					$arr_result[$oAntropometria->Id] = array();
					$oListaExame = ExameBD::getLista("exm_id_usr = ".$_SESSION["sss_usr_id"]." ","exm_dt_registro");
					foreach($oListaExame as $oExame){
						$oListaResultado = ResultadoBD::getLista("rst_id_ant = ".$oAntropometria->Id." AND rst_id_exm = ".$oExame->Id);
						foreach($oListaResultado as $oResultado){
							$bool_print_this = true;
							$arr_result[$oAntropometria->Id][$oExame->DtRegistro] = $oResultado->Valor;
						}//foreach
					}//foreach
					if($bool_print_this){
						?>
							<!-- Basic line chart -->
							<div class="panel panel-flat">
								<div class="panel-heading">
									<h5 class="panel-title"><?=$oAntropometria->Nome?></h5>
									<div class="heading-elements">
										<ul class="icons-list">
					                		<li><a data-action="collapse"></a></li>
					                		<li><a data-action="reload"></a></li>
					                		<li><a data-action="close"></a></li>
					                	</ul>
				                	</div>
								</div>

								<div class="panel-body">
									<div class="chart-container">
										<div class="chart has-fixed-height" id="basic_lines_<?=$oAntropometria->Id?>"></div>
									</div>
								</div>
							</div>
							<!-- /basic line chart -->
						<?
					}//if
				}//foreach
				//echo "<pre>";
				//print_r($arr_result);
				//echo "</pre>";
				?>
				
			</div>
		</div>
	</div>
</div>