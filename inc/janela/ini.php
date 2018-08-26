<?
	//--------------------------------------------------------------------------
    require_once(__DIR__.'/../../lib/classes/class.janelaBD.php');
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
    $sis_id = preg_replace("[^0-9]","",$_REQUEST["sis"]);
    if($sis_id=="")$sis_id=0;
    $bool_pode_listar = false;
    if($sis_id > 0){
        $oSistema = SistemaBD::get($sis_id);
        if(is_object($oSistema) && $oSistema->_Cliente == $_SESSION["sss_usr_id_cln"]){
            $bool_pode_listar = true;
        }//if
    }//if
    
    //--------------------------------------------------------------------------
    if($obj_act == "lst"){
    	//--------------------------------------------------------------------------
	    include(__DIR__."/../inc_paginacao_ini.php");
	    //--------------------------------------------------------------------------
        $condicao           = "jnl_id_sis = ".$sis_id;

        $txt_search         = trim($_REQUEST["q"]);
        $slc_search_status  = trim($_REQUEST["s"]);

        if($txt_search!=""){

            if($condicao!="")$condicao.=" AND";
            $condicao .= " (";
            $condicao .= " jnl_nome LIKE '%".$txt_search."%'";
            $condicao .= " )";
        }//if
        if($slc_search_status!=""){
            if($condicao!="")$condicao.=" AND";
            $condicao .= " jnl_status = '".$slc_search_status."'";
        }//if
        //--------------------------------------------------------------------------
        $oListaObjetos      = JanelaBD::getLista($condicao, "jnl_ordem, jnl_nome", $inicio, $max);
        $result_count       = count($oListaObjetos);
	    $total_count        = AcessoBanco::getNumOfRows($db_table,$condicao);
        //--------------------------------------------------------------------------

        if(!$bool_pode_listar){
            die("<div>Erro: Sistema não definido.</div>");
        }//if

	}elseif($obj_id > 0){

        $oObjeto = JanelaBD::get($obj_id);

        if( $_SESSION["sss_usr_tipo"]!="A" && $_SESSION["sss_usr_tipo"]!="G" && $oObjeto->Sistema->_Cliente!=$_SESSION["sss_usr_id_cln"]){
            $oObjeto = null;
            $obj_id = 0;
        }else{
            $sis_id = $oObjeto->_Sistema;
        }//if

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