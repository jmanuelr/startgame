<?
if(count($arr_breadcrumb)>0){
?>
<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<?

				if($menu_main=="dashboard"){
					$usr_nome = $_SESSION["sss_usr_nome"];
					if(strpos($usr_nome, " ")!==false){
						$usr_nome = trim(substr($usr_nome, 0, strpos($usr_nome, " ")));
					}//if
					/*
					?>
					<h4>
						<i class="icon-arrow-left52 position-left"></i>
						<span class="text-semibold">Home</span> - Dashboard
						<small class="display-block">Hi, <?=$usr_nome?>!</small>
					</h4>
					<?
					*/
				}elseif(count($arr_breadcrumb)>0){
					?>
					<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold"><?=$arr_breadcrumb[count($arr_breadcrumb)-2]["label"]?></span> - <?=$arr_breadcrumb[count($arr_breadcrumb)-1]["label"]?></h4>

					<ul class="breadcrumb breadcrumb-caret position-right">
						<?
						$contador = 0;
						foreach($arr_breadcrumb as $key => $breadcrumb){
							$contador++;
							$label 	= $breadcrumb["label"];
							$link 	= $breadcrumb["link"];
							$class_active = (count($arr_breadcrumb)==$contador)?"active":"";
							if($link!="")$label = "<a href=\"".$link."\">".$label."</a>";
							?>
							<li class="<?=$class_active?>"><?=$label?></li>
							<?
						}//foreach
						?>
					</ul>
					<?
				}//if
				?>
			</div>
			<? /*
			<div class="heading-elements">
				<div class="heading-btn-group">
					<a href="#" class="btn btn-link btn-float has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
					<a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>
				</div>
			</div>
			*/ ?>
		</div>
	</div>
	<!-- /page header -->
	<?
}//if
	?>