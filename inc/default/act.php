<?
    include(__DIR__."/../key_control.php");

    //$oUsuario = $oObjeto;

	//action
	//ini_set("display_errors","1");

    //include_once('../../lib/includes/header.inc.php');
    //include_once('../../inc/inc_user_check.php');
	//--------------------------------------------------------------------------
    //require_once(dirname(__FILE__).'/../../lib/classes/class.conexaobanco.php');
	//require_once(dirname(__FILE__).'/../../lib/classes/class.menuBD.php');
    //--------------------------------------------------------------------------

    //die("ok: ".$sha1_key.":".$frm_key);

    $acessoBanco        = new AcessoBanco();
    //--------------------------------------------------------------------------
    $id_mnu_action 		= intval($_REQUEST["act"]);
    //--------------------------------------------------------------------------
    $template_default   = $page_default;//($page_template!="")?$page_template:$page_default;
    $from_email         = Config::appSettings("prefixoBD");
    $db_table           = ($db_prefixo!="")?$db_prefixo."_".$template_default:$template_default;
    //--------------------------------------------------------------------------
    $comando            = "SHOW COLUMNS FROM ".$db_table.";";
    $result_campos      = $acessoBanco->selectRegistrobySQL($comando);
    $qnt_campos         = count($result_campos);
    //--------------------------------------------------------------------------

    $comando         = "SELECT * FROM ".$db_table." WHERE ".$result_campos[0][0]." = ".$obj_id;
    $result_objeto   = $acessoBanco->selectRegistrobySQL($comando);

    //--------------------------------------------------------------------------
    $tb_prefixo = "";
    if(count($result_campos)>0){
        $arr_prefixo = explode("_",$result_campos[0][0]);
        if( is_array($arr_prefixo) && (strlen($arr_prefixo[0])==3) ){
            $tb_prefixo = $arr_prefixo[0];
        }//if
    }//if

    //echo "<pre>":
    //print_r($result_campos);
    //echo "</pre>":
    //--------------------------------------------------------------------------
    $sql_query_insert           = "";//INSERT INTO ".$db_table." ";
    $sql_query_insert_fields    = "";
    $sql_query_insert_values    = "";

    $sql_query_update = "";//"UPDATE ".$db_table." SET ";

    $i=0;
    foreach ($result_campos as $chave => $valor) {

        if($i==0){
            $i++;
            continue;
        }//if

        $campo_ori  = $valor[0];
        $campo      = $valor[0];
        $tipo       = $valor[1];

        if($tb_prefixo!=""){
            $campo = str_replace($tb_prefixo."_", "", $campo);
        }//if

        $value = (isset($result_objeto))?trim($result_objeto[0][$chave]):"";

        if($campo=="id"){
            $prefixo_campo = "hdd";
        }else{
            $prefixo_campo = "txt";
        }//if

        if($prefixo_campo!=""){
            $campo = $prefixo_campo."_".$campo;
        }//if

        $value = trim($_REQUEST[$campo]);
        if($i>1){
            $sql_query_update.=", ";
            $sql_query_insert_fields.=", ";
            $sql_query_insert_values.=", ";
        }//if

        if(stripos($tipo, "int(")!==false){
            $value = eregi_replace("[^0-9]","",$value);
            if($value=="")$value = "NULL";
            $sql_query_update.= $campo_ori." = ".$value;

            $sql_query_insert_fields.=$campo_ori;
            $sql_query_insert_values.=$value;
        }else{
            $sql_query_update.= $campo_ori." = '".$value."'";

            $sql_query_insert_fields.=$campo_ori;
            $sql_query_insert_values.="'".$value."'";
        }//if

        $i++;
    }//foreach

    //$sql_query_update.=" WHERE ".$result_campos[0][0]." = ".$obj_id;
    //$sql_query_insert.= " (".$sql_query_insert_fields.") VALUES (".$sql_query_insert_values.")";

    //echo "<br />".$sql_query_update;
    //echo "<br />".$sql_query_insert;

    if($obj_id > 0){
        //$sql_query = $sql_query_update;
        $acessoBanco->updateRegistro($db_table, $sql_query_update, $result_campos[0][0]." = ".$obj_id);
    }else{
        //$sql_query = $sql_query_insert;
        $obj_id = $acessoBanco->insertRegistro($db_table, $sql_query_insert_fields, $sql_query_insert_values);
    }//if

    //header("Location: ../../?mnu=".$id_mnu_action."&msg=1,".$action.",".$obj_id);
    //exit;
?><script>
    top.cancelEdit();
    top.reloadTable();
</script>