<?
if($_REQUEST["dbdebug"]=="debug"){
	error_reporting(E_ALL);
    ini_set("display_errors", 1);
}//if

date_default_timezone_set('America/Sao_Paulo');

include_once(__DIR__."/../lib/includes/header.inc.php");

require_once(__DIR__."/../lib/includes/inc_vars.php");

require_once(__DIR__."/../lib/includes/functions.php");

require_once(__DIR__."/../lib/classes/class.RN.php");
require_once(__DIR__."/../lib/classes/class.formata_string.php");
require_once(__DIR__."/../lib/classes/class.menuBD.php");

require_once(__DIR__."/../lib/classes/class.configuracaoBD.php");
require_once(__DIR__."/../lib/classes/class.fieldBD.php");
require_once(__DIR__."/../lib/classes/class.field_faseBD.php");
require_once(__DIR__."/../lib/classes/class.field_taskBD.php");

require_once(__DIR__."/../lib/classes/class.templateBD.php");
require_once(__DIR__."/../lib/classes/class.template_faseBD.php");

require_once(__DIR__."/../lib/classes/class.estadoBD.php");
require_once(__DIR__."/../lib/classes/class.logBD.php");

require_once(__DIR__."/../lib/classes/class.clienteBD.php");
require_once(__DIR__."/../lib/classes/class.contatoBD.php");
require_once(__DIR__."/../lib/classes/class.usuarioBD.php");
require_once(__DIR__."/../lib/classes/class.workflowBD.php");
require_once(__DIR__."/../lib/classes/class.faseBD.php");
require_once(__DIR__."/../lib/classes/class.taskBD.php");
require_once(__DIR__."/../lib/classes/class.task_faseBD.php");
require_once(__DIR__."/../lib/classes/class.task_questionBD.php");
require_once(__DIR__."/../lib/classes/class.questionBD.php");
require_once(__DIR__."/../lib/classes/class.equipeBD.php");
require_once(__DIR__."/../lib/classes/class.equipe_usuarioBD.php");

require_once(__DIR__."/../lib/classes/class.pipedriveBD.php");
require_once(__DIR__."/../lib/classes/class.sistemaBD.php");
require_once(__DIR__."/../lib/classes/class.janelaBD.php");
//require_once(__DIR__."/../lib/classes/class.elementoBD.php");

//include_once(__DIR__."/../lib/includes/header.inc.php");

//require_once(__DIR__."/../lib/includes/functions.php");
//require_once(__DIR__."/../lib/classes/class.RN.php");
//require_once(__DIR__."/../lib/classes/class.menuBD.php");
//require_once(__DIR__."/../lib/classes/class.usuarioBD.php");
//require_once(__DIR__."/../lib/classes/class.formata_string.php");
//require_once(__DIR__."/../lib/classes/class.estadoBD.php");
//require_once(__DIR__."/../lib/classes/class.clienteBD.php");
//require_once(__DIR__."/../lib/classes/class.logBD.php");


$oFormata = new FormataString;

$date_ymd 				= date("Ymd");
$date_ymdhis 			= date("YmdHis");
$strUrlSite 			= Config::appSettings("strUrlSite");
//--------------------------------------------
$usr_id 				= trim($_SESSION["sss_usr_id"]);
$usr_nome 				= trim($_SESSION["sss_usr_nome"]);
$usr_email 				= trim($_SESSION["sss_usr_email"]);
$usr_cpf 				= preg_replace("[^0-9]", "", $_SESSION["sss_usr_cpf"]);
$usr_cpf_formatado  	= ($usr_cpf!="")?$oFormata->getCPF($usr_cpf):"";
$usr_tipo 				= trim($_SESSION["sss_usr_tipo"]);
$contexto_id 			= trim($_SESSION["sss_usr_id_cln"]);
$contexto_path 			= str_pad($contexto_id,13,"0",STR_PAD_LEFT);
$contexto_tipo 			= intval($_SESSION["sss_usr_ent_tipo"]);
//--------------------------------------------
//printArray($_SESSION);
if(isset($_REQUEST["mnu"])){
	if(strpos($_REQUEST["mnu"], ",")){
		$arr_tmp_mnu = explode(",",$_REQUEST["mnu"]);
		$_REQUEST["mnu"] = $arr_tmp_mnu[0];
	}//if
}//if
//--------------------------------------------
$bool_save_current_page = false;
$bool_empty_body 		= false;
$bool_usr_logado 		= false;
$bool_breadcrumb 		= false;
$bool_eas_admin 		= false;
//--------------------------------------------
$page_id_mnu			= intval($_REQUEST["mnu"]);

$obj_id 				= preg_replace("/[^0-9]/i","",$_REQUEST["id"]);
if($obj_id=="")$obj_id = 0;

$obj_act 				= trim($_REQUEST["act"]);
$obj_path 				= "default";
//$frm_act 				= is_numeric($_REQUEST["act"])?intval($_REQUEST["act"]):0;
//$arr_menu				= array();
$arr_paginas_permitidas = array();
//--------------------------------------------
$system_name 			= getVariavelConfig("sys_name");
$system_version 		= getVariavelConfig("sys_version");
$system_full_name 		= "";//$system_name." v".$system_version;
if($system_name!="") $system_full_name .= $system_name;
if($system_version!="") $system_full_name .= " v".$system_version;
//$system_full_name 		.= ($contexto_tipo==2)?" [Varejo]":" [Indústria]";
$bool_print 			= false;//relatorios
//----------------------------------------------------------
$page_mnu_title 		= "";
$page_mnu_description 	= "";
$page_mnu_template 		= "";
$page_mnu_include 		= "";
$page_mnu_default 		= "";
$page_mnu_icon 			= "";

$flag_current_page 		= "";
//----------------------------------------------------------
$nivel = 1;
//----------------------------------------------------------
function getMenuRecursivo($raiz,$nivel){

	global $usr_tipo, $bool_eas_admin;

	$arr_menu 		= array();
	$arr_menu_sub 	= array();

	$condicao_extra = " AND mnu_permisso like '%[".$usr_tipo."]%'";

	$oListaMenu 	= MenuBD::getLista("mnu_id_mnu = ".$raiz." AND mnu_status = 'A'".$condicao_extra,"mnu_ordem");//AND mnu_show = 'S'

	foreach($oListaMenu as $oMenu){

		$mnu_id 			= $oMenu->Id;
		$mnu_id_mnu 		= $oMenu->IdMnu;
		$mnu_titulo			= $oMenu->Titulo;
		$mnu_subtitulo		= $oMenu->Subtitulo;
		$mnu_label 			= $oMenu->Label;
		$mnu_default 		= $oMenu->Default;
		$mnu_template		= $oMenu->Template;
		$mnu_include		= $oMenu->Include;
		$mnu_icon			= $oMenu->Icon;
		$mnu_show			= $oMenu->Show;
		$mnu_ordem			= $oMenu->Ordem;


		$oAuxListaMenu = MenuBD::getLista("mnu_id_mnu = ".$mnu_id." AND mnu_status = 'A'".$condicao_extra,"mnu_ordem");// AND mnu_show = 'S'
		$qtde_sub_menu = count($oAuxListaMenu);

		$qtde_sub_menu_visible = 0;
		foreach($oAuxListaMenu as $oAuxMenu){
			if($oAuxMenu->Show == 'S'){
				$qtde_sub_menu_visible++;
			}//if
		}//foreach

		array_push($arr_menu, array(
			'id' 		=> $mnu_id,
			'id_mnu' 	=> $mnu_id_mnu,
			'titulo' 	=> $mnu_titulo,
			'subtitulo' => $mnu_subtitulo,
			'label' 	=> $mnu_label,
			'default' 	=> $mnu_default,
			'template' 	=> $mnu_template,
			'include' 	=> $mnu_include,
			'icon' 		=> $mnu_icon,
			'show' 		=> $mnu_show,
			'ordem' 	=> $mnu_ordem,
			'nivel' 	=> $nivel,
			'qtdesub' 	=> $qtde_sub_menu,
			'qtdesub_show' 	=> $qtde_sub_menu_visible
		));

		if($qtde_sub_menu > 0){
			$arr_menu_sub = getMenuRecursivo($oMenu->Id,($nivel+1));
			foreach($arr_menu_sub as $menu){
				array_push($arr_menu, $menu);
			}//foreach
		}//if

	}//foreach
	return $arr_menu;
}//fnc
//----------------------------------------------------------
//----------------------------------------------------------
function retornaPagina($id_page){
	global $arr_paginas_permitidas, $usr_tipo, $page_mnu_title, $page_mnu_template, $page_mnu_include, $page_mnu_icon, $page_mnu_description, $obj_act, $obj_id, $obj_path;

	if($id_page == 0){
		$page_mnu_title			= "Painel";
		$page_mnu_description	= "";
		$page_mnu_icon 			= "dashboard";
		$page_mnu_include 		= "dashboard.js";
		return array("inc/inc_dashboard.php",$page_mnu_include,"");
	}//if

	if($obj_act!="lst" && $obj_act!="frm" && $obj_act!="act" && $obj_act!="dtl")$obj_act="lst";

	$str_template = "inc/inc_error_forbidden.php";
	$str_include = "";

	foreach($arr_paginas_permitidas as $menu){
		$mnu_id = intval($menu['id']);
		//echo "mnu_id = ".$mnu_id." / ".$id_page;
		if($id_page == $mnu_id){
			//echo "[ok]";
			$str_default 			= trim($menu['default']);
			$str_template 			= trim($menu['template']);
			$str_include 			= trim($menu['include']);

			$page_mnu_default 		= trim($menu['default']);
			$page_mnu_template 		= trim($menu['template']);
			$page_mnu_title 		= trim($menu['titulo']);
			$page_mnu_include 		= trim($menu['include']);
			$page_mnu_description 	= trim($menu['subtitulo']);
			$page_mnu_icon 			= trim($menu['icon']);

			if( ($page_mnu_template!="") && is_file(dirname(__FILE__)."/../inc/geral/".$page_mnu_template) ){
				$str_template 		= "inc/geral/".$page_mnu_template;
				$obj_path = "geral";
			}elseif( ($page_mnu_default!="") && is_file(dirname(__FILE__)."/../inc/".$page_mnu_default."/".$obj_act.".php")){
				$str_template 		= "inc/".$page_mnu_default."/".$obj_act.".php";
				$obj_path = $page_mnu_default;
			}else{
				$str_template 		= "inc/default/".$obj_act.".php";
				//$obj_path = "default";//redundante, ja ta por default.
			}//if

			$page_mnu_template 	= $str_template;

			break;
		}//if
	}//foreach
	return array($str_template,$str_include,$page_mnu_default);
}//fnc
//----------------------------------------------------------
//----------------------------------------------------------
function retornaMenuHtml($id_pai,$id_selected){
	global $arr_paginas_permitidas;

	$html_menu	= "";

	foreach($arr_paginas_permitidas as $menu){

		$class_active   	= "";

		$mnu_id				= intval($menu['id']);
		$mnu_title			= trim($menu['label']);//trim($menu['titulo']);
		$mnu_description	= trim($menu['subtitulo']);
		$mnu_show			= trim($menu['show']);
		$nivel				= intval($menu['nivel']);
		$mnu_template		= trim($menu['template']);
		$mnu_include		= trim($menu['include']);
		$qtde_sub_menu		= intval($menu['qtdesub']);
		$mnu_id_mnu 		= intval($menu['id_mnu']);
		$qtde_sub_menu_show	= intval($menu['qtdesub_show']);

		$mnu_icon 			= (trim($menu['icon'])!="")?"<i class=\"icon-".$menu['icon']." position-left\"></i> ":"";

		$str_mnu_title		= RN::removeAcentos($mnu_title);
		$str_mnu_title		= strtolower($str_mnu_title);
		$str_mnu_title		= preg_replace("/[^0-9a-aA-Z]/i","",$str_mnu_title);

		if($nivel > 2){
        	$tab = "";
        	for($i=0;$i<=($nivel*2);$i++)$tab.="&nbsp;";
			$mnu_title = $tab.$mnu_title;
        }//if

        if($id_selected == $mnu_id){
          $class_active = "active";
        }//if

        /*
        if(verificaPermisso($mnu_id)){
        	$current_link		= "<a href=\"./?mnu=".$mnu_id."&page=".$str_mnu_title."\">
									".$mnu_icon."
									<span class=\"title\">".$mnu_title."</span>
								</a>";
		}else{
			$current_link		= "<a href=\"#\">
									".$mnu_icon."
									<span class=\"title\"><strike>".$mnu_title."</strike></span>
								</a>";
        }//if
        */

        $current_link		= "<a href=\"./?mnu=".$mnu_id."&page=".$str_mnu_title."\">
									".$mnu_icon."
									<span class=\"hidden-md hidden-sm\">".$mnu_title."</span>
								</a>";


        $sub_ul_ini 		= "";
	    $sub_ul_fim 		= "";


	    $li_class_menu_pai = "";


		if($mnu_id_mnu == $id_pai && $mnu_show == "S"){

	        if($qtde_sub_menu_show > 0 ){

	        	//if($mnu_template==""){
	        	//	$current_link = "<a href=\"#\" style=\"cursor:default;\" onclick=\"return false;\">".$mnu_title."</a>";
	        	//}//if

	        	//if($nivel < 2){

	        		$current_link 	= "<a  class=\"".$class_active." dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">".$mnu_icon."<span class=\"hidden-md hidden-sm\">".$mnu_title."</span> <span class=\"caret\"></span></a>";
	        		$sub_ul_ini = "<ul class=\"dropdown-menu width-250\">";

	        		$sub_ul_fim = "</ul>";
	        	//}//if

	        	$li_class_menu_pai = " dropdown";
	        }//if

	        $html_menu .= "<li class=\"".$class_active.$li_class_menu_pai."\">";
	        	$html_menu .= $current_link;
	        	$html_menu .= $sub_ul_ini;
		        	if($qtde_sub_menu_show > 0){
	        			$html_menu .= retornaMenuHtml($mnu_id,$id_selected);
		        	}//if
				$html_menu .= $sub_ul_fim;
	        $html_menu .= "</li>";

		}//if

	}//foreach
	return $html_menu;
}//fnc
//----------------------------------------------------------
function retornaMenuBreadcrumb($id_seed,$arr_paginas_rev){
	global $page_id_mnu;

	$separador = "<i class=\"fa fa-circle\"></i>";

	$html_breadcrumb	= "";

	if($id_seed == 0){

		if($page_id_mnu == $id_seed){
			$html_breadcrumb	= "<li class=\"active\">Home</li>";
		}else{
			$html_breadcrumb	= "<li><a title=\"Home\" href=\"./\">Home</a>".$separador."</li>";
		}

		return $html_breadcrumb;
	}//if


	foreach($arr_paginas_rev as $menu){

		$mnu_id				= intval($menu['id']);
		$mnu_title			= trim($menu['label']);//trim($menu['titulo']);
		$mnu_description	= '';//trim($menu['subtitulo']);
		$mnu_show			= trim($menu['show']);
		$nivel				= intval($menu['nivel']);
		$mnu_template		= trim($menu['template']);
		$mnu_include		= trim($menu['include']);
		$qtde_sub_menu		= intval($menu['qtdesub']);
		$mnu_id_mnu 		= intval($menu['id_mnu']);
		$qtde_sub_menu_show	= intval($menu['qtdesub_show']);

		$str_mnu_title		= RN::removeAcentos($mnu_title);
		$str_mnu_title		= strtolower($str_mnu_title);
		$str_mnu_title		= eregi_replace("[^0-9a-aA-Z]","",$str_mnu_title);

		if($mnu_id == $id_seed){

			if($mnu_id == $page_id_mnu){
				$html_breadcrumb = "<li class=\"active\">".$mnu_title.(($mnu_description!="")?" (".$mnu_description.")":"")."</li>" . $html_breadcrumb;
			}else{

				if($mnu_template!=""){
					$html_breadcrumb = "<li><a title=\"".$mnu_title."\" href=\"./?mnu=".$mnu_id."&page=".$str_mnu_title."\" style=\"cursor:".$cursor.";\">".$mnu_title.(($mnu_description!="")?" (".$mnu_description.")":"")."</a>".$separador."</li>" . $html_breadcrumb;
				}else{
					//$color = "#999999";//#428BCA"; style=\"color:".$color.";\"
					$html_breadcrumb = "<li>".$mnu_title.(($mnu_description!="")?" (".$mnu_description.")":"").$separador."</li>" . $html_breadcrumb;
				}//if

			}//if

			$html_breadcrumb = retornaMenuBreadcrumb($mnu_id_mnu,$arr_paginas_rev) . $html_breadcrumb;
			break;
		}//if

	}//foreach
	return $html_breadcrumb;
}//fnc
//----------------------------------------------------------
//----------------------------------------------------------
function verificaPermisso($id_page){
	global $arr_paginas_permitidas, $usr_tipo;

	if($usr_tipo == "A" || $usr_tipo=="G")return true;

	if($id_page == 0){
		return false;
	}//if
	/*
	if($id_page == 22 || $id_page == 34){
		$oModalidade = ModalidadeBD::get(intval($_SESSION["sss_usr_id_mdl"]));
		if(!is_object($oModalidade) || $oModalidade->CntRel1!="S"){
			return false;
		}//if
	}//if
	*/
	foreach($arr_paginas_permitidas as $menu){
		$mnu_id = intval($menu['id']);
		if($id_page == $mnu_id){
			return true;
			break;
		}//if
	}//foreach
	return false;
}//fnc
//----------------------------------------------------------
//echo "#".$frm_act."#";

//----------------------------------------------------------
$bool_eh_index_action = false;
/*
if($frm_act > 0){
	$bool_passou = false;
	$bool_eh_index_action = true;
	//$arr_paginas_permitidas = getMenuRecursivo(0,1);
	$page_id_mnu = $frm_act;
	//-----------------------
	$arr_paginas_permitidas = getMenuRecursivo(0,1);
	$arr_page_include 		= retornaPagina($page_id_mnu);//,$obj_id,$obj_act
	$page_template 			= $arr_page_include[0];
	$page_include 			= $arr_page_include[1];
	$page_default 			= $arr_page_include[2];
	//-----------------------
	foreach($arr_paginas_permitidas as $menu){
		if($frm_act == intval($menu['id']) ){
			$bool_passou = true;
			break;
		}//if
	}//foreach
	if(!$bool_passou){
		die("Erro #7364 (".$frm_act.")");
	}//if
}else
*/
if( $usr_id!="" && (!isset($_REQUEST["area"])) ){//&& ($usr_tipo != "")
	$bool_usr_logado 		= true;
	$bool_breadcrumb 		= true;
	//echo "##booh##";
	//---->>
	$oMainUsuario = UsuarioBD::get($usr_id);
	switch($oMainUsuario->Tipo){
        case "C":
            //--
        break;
        default:
        	//--
        break;
    }//sw
	//----<<

	//echo "\$page_id_mnu: ".$page_id_mnu;

	$arr_paginas_permitidas = getMenuRecursivo(0,1);
	$arr_page_include 		= retornaPagina($page_id_mnu);//,$obj_id,$obj_act

	//echo "<pre>";
	//print_r($arr_paginas_permitidas);
	//echo "</pre>";


	$page_template 			= $arr_page_include[0];
	$page_include 			= $arr_page_include[1];
	$page_default 			= $arr_page_include[2];


	if($obj_act == "act"){
		include($page_template);
		exit;
	}//if

	$page_mnu_icon 			= (trim($page_mnu_icon)!="")?"<i class=\"icon-".$page_mnu_icon."\"></i> ":"";

	//var_dump($arr_page_include);

	$html_breadcrumb = retornaMenuBreadcrumb($page_id_mnu,array_reverse($arr_paginas_permitidas));

}else{

	if( $usr_id!=""){
		$bool_usr_logado 		= true;
		$bool_breadcrumb 		= true;
		//echo "##booh##";
		//---->>
		$oMainUsuario = UsuarioBD::get($usr_id);
		switch($oMainUsuario->Tipo){
	        case "C":
	            //--
	        break;
	        default:
	        	//--
	        break;
	    }//sw
		//----<<

		$arr_paginas_permitidas = getMenuRecursivo(0,1);
		$arr_page_include 		= retornaPagina($page_id_mnu);//,$obj_id,$obj_act

		//echo "<pre>";
		//print_r($arr_page_include);
		//echo "</pre>";

		$page_template 			= $arr_page_include[0];
		$page_include 			= $arr_page_include[1];
		$page_default 			= $arr_page_include[2];

		$page_mnu_icon 			= (trim($page_mnu_icon)!="")?"<i class=\"fa fa-".$page_mnu_icon."\"></i> ":"";

		//var_dump($arr_page_include);

		$html_breadcrumb = retornaMenuBreadcrumb($page_id_mnu,array_reverse($arr_paginas_permitidas));

	}//if

	$bool_empty_body = true;


	if($_REQUEST["area"]=="esqueci_minha_senha"){
		/*
		//----------
		$flag_current_page 		= "esqueci";
		//$page_include 			= "inc_esqueci_minha_senha.php";
		$page_template 			= "inc_esqueci_minha_senha.php";
		$page_mnu_include 		= "esqueci_senha.js";
		$page_mnu_title			= "Esqueci Senha";
		$page_mnu_description	= "Descrição";
		//-----------
		*/
	}elseif($_REQUEST["area"] == "esqueci_minha_senha_confirmacao"){
		$flag_current_page 		= "esqueci";
		//$page_include 		= "inc_esqueci_minha_senha_confirmacao.php";
		$page_template 			= "inc/inc_esqueci_senha_confirma.php";
		$page_mnu_include 		= "esqueci_senha.js";
		$page_mnu_title			= "Esqueci Senha";
		$page_mnu_description	= "Descrição";
		//-----------
	}elseif($_REQUEST["area"] == "cadastro"){

		//$flag_current_page 		= "cadastro";
		////$page_include 		= "";
		//$page_template 			= "inc_cadastro.php";
		//$page_mnu_include 		= "cadastro.js";
		//$page_mnu_title			= "Cadastro";
		//$page_mnu_description	= "Realize seu cadastro";
		//-----------
	}elseif($_REQUEST["area"] == "termos"){

		//$flag_current_page 		= "faq";
		////$page_include 		= "";
		//$page_template 			= "inc/geral/inc_termos.php";
		//$page_mnu_include 		= "";
		//$page_mnu_title			= "Termos de Uso";
		//$page_mnu_description	= "";
		//-----------
	}//if
}//if


//----------------------------------------------------------
//echo "($page_id_mnu,".$html_breadcrumb.")";
//----------------------------------------------------------
if($obj_act=="lst")$bool_save_current_page = true;

if($bool_save_current_page && !$bool_eh_index_action){
	//--------------------------------------------------------------- // chamar a sessao para a pagina falhar caso seja chamada fora de contexto. senao, usar o verifica permissao
	$sss_current_page = "./".basename($_SERVER['PHP_SELF'])."?".$_SERVER['QUERY_STRING'];
	$sss_current_page = eregi_replace("\&(lng|msg)\=[0-9]*","",$sss_current_page);
	session::save("sss_current_page", $sss_current_page);
	//---------------------------------------------------------------
}//if
//
//printArray($_SESSION);
//echo "<pre>";
//print_r($_SESSION);
//echo "</pre>";
/*
//echo "<pre>";
//print_r($arr_paginas_permitidas);
//echo "</pre>";
foreach($arr_paginas_permitidas as $menu){
	$nivel 	= intval($menu[4]) * 4;
	$tab 	= str_pad("____",$nivel,"____");
	echo "<br />".$tab." (".$menu[0].") ".$menu[1];
}
*/
//============================================================
?>