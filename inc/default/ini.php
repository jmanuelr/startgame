<?
    if($_REQUEST["ajax"]=="on" || $_REQUEST["act"]=="act"){
        include_once(__DIR__."/../inc_user_check.php");
    }else{
        //if($_SESSION["sss_usr_id"])
    }//if
	//--------------------------------------------------------------------------
    require_once(__DIR__.'/../../lib/classes/class.acessobanco.php');
    require_once(__DIR__.'/../../lib/classes/class.conexaobanco.php');
    //--------------------------------------------------------------------------
    $acessoBanco        = new AcessoBanco();
    $bool_include_all   = true;
    //echo "\$page_default: ".$page_default;
    //--------------------------------------------------------------------------
    $template_default   = $page_default;//($page_template!="")?$page_template:$page_default;
    $db_prefixo         = Config::appSettings("prefixoBD");
    $db_table           = ($db_prefixo!="")?$db_prefixo."_".$template_default:$template_default;
    //--------------------------------------------------------------------------
    $comando            = "SHOW TABLES LIKE '".$db_table."';";
    //echo "\$comando: ".$comando;
    $result_campos      = $acessoBanco->selectRegistrobySQL($comando);
    $qnt_campos         = count($result_campos);

    if($qnt_campos < 1){
        echo "---".$comando." / ".$qnt_campos;
        $bool_include_all   = false;
        return;
    }//if

    $comando            = "SHOW COLUMNS FROM ".$db_table.";";
    $result_campos      = $acessoBanco->selectRegistrobySQL($comando);
    $qnt_campos         = count($result_campos);
    //--------------------------------------------------------------------------
    if($obj_act == "lst"){
    	//--------------------------------------------------------------------------
	    include(dirname(__FILE__)."/../inc_paginacao_ini.php");
	    //--------------------------------------------------------------------------
        if(intval($_REQUEST["length"])>0){
            if($_REQUEST["search"]["value"]!=""){
            //    $db_table .= " WHERE cdd_nome like '%".$_REQUEST["search"]["value"]."%'";
            }//if

            /*
                order[0][column]    3
                order[0][dir]   asc

                columns[3][data]    3
                columns[3][name]
                columns[3][searchable]  true
                columns[3][orderable]   true
                columns[3][search][value]
                columns[3][search][regex]   false
                */

            $comando            = "SELECT * FROM ".$db_table." LIMIT ".intval($_REQUEST["start"]).",".intval($_REQUEST["length"]);
        }else{
            $comando            = "SELECT * FROM ".$db_table." LIMIT ".$inicio.",".$max;
        }//if

	    $result_registros   = $acessoBanco->selectRegistrobySQL($comando);
	    $result_count       = count($result_registros);
	    //--------------------------------------------------------------------------
	    //$condicao         = "SELECT COUNT(*) FROM ".$db_table."";
	    $total_count        = AcessoBanco::getNumOfRows($db_table,"");
	}elseif($obj_id > 0){
		$comando         = "SELECT * FROM ".$db_table." WHERE ".$result_campos[0][0]." = ".$obj_id;
	    $result_objeto   = $acessoBanco->selectRegistrobySQL($comando);
        //echo "\$comando: ".$comando;
    }//if
    //--------------------------------------------------------------------------
    $frm_key = sha1($_REQUEST["mnu"]."|".intval($_REQUEST["id"])."|".$obj_path);
    //--------------------------------------------------------------------------
    $tb_prefixo = "";
    if(count($result_campos)>0){
        $arr_prefixo = explode("_",$result_campos[0][0]);
        if( is_array($arr_prefixo) && (strlen($arr_prefixo[0])==3) ){
            $tb_prefixo = $arr_prefixo[0];
        }//if
    }//if
    //--------------------------------------------------------------------------
?>