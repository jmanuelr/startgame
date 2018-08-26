<?
	date_default_timezone_set('America/Sao_Paulo');

	require_once(__DIR__.'/../lib/includes/session.inc.php');
	require_once(__DIR__.'/../lib/classes/class.RN.php');
	require_once(__DIR__."/../lib/classes/class.formata_string.php");
	require_once(__DIR__.'/../lib/classes/class.usuarioBD.php');
	require_once(__DIR__.'/../lib/classes/class.clienteBD.php');
	require_once(__DIR__.'/../lib/classes/class.contatoBD.php');
	require_once(__DIR__.'/../lib/classes/class.workflowBD.php');
	require_once(__DIR__.'/../lib/classes/class.faseBD.php');
	require_once(__DIR__.'/../lib/classes/class.questionBD.php');
	require_once(__DIR__.'/../lib/classes/class.equipe_usuarioBD.php');
	require_once(__DIR__.'/../lib/classes/class.equipe_questionBD.php');
	require_once(__DIR__.'/../lib/classes/class.taskBD.php');
	require_once(__DIR__.'/../lib/classes/class.task_faseBD.php');
	require_once(__DIR__.'/../lib/classes/class.template_faseBD.php');
	require_once(__DIR__.'/../lib/classes/class.envio_email.php');

	require_once(__DIR__.'/../lib/includes/inc_vars.php');

	session::start();

	$oFormata = new FormataString;

	//-------------------------------------------------------------------
	$strUrlSite 			= Config::appSettings("strUrlSite");

	$system_name 			= getVariavelConfig("sys_name");
	$sys_email_contact 		= getVariavelConfig("sys_email_contact");

	$app_main_url 			= getVariavelConfig("app_main_url");
	$web_main_url 			= getVariavelConfig("web_main_url");
	$web_social_facebook 	= getVariavelConfig("web_social_facebook");
	$web_social_twitter 	= getVariavelConfig("web_social_twitter");
	//-------------------------------------------------------------------

	$dt_now = date("Ymd");

	$wrk_id = preg_replace("/[^0-9]/i","", $_REQUEST["wrk"]);
	if($wrk_id=="")$wrk_id=0;

	$fse_id = preg_replace("/[^0-9]/i","", $_REQUEST["fse"]);
	if($fse_id=="")$fse_id=0;

	$fse_id_origem = preg_replace("/[^0-9]/i","", $_REQUEST["fase_origem"]);
	if($fse_id_origem=="")$fse_id_origem=0;

	$tsk_id = preg_replace("/[^0-9]/i","", $_REQUEST["tsk"]);
	if($tsk_id=="")$tsk_id=0;

	//-------------------------------------------------------------------
	$oTask = TaskBD::get($tsk_id);

	$arr_sumir_task = array();

	//-------------------------------------------------------------------

	function sendEmailTrigger($tipo,$fase,$task = 0){
		global $strUrlSite, $system_name, $sys_email_contact, $app_main_url, $web_main_url, $web_social_facebook, $web_social_twitter;

		$arr_email_ja_enviado = array();
		//$oFase = FaseBD::get($fase);
		$oLocalTask = TaskBD::get($task);

		$oCliente = $oTask->Cliente;
		$oFase = FaseBD::get($fase);

		$condicao_template = "tfs_id_fse = ".$fase;

		switch($tipo){
			case 'in':
				$condicao_template.= " AND tfs_send_in = 'S'";
			break;
			case 'out':
				$condicao_template.= " AND tfs_send_out = 'S'";
			break;
			default:
				$condicao_template.= " AND FALSE";
			break;
		}//sw

		$oListaTemplateFase = TemplateFaseBD::getLista($condicao_template);
		foreach ($oListaTemplateFase as $oEmailFase) {

			$tmp_template_id 		= $oEmailFase->_Template;
			$tmp_template_titulo 	= $oEmailFase->Template->Titulo;
			$tmp_template_assunto 	= $oEmailFase->Template->Descricao;
			$tmp_template_conteudo 	= $oEmailFase->Template->Conteudo;
			//$str_emails 			= $oEmailFase->SendIn;
			//$str_emails 			= $oEmailFase->SendOut;
			//$str_emails 			= $oEmailFase->SendTime;
			$str_send_team 			= $oEmailFase->SendTeam;
			$str_send_resp 			= $oEmailFase->SendResp;
			$str_send_cln 			= $oEmailFase->SendCln;
			$str_send_mail 			= $oEmailFase->SendMail;
			//----------------------------------------------
			$arr_equipe = array();
			$arr_usuario = array();
			$arr_contato = array();

			$arr_emails = array();
			//----------------------------------------------
			if($str_send_team == "S" || $str_send_resp == "S"){

				$oListaQuestion = QuestionBD::getLista("qst_id_fse = ".$fase, "qst_seq");

				foreach($oListaQuestion as $oQuestion){
					$oListaEquipeQuestion = EquipeQuestionBD::getLista("eqs_id_qst = ".$oQuestion->Id);
					foreach($oListaEquipeQuestion as $oEquipeQuestion){
						if(is_object($oEquipeQuestion->Equipe)){
							if(!array_key_exists($oEquipeQuestion->_Equipe, $arr_equipe)){//!in_array($oEquipeQuestion->_Equipe, $arr_equipe_ids)
								$arr_equipe[$oEquipeQuestion->_Equipe] = $oEquipeQuestion->Equipe;
							}//if
						}//if
						if(is_object($oEquipeQuestion->Usuario)){
							if(!array_key_exists($oEquipeQuestion->_Usuario, $arr_usuario)){//!in_array($oEquipeQuestion->_Equipe, $arr_equipe_ids)
								$arr_usuario[$oEquipeQuestion->_Usuario] = $oEquipeQuestion->Usuario;
							}//if
						}//if
					}//foreach
				}//foreach
			}//if

			if($str_send_team == "S" && count($arr_equipe)>0){
				//--
				foreach($arr_equipe as $chave => $oEquipe){
					$oListaEquipeUsuario = EquipeUsuarioBD::getLista("esr_id_eqp = ".$chave);
					foreach($oListaEquipeUsuario as $oEquipeUsuario){
						if(is_object($oEquipeUsuario->Usuario)){
							if($oEquipeUsuario->Usuario->Status == 'A'){
								$arr_emails[] = array("usuario",$oEquipeUsuario->_Usuario,$oEquipeUsuario->Usuario->Nome,$oEquipeUsuario->Usuario->Email);
							}//if
						}//if
					}//foreach

				}//foreach
			}//if

			if($str_send_resp == "S" && count($arr_usuario)>0){
				foreach($arr_usuario as $chave => $oUsuario){
					if($oUsuario->Status == 'A'){
						$arr_emails[] = array("usuario",$oUsuario->Id,$oUsuario->Nome,$oUsuario->Email);
					}//if
				}//foreach
			}//if

			if($str_send_cln == "S"){
				$oListaContato = ContatoBD::getLista("cnt_id_cln = ".$oLocalTask->_Cliente." AND cnt_status = 'A'");
				foreach($oListaContato as $oContato){
					$arr_contato[$oContato->Id] = $oContato;
					$arr_emails[] = array("contato",$oContato->Id,$oContato->Nome,$oContato->Email);
				}//foreach
				$oContato = $oListaContato[0];
			}//if

			if($str_send_mail != ""){
				$arr_tmp = explode(";",$str_send_mail);
				foreach($arr_tmp as $email){
					if($email!=""){
						$arr_emails[] = array("",0,"",$email);
					}//if
				}//foreach
			}//if
			//----------------------------------------------

			foreach($arr_emails as $arr_par){

				$temp_tipo 	= trim($arr_par[0]);
				$temp_id 	= trim($arr_par[1]);
				$temp_nome 	= trim($arr_par[2]);
				$temp_email = trim($arr_par[3]);

				if(in_array($temp_email,$arr_email_ja_enviado)){
					//--
					continue;
				}else{
					//--
					$arr_email_ja_enviado[] = $temp_email;
				}//if

				//$usuario_primeiro_nome = RN::primeiraPalavra($temp_nome);

				if($temp_tipo == "usuario"){
					$oUsuario = $arr_usuario[$temp_id];
				}//if

				//------------------------------------------------------------------- enviar confirmacao por email
				//$link_confirmacao = $app_main_url.'/auth/?target=confirma&mail=';
				//-------------------------------------------------------------------
				$mensagem = $tmp_template_conteudo;
				/*
				$arr_substituicao = array(
					//"[EQUIPE_NOME]" 			=> "\$oEquipe->Nome",
					"[USUARIO_NOME]" 			=> "\$oUsuario->Nome",
					"[USUARIO_EMAIL]" 			=> "\$oUsuario->Email",

					"[CLIENTE_NOME_FANTASIA]" 	=> "\$oCliente->Nome",
					"[CLIENTE_RAZAO_SOCIAL]" 	=> "\$oCliente->RazaoSocial",
					"[CLIENTE_CNPJ]" 			=> "\$oFormata->getCNPJ(\$oCliente->CnpjCpf)",
					"[CONTATO_NOME]" 			=> "\$oContato->Nome",
					"[CONTATO_EMAIL]" 			=> "\$oContato->Email",
					"[FASE_TITULO]" 			=> "\$oFase->Titulo",
					"[FASE_DESCRICAO]" 			=> "\$oFase->Descricao",
					"[DEAL_TITULO]" 			=> "\$oTask->Titulo",
					"[DEAL_DESCRICAO]" 			=> "\$oTask->Descrcao"
				);
				*/

				foreach($arr_substituicao as $search => $replace){
					eval("\$mensagem = str_replace('".$search."',".$replace.", \$mensagem);");
				}//foreach

				//$mensagem.= '<br /><br /><a href="'.$link_confirmacao.'" style="color:#3498db;">'.$link_confirmacao.'</a>';
			    //-------------------------------------------------------------------
				$dados = array(
							"##_web_main_url_##" 	=> $web_main_url,
							"##_app_main_url_##" 	=> $app_main_url,
							"##_titulo_##"      	=> $tmp_template_assunto,
							"##_mensagem_##"   		=> $mensagem
				);

				$bool_enviou = @EnvioEmail::enviar(
					$temp_email,
					$tmp_template_assunto,
					"../webmails/template_email.html",
					$dados,
					"",//reply_email
					"",//filepath
					"",//filename
					false
				);


				if($bool_enviou){
					$valor_retorno_envio = 1;
				}else{
					$valor_retorno_envio = 0;
				}//if
				//-------------------------------------------------------------------

			}//foreach


			//-------------------------------------------------------------------

		}//foreach


	}//fnc sendEmailTrigger

	//===============================================
	if($oTask->_Task > 0){

		$arr_sumir_task[] = $oTask->Id;
		//-- mover Task Pai
		$oTaskMaster = TaskBD::get($oTask->_Task);

		$oTask->Status = 'I';
		TaskBD::alter($oTask);

		$oTask = $oTaskMaster;
		$tsk_id = $oTaskMaster->Id;

	}else{
		$oListaAuxTask = TaskBD::getLista("tsk_id_tsk = ".$oTask->Id);
		foreach($oListaAuxTask as $oAuxTask){
			$arr_sumir_task[] = $oAuxTask->Id;
			$oAuxTask->Status = 'I';
			TaskBD::alter($oAuxTask);
		}//foreach
	}//if
	//===============================================

	//if($fse_id == $fse_id_origem){
	//	echo "nothing to do...";
	//	exit;
	//}//if

	$oFaseOrigem = FaseBD::get($fse_id_origem);
	$oFaseDestino = FaseBD::get($fse_id);

	$task_replica_id = 0;

	if($oFaseDestino->Replica > 0 && $fse_id != $oFaseDestino->Replica){
		$oTaskReplica = new Task;

		$oTaskReplica->DtRegistro = $oTask->DtRegistro;
		$oTaskReplica->Task       = $oTask->Id;
		$oTaskReplica->Fase       = $oFaseDestino->Replica;
		$oTaskReplica->Workflow   = $oTask->_Workflow;
		$oTaskReplica->Cliente    = $oTask->_Cliente;
		$oTaskReplica->Usuario    = $_SESSION["sss_usr_id"];//$oTask->Usuario;
		$oTaskReplica->Seq        = $oTask->Seq;
		$oTaskReplica->Titulo     = $oTask->Titulo;
		$oTaskReplica->Descricao  = $oTask->Descricao;
		$oTaskReplica->Tipo       = $oTask->Tipo;
		$oTaskReplica->Option     = $oTask->Option;
		$oTaskReplica->Required   = $oTask->Required;
		$oTaskReplica->Status     = "A";

		$task_replica_id = TaskBD::add($oTaskReplica);
	}//if

	//echo "\$task_replica_id: ".task_replica_id;


	//============================================ PASSO 1: MARCAR SAÍDA

	if($fse_id_origem > 0){

		$oListaTaskFase = TaskFaseBD::getLista("tfs_id_tsk = ".$tsk_id." AND tfs_id_fse = ".$fse_id_origem." AND (tfs_id_usr_out = 0 OR  tfs_id_usr_out IS NULL)","tfs_seq DESC",0,1);

		if(count($oListaTaskFase)>0){
			$oTaskFase = $oListaTaskFase[0];
			//consulta
			//$oTaskFase->DtIni

			$dias_diferenca = RN::dateDiff2($oTaskFase->DtIni,$dt_now);

			//setar
			$oTaskFase->DtFim 		= $dt_now;
			$oTaskFase->DtDif 		= $dias_diferenca;
			$oTaskFase->HrFim 		= date("H:i");
			$oTaskFase->UsuarioOut  = $_SESSION["sss_usr_id"];

			//indiferente
			//$oTaskFase->HrIni
			//$oTaskFase->UsuarioIn
			TaskFaseBD::alter($oTaskFase);

			//--------------------------
			sendEmailTrigger('out',$fse_id_origem,$tsk_id);
			//--------------------------

		}//if

	}//if



	//============================================ PASSO 2: MARCAR ENTRADA

	if($fse_id > 0){

		$oTask->Fase = $fse_id;
		TaskBD::alter($oTask);

		//----------------------
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

		//--------------------------
		sendEmailTrigger('in',$fse_id,$tsk_id);
		//--------------------------


		if($task_replica_id > 0){
			//----------------------
		    $condicao_seq = "tfs_id_tsk = ".$task_replica_id." AND tfs_id_fse = ".$oFaseDestino->Replica;
		    $arr_seq = TaskFaseBD::getCustomLista($condicao_seq, '', 'MAX(tfs_seq) as ordem', '', '', '', '', false);
		    $contador_seq = is_numeric($arr_seq[0]["ordem"])?(intval($arr_seq[0]["ordem"]) + 1):1;
		    //----------------------

			$arr_valor = array(
				'tfs_id_tsk'			=> $task_replica_id,
				'tfs_id_fse'			=> $oFaseDestino->Replica,
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

			//--------------------------
			sendEmailTrigger('in',$oFaseDestino->Replica,$task_replica_id);
			//--------------------------
			//---
			$arr_retorno = array(
				"tsk_id" => $task_replica_id,
				"tsk_pai" => $oTask->Id,
				"tsk_titulo" => $oTask->Titulo,
				"tsk_status" => "A",
				"tsk_class_alerta" => 'success',
				"tsk_cln_nome" => $oTaskReplica->Cliente->Nome,
				"fse_id" => $oFaseDestino->Replica,
				"condicao" => 0,
				"percentual" => 0
			);

			echo json_encode($arr_retorno);
			exit;
			//--
		}//if

	}//if



	/*
	$oTaskFase->Task
	$oTaskFase->Fase
	$oTaskFase->Seq
	$oTaskFase->DtIni
	$oTaskFase->DtFim
	$oTaskFase->DtDif
	$oTaskFase->HrIni
	$oTaskFase->HrFim
	$oTaskFase->UsuarioIn
	$oTaskFase->IUsuarioOut
	*/



	//if($oTask->_Cliente == 0){

		//$oTask->Cliente = $cln_id;

		//TaskBD::alter($oTask);
	//}//if

	//echo $oTask->Cliente->Nome;
?>