<?
	$oListaWorkflow = WorkflowBD::getLista("wrk_id_usr = ".$_SESSION["sss_usr_id"]." AND wrk_status = 'A'");// AND wrk_id = 1


	$dt_now = date("Ymd");
?>
<div class="row">
		<div class="col-lg-12">
			<?
			/*
			if($_REQUEST["dsh"]=="analitico"){
				include(__DIR__."/inc_dash_my_deals.php");
			}elseif($_REQUEST["dsh"]=="todo"){
				include(__DIR__."/inc_dash_todo.php");
			}else{
				include(__DIR__."/inc_dash_my_pipes.php");
			}//if
			*/
			?>
		</div>
</div>