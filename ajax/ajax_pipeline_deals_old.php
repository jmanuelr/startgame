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

	//https://api.pipedrive.com/v1/deals/timeline?start_date=2017-10-01&interval=month&amount=3&field_key=won_time&api_token=f746bc7d41e3f0dece7432138d2b308f2aaf2589
	//https://api.pipedrive.com/v1/deals/timeline?start_date=2017-10-01&interval=month&amount=3&field_key=won_time&pipeline_id=3&api_token=f746bc7d41e3f0dece7432138d2b308f2aaf2589




	session::start();

	$dt_now = date("Ymd");

	$dt_ini = ($_REQUEST["ini"]!="")?$_REQUEST["ini"]:date("Y-m-d");
	$dt_fim = ($_REQUEST["fim"]!="")?$_REQUEST["fim"]:date("Y-m-d", mktime(0,0,0,date("n"),date("j")-7,date("Y")));

	//echo "<br />\$dt_ini: ".$dt_ini;
	//echo "<br />\$dt_fim: ".$dt_fim;
	//exit;

	//$cln_id = preg_replace("/[^0-9]/i","", $_SESSION["sss_usr_id_cln"]);
	$cln_id = preg_replace("/[^0-9]/i","", $_REQUEST["cln"]);
	if($cln_id=="")$cln_id=0;

	$wrk_id = preg_replace("/[^0-9]/i","", $_REQUEST["wrk"]);
	if($wrk_id=="")$wrk_id=0;

	if($cln_id==0){
		die("erro: sem dados");
	}//if

	$oCliente = ClienteBD::get($cln_id);
	$pipe_token = trim($oCliente->PipedriveToken);

	if($pipe_token==""){
		die("Erro: sem token");
	}

	

	//----------
	function addNewTask($wrk_id){
		global $dt_now;
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
		$oTask->Titulo 		= "";
		$oTask->Descricao 	= "";
		$oTask->Tipo 		= "";
		$oTask->Option 		= "";
		$oTask->Required 	= "N";
		$oTask->Status 		= "A";

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

	

	//$wrk_id = trim($_REQUEST["wrk"]);
	//$wrk_id = preg_replace("/[^0-9]/i","", $wrk_id);
	//if($wrk_id=="")$wrk_id=0;

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

			if(isset($arr_first_request[$ppd_id])){
				//--
			}else{
				//https://api.pipedrive.com/v1/pipelines/3/movement_statistics?start_date=2017-01-01&end_date=2018-02-07&api_token=f746bc7d41e3f0dece7432138d2b308f2aaf2589
				$url_pipedrive = "https://api.pipedrive.com/v1/pipelines/".$ppd_id."/movement_statistics?start_date=".$dt_ini."&end_date=".$dt_fim."&api_token=".$pipe_token;
				$conteudo_request = file_get_contents($url_pipedrive);
				$arr_first_request[$ppd_id] = json_decode($conteudo_request);
			}//if

			//================================>>
			foreach($arr_first_request as $ppd_id => $arr_deals){
				echo "<br />*FIRST** ".$ppd_id." ***";
				$bool_ok = $arr_deals->success;
				$arr_negocios = $arr_deals->data;
				if(is_array($arr_negocios)){
					foreach($arr_negocios as $negocio){
						echo "<br />".$negocio->won_deals->deals_ids;//new_deals//deals_left_open//lost_deals
					}//foreach
				}else{
					// if
				}//if
			}//foreach
			//================================<<

			if(isset($arr_request[$ppd_id])){
				//--
			}else{
				$oListaFase = FaseBD::getLista("fse_id_wrk = ".$wrk_id." AND fse_status = 'A'","fse_seq",0,1);
				$id_fse_inicial = (count($oListaFase)>0)?$oListaFase[0]->Id:0;
				$url_pipedrive = "https://api.pipedrive.com/v1/pipelines/".$ppd_id."/deals?api_token=".$pipe_token;
				$conteudo_request = file_get_contents($url_pipedrive);
				$arr_request[$ppd_id] = json_decode($conteudo_request);
			}//if
			
		}//if
		
	}//foreach

	//var_dump($arr_request);

	foreach($arr_request as $ppd_id => $arr_deals){
		echo "<br />*** ".$ppd_id." ***";

		//var_dump($arr_deals);

		// foreach($arr_deals as $deal){
			// if(is_array($deal)){
				// echo "<br />______ SIM ARRAY ______";
				// var_dump($deal);
			// }else{
				// echo "<br />______ NAO ______(".$deal.")";
			// }//if
			// 
		// }//foreach
		$bool_ok = $arr_deals->success;
		$arr_negocios = $arr_deals->data;
		$info_extra = $arr_deals->additional_data;
		if(is_array($arr_negocios)){
			foreach($arr_negocios as $negocio){
				echo "<br />".$negocio->id." / ".$negocio->title." / ".$negocio->status." / ".$negocio->value;
				// "id": 21,
				//  "creator_user_id": 3052991,
				//  "user_id": 3052991,
				//  "person_id": 21,
				//  "org_id": 21,
				//  "stage_id": 1,
				//  "title": "PagueVeloz",
				//  "value": 0,
				//  "currency": "BRL",
				//  "add_time": "2017-09-30 14:03:15",
				//  "update_time": "2017-10-04 22:42:58",
				// "active": true,
				//"person_name": "Bruno Metzner",
      			//"org_name": "PagueVeloz",
      			//"owner_name": "Victor del Pino",
      			//"cc_email": "goonbo+deal21@pipedrivemail.com",


				//var_dump($negocio);
			}//foreach
		}else{
			// if
		}//if
	}//foreach

?>