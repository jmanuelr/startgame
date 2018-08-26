<?

?>
<!-- Second navbar -->
	<div class="navbar navbar-default" id="navbar-second">
		<ul class="nav navbar-nav no-border visible-xs-block">
			<li><a class="text-center collapsed" data-toggle="collapse" data-target="#navbar-second-toggle"><i class="icon-menu7"></i></a></li>
		</ul>

		<div class="navbar-collapse collapse" id="navbar-second-toggle">

				<ul class="nav navbar-nav">

					<li class="<?=(($page_id_mnu==0)?"active":"")?>"><a href="./"><i class="icon-display4 position-left"></i> <span class="hidden-md hidden-sm">Dashboard</span></a></li>

					<li class="<?=(($page_id_mnu==8)?"active":"")?>"><a href="./?mnu=8"><i class="icon-list position-left"></i> <span class="hidden-md hidden-sm">Exames</span></a></li>

					<? /* ?>

					<li class="<?=(($main_menu=="dashboard")?"active":"")?> dropdown">
						<a href="./?mnu=2&page=workflow" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-display4 position-left"></i> <span class="hidden-md hidden-sm">Dashboard</span> <span class="caret"></span>
						</a>
						<ul class="dropdown-menu width-200">
							<li><a href="./?dsh=analitico"><i class="icon-display4"></i> Analítico</a></li>
						<li><a href="./?dsh=gestao"><i class="icon-display4"></i> Gestão</a></li>
						</ul>
					</li>

					<li class="<?=(($main_menu=="workflow")?"active":"")?> dropdown">
						<a href="./?mnu=2&page=workflow" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-strategy position-left"></i> <span class="hidden-md hidden-sm"><?=$str_titulo_workflow?></span> <span class="caret"></span>
						</a>
						<ul class="dropdown-menu width-200">
							<?
							if(count($oListaWorkflow)==0){
								?>
								<li class="dropdown-header">Sem Pipelines</li>
								<?
							}//if
							foreach($oListaWorkflow as $oWorkflow){
								?>
								<li><a href="./?mnu=2&page=workflow&act=dtl&id=<?=$oWorkflow->Id?>"><i class="icon-strategy"></i> <?=$oWorkflow->Titulo?></a></li>
								<?
							}//foreach
							?>
						</ul>
					</li>

					<li class="<?=(($main_menu=="todo")?"active":"")?>"><a href="./?dsh=todo"><i class="icon-list position-left"></i> <span id="spn_todo_label" class="hidden-md hidden-sm">ToDo (<?=$int_val_task_todo?>)</span></a></li>

					<? */ ?>

					
					<? /* <li class="<?=(($main_menu=="reports")?"active":"")?>"><a href="#"><i class="icon-statistics position-left"></i> <span class="hidden-md hidden-sm">Reports</span></a></li> */ ?>

				</ul>

			<?
			//if($_SESSION["sss_usr_tipo"] == ){
			//}//if

			?>


				<ul class="nav navbar-nav navbar-right">
					<? /* ?>
					<li>
						<a href="changelog.html">
							<i class="icon-history position-left"></i>
							Changelog
							<span class="label label-inline position-right bg-success-400">1.5</span>
						</a>
					</li>
					<? */ ?>

					<? //if($_SESSION["sss_usr_tipo"]=="A"){ ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="icon-cog3"></i>
								<span class="visible-xs-inline-block position-right">Configurações</span>
							<span class="caret"></span>
							</a>

							<ul class="dropdown-menu dropdown-menu-right">
								<li class="<?=(($page_id_mnu==9)?"active":"")?>"><a href="./?mnu=9&page=antrometria"><i class="icon-heart5 position-left"></i> Antropometria</a></li>
								<? /* ?>
								<li class="<?=(($page_id_mnu==2)?"active":"")?>"><a href="./?mnu=2&page=workflow"><i class="icon-strategy position-left"></i> Pipelines</a></li>
								<li class="<?=(($page_id_mnu==3)?"active":"")?>"><a href="./?mnu=3&page=customer"><i class="icon-folder-open position-left"></i> Clientes</a></li>
								<li class="<?=(($page_id_mnu==4)?"active":"")?>"><a href="./?mnu=4&page=user"><i class="icon-users2 position-left"></i> Usuários</a></li>
								<li class="<?=(($page_id_mnu==5)?"active":"")?>"><a href="./?mnu=5&page=team"><i class="icon-users4 position-left"></i> Equipes</a></li>
								<li class="<?=(($page_id_mnu==7)?"active":"")?>"><a href="./?mnu=7&page=field"><i class="icon-pencil5 position-left"></i> Campos Customizados</a></li>
								<li class="<?=(($page_id_mnu==8)?"active":"")?>"><a href="./?mnu=8&page=emails"><i class="icon-envelop3 position-left"></i> E-mails</a></li>
								<li class="<?=(($page_id_mnu==9)?"active":"")?>"><a href="./?mnu=9&page=pipedrive"><i class="icon-strategy position-left"></i> Pipedrive</a></li>
								<li class="<?=(($page_id_mnu==10)?"active":"")?>"><a href="./?mnu=10&page=sistemas"><i class="icon-terminal position-left"></i> Sistemas</a></li>
								<? if($_SESSION["sss_usr_tipo"]=="A"){ ?>
									<li class="<?=(($page_id_mnu==12)?"active":"")?>"><a href="./?mnu=12&page=controle"><i class="icon-eye4 position-left"></i> Controle</a></li>
								<? } ?>
								<? */ ?>
							</ul>
						</li>
					<? //} ?>
					
				</ul>

				<?
				if($bool_is_workflow){
					/*
					?>
					<a href="#" class="btn btn-labeled btn-warning btnNavSecond pull-right" data-toggle="modal" data-target="#modal_remote" tsk="0"><b><i class="icon-plus-circle2"></i></b>Adicionar Negócio</a>
					<?
					*/
				}//if
				?>



		</div>
	</div>
	<!-- /second navbar -->