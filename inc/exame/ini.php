<?
	//--------------------------------------------------------------------------
    require_once(__DIR__.'/../../lib/classes/class.exameBD.php');
    require_once(__DIR__.'/../../lib/classes/class.resultadoBD.php');
    //--------------------------------------------------------------------------
    $acessoBanco        = new AcessoBanco();
    //--------------------------------------------------------------------------
    $template_default   = $page_default;//($page_template!="")?$page_template:$page_default;
    $db_prefixo         = Config::appSettings("prefixoBD");
    $db_table           = ($db_prefixo!="")?$db_prefixo."_".$template_default:$template_default;
    //--------------------------------------------------------------------------
    $comando            = "SHOW COLUMNS FROM ".$db_table.";";
    $result_campos      = $acessoBanco->selectRegistrobySQL($comando);
    $qnt_campos         = count($result_campos);
    //--------------------------------------------------------------------------
    if($obj_act == "lst"){
    	//--------------------------------------------------------------------------
	    include(__DIR__."/../inc_paginacao_ini.php");
	    //--------------------------------------------------------------------------
        $condicao           = "exm_id_usr = ".$_SESSION["sss_usr_id"];

        $txt_search         = trim($_REQUEST["q"]);
        $slc_search_status  = trim($_REQUEST["s"]);

        if($txt_search!=""){

            if($condicao!="")$condicao.=" AND";
            $condicao .= " (";
            $condicao .= " exm_nome LIKE '%".$txt_search."%'";
            $condicao .= " )";
        }//if
        if($slc_search_status!=""){
            if($condicao!="")$condicao.=" AND";
            $condicao .= " exm_status = '".$slc_search_status."'";
        }//if
        //--------------------------------------------------------------------------
        $oListaObjetos      = ExameBD::getLista($condicao, "exm_nome", $inicio, $max);
        $result_count       = count($oListaObjetos);
	    $total_count        = AcessoBanco::getNumOfRows($db_table,$condicao);
        //--------------------------------------------------------------------------

	}elseif($obj_id > 0){

        $oObjeto = ExameBD::get($obj_id);        

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