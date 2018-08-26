<?
	require_once(__DIR__.'/../lib/includes/session.inc.php');
	require_once(__DIR__.'/../lib/classes/class.usuarioBD.php');
	require_once(__DIR__.'/../lib/classes/class.clienteBD.php');
	require_once(__DIR__.'/../lib/classes/class.faseBD.php');
	//----------------------------------------------------------
	session::start();
	//echo "<pre>";
	//print_r($_REQUEST);
	//echo "</pre>";
	//----------------------------------------------------------
	$fse_id 	= intval($_REQUEST["qual"]);
	$fse_id 	= preg_replace("/[^0-9]/i", "", $_REQUEST["hdd_id_fse_".$fse_id]);
	if($fse_id==""){
		?>
		<script>
			alert('Error #1: code incorrect.');
		</script>
		<?
		exit;
	}//if

	$wrk_id 	= preg_replace("/[^0-9]/i", "", $_REQUEST["hdd_id_wrk_".$fse_id]);

	if($wrk_id==""){
		?>
		<script>
			alert('Error #2: code incorrect.');
		</script>
		<?
		exit;
	}//if

	//----------------------------------------------------------
	$txt_titulo 	= trim($_REQUEST["txt_titulo_fse_".$fse_id]);
	$txt_descricao 	= trim($_REQUEST["txt_descricao_fse_".$fse_id]);
	$txt_risco 		= trim($_REQUEST["txt_risco_fse_".$fse_id]);
	//----------------------------------------------------------
	
	if($fse_id > 0){
		$oFase = FaseBD::get($fse_id);
		$bool_fse_nova = false;
	}else{
		$bool_fse_nova 	= true;

		$oFase = new Fase;
		$oFase->Workflow = $wrk_id;
		//----------------------
        $condicao_seq = 'fse_id_wrk = '.$wrk_id;
        $arr_seq = FaseBD::getCustomLista($condicao_seq, '', 'MAX(fse_seq) as ordem', '', '', '', '', false);
        $contador_seq = is_numeric($arr_seq[0]["ordem"])?(intval($arr_seq[0]["ordem"]) + 1):1;
        //----------------------
		$oFase->Seq 	= $contador_seq;

	}//if

	$oFase->Titulo 		= $txt_titulo;
	$oFase->Descricao 	= $txt_descricao;
	$oFase->Risco 		= $txt_risco;
	$oFase->Status		= "A";

	if($bool_fse_nova){
		$fse_id = FaseBD::add($oFase);
		$mensagem = "Phase added!";
		?>
		<script>
			top.location.href = '../?page=workflow&id=<?=$wrk_id?>&edit=ok';
		</script>
		<?
	}else{
		FaseBD::alter($oFase);
		$mensagem = "Phase Updated!";
			?>
		<script>
			alert('<?=$mensagem?>');
		</script>
		<?
	}//if
	//-----------------------------------------------------------------------------------[ END ]
?>