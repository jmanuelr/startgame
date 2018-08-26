<?
	date_default_timezone_set('America/Sao_Paulo');

	require_once(__DIR__.'/../lib/includes/session.inc.php');
	require_once(__DIR__.'/../lib/classes/class.usuarioBD.php');
	require_once(__DIR__.'/../lib/classes/class.clienteBD.php');
	require_once(__DIR__.'/../lib/classes/class.contatoBD.php');
	require_once(__DIR__.'/../lib/classes/class.workflowBD.php');
	require_once(__DIR__.'/../lib/classes/class.pipedriveBD.php');
	require_once(__DIR__.'/../lib/classes/class.faseBD.php');
	require_once(__DIR__.'/../lib/classes/class.questionBD.php');
	require_once(__DIR__.'/../lib/classes/class.taskBD.php');
	require_once(__DIR__.'/../lib/classes/class.task_faseBD.php');

	//https://api.pipedrive.com/v1/deals/timeline?start_date=2017-10-01&interval=month&amount=3&field_key=won_time&api_token=f746bc7d41e3f0dece7432138d2b308f2aaf2589
	//https://api.pipedrive.com/v1/deals/timeline?start_date=2017-10-01&interval=month&amount=3&field_key=won_time&pipeline_id=3&api_token=f746bc7d41e3f0dece7432138d2b308f2aaf2589

	session::start();

	$dt_now = date("Ymd");

	$dt_ini = ($_REQUEST["ini"]!="")?$_REQUEST["ini"]:date("Y-m-d");
	$dt_fim = ($_REQUEST["fim"]!="")?$_REQUEST["fim"]:date("Y-m-d", mktime(0,0,0,date("n"),date("j")-7,date("Y")));

	//$dt_ini = "2017-11-01";
	//echo "<br />\$dt_ini: ".$dt_ini;
	//echo "<br />\$dt_fim: ".$dt_fim;
	//exit;

	//$cln_id = preg_replace("/[^0-9]/i","", $_SESSION["sss_usr_id_cln"]);
	$cln_id = preg_replace("/[^0-9]/i","", $_REQUEST["cln"]);
	if($cln_id=="")$cln_id=0;

	$wrk_id = preg_replace("/[^0-9]/i","", $_REQUEST["wrk"]);
	if($wrk_id=="")$wrk_id=0;

	if($wrk_id > 0){
		$oWorkflow = WorkflowBD::get($wrk_id);
		if($cln_id == 0)$cln_id = $oWorkflow->_Cliente;
	}//if


	//----------
	function addNewTask($wrk_id, $fse_id, $negocio_id, $negocio_title, $negocio_value, $negocio_status,$negocio_won_time){
		global $dt_now;
		$hash_deal = sha1($wrk_id."|".$negocio_id."|".$negocio_won_time);

		$oListaTask = TaskBD::getLista("tsk_id_wrk = ".$wrk_id." AND tsk_deal_hash = '".$hash_deal."'","tsk_id",0,1);

		if(count($oListaTask)>0)return false;

		//----------------------
	    $condicao_seq = 'tsk_id_wrk = '.$wrk_id;
	    $arr_seq = TaskBD::getCustomLista($condicao_seq, '', 'MAX(tsk_seq) as ordem', '', '', '', '', false);
	    $contador_seq = is_numeric($arr_seq[0]["ordem"])?(intval($arr_seq[0]["ordem"]) + 1):1;
	    //----------------------

		$oTask = new Task;

		$oTask->Task 		= 0;
		$oTask->DtRegistro 	= date("Ymd");

		$oTask->Fase 		= $fse_id;
		$oTask->Workflow 	= $wrk_id;
		$oTask->Cliente 	= 0;
		$oTask->Usuario 	= 0;
		$oTask->Seq 		= $contador_seq;
		$oTask->Titulo 		= $negocio_title;
		$oTask->Descricao 	= "";
		$oTask->Tipo 		= "";
		$oTask->Option 		= "";
		$oTask->Required 	= "N";
		$oTask->Status 		= "A";
		$oTask->DealHash 	= $hash_deal;

		$tsk_id = TaskBD::add($oTask);

		// $arr_retorno = array(
			// "tsk_id" => $tsk_id,
			// "tsk_pai" => "0",
			// "tsk_status" => "A",
			// "tsk_class_alerta" => 'success',
			// "tsk_titulo" => '-',
			// "tsk_cln_nome" => 'Sem título...',
			// "fse_id" => $fse_id,
			// "condicao" => 0,
			// "percentual" => 0
		// );

		//------------------------------------------->>
		    $condicao_seq = "tfs_id_tsk = ".$tsk_id." AND tfs_id_fse = ".$fse_id;
		    $arr_seq = TaskFaseBD::getCustomLista($condicao_seq, '', 'MAX(tfs_seq) as ordem', '', '', '', '', false);
		    $contador_seq = is_numeric($arr_seq[0]["ordem"])?(intval($arr_seq[0]["ordem"]) + 1):1;
		    //----------------------

			$arr_valor = array(
				'tfs_id_tsk'			=> $tsk_id,
				'tfs_id_fse'			=> $fse_id,
				'tfs_seq'				=> $contador_seq,
				'tfs_dt_ini'			=> "'".$dt_now."'",
				'tfs_dt_fim'			=> "''",
				'tfs_dt_dif'			=> 0,
				'tfs_hr_ini'			=> "'".date("H:i")."'",
				'tfs_hr_fim'			=> "''",
				'tfs_id_usr_in'			=> $_SESSION["sss_usr_id"],
				'tfs_id_usr_out'		=> 0
			);

			TaskFaseBD::addCustom($arr_valor);
		//-------------------------------------------<<
	}
	//----------

	function pegaConteudo($dt_ini, $ppd_id, $pipe_token, $tipo = "get"){
		$url_pipedrive = "https://api.pipedrive.com/v1/deals/timeline?start_date=".$dt_ini."&interval=month&amount=1&field_key=won_time&pipeline_id=".$ppd_id."&api_token=".$pipe_token;
		$conteudo_request = "";
		if($ipo=="get"){
			$conteudo_request = file_get_contents($url_pipedrive);
		}else{

		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, $url_pipedrive);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    $conteudo_request = curl_exec($ch);
		    curl_close($ch);

		    //$conteudo_request = json_decode( $conteudo_request, true );
		}//if
		return $conteudo_request;
	}//fnc

	
	function varreWorkflowCliente($cln_id,$pipe_token){
		//$wrk_id = trim($_REQUEST["wrk"]);
		//$wrk_id = preg_replace("/[^0-9]/i","", $wrk_id);
		//if($wrk_id=="")$wrk_id=0;

		$quantidade_importada = 0;

		$condicao_wrk = "wrk_id_cln = ".$cln_id." AND wrk_status = 'A'";
		if($wrk_id > 0)$condicao_wrk.= " AND wrk_id = ".$wrk_id;

		$oListaWorkflow = WorkflowBD::getLista($condicao_wrk, "wrk_id DESC");

		$arr_first_request = array();
		$arr_request = array();

		foreach($oListaWorkflow as $oWorkflow){
			$wrk_id = $oWorkflow->Id;
			$ppd_id = trim($oWorkflow->_Pipedrive);
			$ppd_id = preg_replace("/[^0-9]/i","", $ppd_id);
			if($ppd_id=="")$ppd_id=0;

			if($ppd_id > 0){

				$oListaFase = FaseBD::getLista("fse_id_wrk = ".$oWorkflow->Id." AND fse_status = 'A'","fse_seq",0,1);
				$fse_id = (count($oListaFase)>0)?$oListaFase[0]->Id:0;

				if(isset($arr_first_request[$ppd_id])){
					//--
				}else{
					$conteudo_request = pegaConteudo($dt_ini, $ppd_id, $pipe_token, "curl");
					$arr_first_request[$ppd_id] = json_decode($conteudo_request);
				}//if

				//================================>>
				foreach($arr_first_request as $ppd_id => $arr_deals){
					//echo "<br />*FIRST** ".$ppd_id." (".$wrk_id." - ".$oWorkflow->Titulo.") ***";
					$bool_ok = $arr_deals->success;
					if($bool_ok){
						//echo "<br />qtde: ".$arr_deals->data[0]->totals->count;
						$arr_negocios = $arr_deals->data[0]->deals;

						//echo "<pre>";
						//var_dump($arr_deals->data[0]);
						//echo "</pre>";
						//org_name
						if(is_array($arr_negocios)){
							foreach($arr_negocios as $negocio){
								//echo "<br />".$wrk_id." ) ".$negocio->id." / ".$negocio->title." / ".$negocio->status." / ".$negocio->value."/".$negocio->won_time;
								addNewTask($wrk_id, $fse_id, $negocio->id, $negocio->title, $negocio->value, $negocio->status,$negocio->won_time);
								$quantidade_importada++;
							}//foreach
						}else{
							// if
						}//if
					}//bool_ok
					
				}//foreach
				//================================<<
				
			}//if
			
		}//foreach

		return intval($quantidade_importada);
	}//fnc


	$total_importados = 0;

	$sql_complemento = "";

	if($cln_id > 0){
		$sql_complemento = " AND cln_id = " . $cln_id;
	}//if

	$oListaCliente = ClienteBD::getLista("cln_id_cln = 0 AND cln_status = 'A' AND cln_pipedrive_token != ''".$sql_complemento,"cln_id");

	foreach($oListaCliente as $oCliente){
		$pipe_token = trim($oCliente->PipedriveToken);
		if($pipe_token!=""){
			$este_importados = varreWorkflowCliente($cln_id,$pipe_token);
			$total_importados += $este_importados;
		}//if
	}//foreach

	echo "fim:".$total_importados;

?>