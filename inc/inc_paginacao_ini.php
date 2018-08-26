<?
//------------------------------------------------------------------- cfg paginacao -->>
$pagina = is_numeric($_REQUEST["p"])?$_REQUEST["p"]:1;
if($pagina < 1)$pagina = 1;
$max=10;//intval($_REQUEST["length"]);//10;
$pag_qtde_show = 4;
$total = 0;
$inicio = $pagina - 1;
$inicio = intval($_REQUEST["start"]);//$max * $inicio;
$limite_intervalo = $inicio + $max;
//----
$link_paginacao = "./?".$_SERVER['QUERY_STRING'];//basename($_SERVER['PHP_SELF']).
$link_paginacao = eregi_replace("(\&p\=)[0-9]*","&p=§",$link_paginacao);
if(strpos($link_paginacao,"§")===false)$link_paginacao.="&p=§";
$link_paginacao = eregi_replace("(\&id\=)[0-9]*","",$link_paginacao);
$link_paginacao = eregi_replace("\&(lng)\=[0-9]*","",$link_paginacao);
$link_paginacao = eregi_replace("\&(msg)\=[0-9a-zA-Z,]*","",$link_paginacao);
//------------------------------------------------------------------- cfg paginacao --<<
?>