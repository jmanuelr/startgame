<?
	require_once(__DIR__.'/../lib/classes/class.cidade_ibgeBD.php');
	
	$uf = strtoupper(preg_replace("/[^a-zA-Z]/i","",$_REQUEST['uf']));

	$oListaCidade  = CidadeIbgeBD::getLista( "cdd_uf='".$uf."'", "cdd_nome");

	$arr_obj_json = array();

	foreach ($oListaCidade as $oCidade){
		$arr_obj_json[] = array("id" => $oCidade->Id, "text" => $oCidade->Nome);
	}//foreach

	echo json_encode($arr_obj_json);
?>