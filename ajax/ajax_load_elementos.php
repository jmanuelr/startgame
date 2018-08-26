<?php

	date_default_timezone_set('America/Sao_Paulo');

	require_once(__DIR__.'/../lib/includes/session.inc.php');
	require_once(__DIR__.'/../lib/classes/class.usuarioBD.php');
	require_once(__DIR__.'/../lib/classes/class.clienteBD.php');
	require_once(__DIR__.'/../lib/classes/class.workflowBD.php');
	require_once(__DIR__.'/../lib/classes/class.janelaBD.php');
	require_once(__DIR__.'/../lib/classes/class.sistemaBD.php');
	require_once(__DIR__.'/../lib/classes/class.elementoBD.php');

	session::start();

	$is_json = (intval($_REQUEST["json"])==1)?true:false;


	$sis_id = preg_replace("[^0-9]","", $_REQUEST["sis"]);
	if($sis_id=="")$sis_id=0;

	$jnl_id = preg_replace("[^0-9]","", $_REQUEST["jnl"]);
	if($jnl_id=="")$jnl_id=0;

	$elm_id = preg_replace("[^0-9]","", $_REQUEST["elm"]);
	if($elm_id=="")$elm_id=0;

	$usr_id = preg_replace("[^0-9]","", $_SESSION["sss_usr_id"]);
	if($usr_id=="")$usr_id=0;

	$cln_id = preg_replace("[^0-9]","", $_SESSION["sss_usr_id_cln"]);
	if($cln_id=="")$cln_id=0;

	$bool_erro = false;

	if($usr_id == 0){
		$arr_retorno = array(
			"success" => false,
			"msg" => "Error: User not found"
		);
	}//if
	if($sis_id == 0){
		$arr_retorno = array(
			"success" => false,
			"msg" => "Error: System not found"
		);
	}//if
	if($jnl_id == 0){
		$arr_retorno = array(
			"success" => false,
			"msg" => "Error: Window not found"
		);
	}//if

	$oSistema = SistemaBD::get($sis_id);

	if($cln_id != $oSistema->_Cliente){
		$arr_retorno = array(
			"success" => false,
			"msg" => "Error: Sistema not allowed"
		);
	}//if

	if($bool_erro){
		echo json_encode($arr_retorno);
		exit;
	}//if

	$oJanela = SistemaBD::get($jnl_id);

	$oListaElemento = ElementoBD::getLista("elm_id_sis = ".$sis_id." AND elm_id_jnl = ".$jnl_id,"elm_ordem");


	if($is_json){
		if(count($oListaElemento)>0){
			$arr_retorno = array(
				"success" => true,
				"qtde" => count($oListaElemento),
				"elementos" => array()
			);
			foreach($oListaElemento as $oElemento){
				$arr_retorno["elementos"][] = array(
					"id" => $oElemento->Id,
					"byid" => $oElemento->ById,
					"byname" => $oElemento->ByName,
					"titulo" => $oElemento->Titulo,
					"descricao" => $oElemento->Descricao
				);
			}//foreach
		}else{
			$arr_retorno = array(
				"success" => true,
				"qtde" => 0
			);
		}//if

		echo json_encode($arr_retorno);
		exit;

	}else{
			if(count($oListaElemento)>0){
				?>
				<table class="table">
					<tr>
						<th>#</th>
						<th>Elemento</th>
						<th>Título</th>
						<th>Mensagem de Ajuda</th>
						<th>&nbsp;</th>
					</tr>
					<?
					$contador = 0;
					foreach($oListaElemento as $oElemento){
						$contador++;
						?>
						<tr>
							<td align="right"><?=$contador?></td>
							<td><?=$oElemento->ById?></td>
							<td><input type="text" name="txt_elm_<?=$oElemento->Id?>_titulo" id="txt_elm_<?=$oElemento->Id?>_titulo" value="<?=$oElemento->Titulo?>" class="form-control" maxlenght="150" /></td>
							<td><textarea name="txt_elm_<?=$oElemento->Id?>_descricao" id="txt_elm_<?=$oElemento->Id?>_descricao" maxlenght="250"><?=$oElemento->Descricao?></textarea></td>
							<td><a href="javascript:delElemento(<?=$oElemento->Id?>);" class="btn btn-danger"><i class="icon-trash"></i>&nbsp;Excluir</a></td>
						</tr>
						<?
					}//foreach
					?>
				</table>
				<?
			}else{
				?>
				<p>Não foram encontrados registros...</p>
				<?
			}//if
	}//if

	
?>