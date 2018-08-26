<?
	//ini_set("display_errors","1");
    //include('../../inc/inc_user_check.php');
    //require_once(dirname(__FILE__)."/../../inc/inc_imagens_s3.php");
    //--------------------------------------------------------------------------
    $sha1_key  = sha1($_REQUEST["mnu"]."|".$obj_id."|".$obj_path);//act traz o id mnu, id traz obj_id
    $frm_request_key   = trim($_REQUEST["key"]);
    $hdd_id    = trim(eregi_replace("[^0-9]","",$_REQUEST["hdd_id"]));
    $action    = ($hdd_id > 0)?"edit":"add";

    if($hdd_id != $obj_id)die("ERROR: #48726");
    if($sha1_key!=$frm_request_key)die("ERROR: #48727 (".$sha1_key.":".$frm_request_key.") / ".$_REQUEST["mnu"]."-".$obj_id."-".$obj_path);
    include(__DIR__."/".$obj_path."/ini.php");
    //----------------------------------------------
    $date_ymdhis = date("YmdHis");
    //----------------------------------------------
?>