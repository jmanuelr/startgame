<?
	require_once(__DIR__.'/../lib/includes/session.inc.php');

	require_once(__DIR__."/../lib/classes/class.RN.php");
	require_once(__DIR__."/../lib/classes/class.antropometriaBD.php");

	session::start();

	$condicao_filtro = "";

	$search = trim($_REQUEST["q"]);
	if( strlen( $search ) > 2 ){
		$condicao_filtro.= " AND ( ";
			$condicao_filtro.= " ant_nome like '%".$search."%'";
			$condicao_filtro.= " OR ant_descricao like '%".$search."%'";
		$condicao_filtro.= " )";

	}else{
		echo "[]";
		exit;
	}//if

	$oListaAntropometria = AntropometriaBD::getLista("ant_status = 'A'".$condicao_filtro);

	$arr_retorno = array();

	foreach($oListaAntropometria as $oAntropometria){
		$arr_antropometria = array(
			"ant_id" 		=> $oAntropometria->Id,
			"ant_status" 	=> "'".$oAntropometria->Status."'",
			"ant_class_alerta" => 'primary',
			"ant_nome" 		=> $oAntropometria->Nome,
			"ant_descricao" 	=> trim($oAntropometria->Descricao)
		);

		$arr_retorno[] = $arr_antropometria;

	}//foreach



	echo json_encode($arr_retorno);

?>