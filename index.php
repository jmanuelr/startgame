<?
	require_once(__DIR__."/inc/inc_user_check.php");
	////-----------------------------------------------------------
	//require_once(__DIR__."/lib/includes/header.inc.php");
	////-----------------------------------------------------------
	//require_once(__DIR__."/lib/classes/class.RN.php");
	//require_once(__DIR__."/lib/classes/class.clienteBD.php");
	//require_once(__DIR__."/lib/classes/class.contatoBD.php");
	//require_once(__DIR__."/lib/classes/class.usuarioBD.php");
	//require_once(__DIR__."/lib/classes/class.workflowBD.php");
	//require_once(__DIR__."/lib/classes/class.faseBD.php");
	//require_once(__DIR__."/lib/classes/class.taskBD.php");
	//require_once(__DIR__."/lib/classes/class.task_faseBD.php");
	//require_once(__DIR__."/lib/classes/class.task_questionBD.php");
	//require_once(__DIR__."/lib/classes/class.questionBD.php");
	//require_once(__DIR__."/lib/classes/class.usuarioBD.php");
	//require_once(__DIR__."/lib/classes/class.equipeBD.php");
	//require_once(__DIR__."/lib/classes/class.equipe_usuarioBD.php");
	//require_once(__DIR__."/lib/classes/class.menuBD.php");
	//require_once(__DIR__."/lib/classes/class.formata_string.php");
	//-----------------------------------------------------------
	//$oFormata = new FormataString;
	//-----------------------------------------------------------
	$oLoggedUsuario = UsuarioBD::get($_SESSION["sss_usr_id"]);
	//-----------------------------------------------------------

	$date_ymdhis = date("YmdHis");

	$sys_general = array();
	$sys_general["sys_name"] = "Noobets";

	//$page_tipo = ($_REQUEST["id"]!="")?(isset($_REQUEST["edit"])?"frm":"dtl"):"lst";

	$obj_id = preg_replace("/[^0-9]/i","",$_REQUEST["id"]);
	if($obj_id=="")$obj_id = 0;

	$bool_show_page_header = true;
	$bool_show_footer = true;

	$main_menu = "dashboard";

	$arr_breadcrumb = array();
	//$arr_breadcrumb[] = array("label" => "Home", "link" => "./");

	$arr_js_includes = array();

	/*

	switch($_REQUEST["page"]){
		case "user":
			$page_include = "inc/inc_user_".$page_tipo.".php";
			$main_menu = "user";
			$arr_breadcrumb[] = array("label" => "Usuários", "link" => "./?page=user");
			if($page_tipo=="lst"){
				$arr_breadcrumb[] = array("label" => "List", "link" => "");
			}else{
				$arr_breadcrumb[] = array("label" => "Edit", "link" => "");
			}//if

			$arr_js_includes[] = "user.js";
		break;
		case "customer":
			$page_include = "inc/inc_customer_".$page_tipo.".php";
			$main_menu = "customer";
			$arr_breadcrumb[] = array("label" => "Clientes", "link" => "./?page=customer");
			if($page_tipo=="lst"){
				$arr_breadcrumb[] = array("label" => "List", "link" => "");
			}else{
				$arr_breadcrumb[] = array("label" => "Edit", "link" => "");
			}//if
		break;
		case "team":
			$page_include = "inc/inc_team_".$page_tipo.".php";
			$main_menu = "team";
			$arr_breadcrumb[] = array("label" => "Equipe", "link" => "./?page=team");
			if($page_tipo=="lst"){
				$arr_breadcrumb[] = array("label" => "List", "link" => "");
			}else{
				$arr_breadcrumb[] = array("label" => "Edit", "link" => "");
			}//if
		break;
		case "workflow":
			$arr_breadcrumb[] = array("label" => "Processo", "link" => "./?page=workflow");

			if($page_tipo=="dtl"){
				$bool_show_page_header = false;
				$bool_show_footer = false;
				$arr_breadcrumb[] = array("Processo" => "");
			}elseif($page_tipo=="lst"){
				$arr_breadcrumb[] = array("label" => "List", "link" => "");
			}else{
				$arr_breadcrumb[] = array("label" => "Edit", "link" => "");
			}//if
			$page_include = "inc/inc_workflow_".$page_tipo.".php";
			$main_menu = "workflow";

			$arr_js_includes[] = "workflow.js";

		break;
		default:
			$page_include = "inc/inc_dashboard.php";
		break;
	}//sw
	*/

	$oListaWorkflow = WorkflowBD::getLista("wrk_id_cln = ".$_SESSION["sss_usr_id_cln"]." AND wrk_status = 'A'","wrk_id DESC");

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<? include("inc/inc_head.php"); ?>
</head>

<body>

	<? include("inc/inc_workflow_control.php"); ?>

	<? include("inc/inc_navbar_main.php"); ?>

	<? include("inc/inc_navbar_second.php"); ?>

	<? if($bool_show_page_header)include("inc/inc_page_header.php"); ?>


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<?
				//echo "<pre>";
				//print_r($_SESSION);
				//echo "</pre>";
				?>

				<!-- Page content -->
				<?
				//echo "\$page_template: ".$page_template;
				?>
				<? include($page_template); ?>
				<!-- /page content -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->


	<? include("inc/inc_footer.php"); ?>


</body>
</html>
