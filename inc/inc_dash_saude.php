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

				?>
				<!-- Basic line chart -->
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h5 class="panel-title">Basic line</h5>
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
							<div class="chart has-fixed-height" id="basic_lines"></div>
						</div>
					</div>
				</div>
				<!-- /basic line chart -->
			</div>
		</div>
	</div>
</div>