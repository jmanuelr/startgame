<?php

//require_once(dirname(__FILE__)."/../classes/class.usuarioBD.php");

function validaVariaveis($arr_ignorar = array()){
	global $_REQUEST;
	foreach($_REQUEST AS $cd => $val){
		if(!in_array($cd,$arr_ignorar))$_REQUEST[$cd] = trim(ereg_replace("[\"']","\"",$val));
	}//foreach
}

#####################################################################################################################
# Funções Para formularios
#####################################################################################################################
/* Redirecionamento via php ou via html
redirect('nome_do_arquivo.php',1) via php
redirect('nome_do_arquivo.php') via html
*/
function redirect(){
	$args = func_get_args ();

	if($args[1] == true):

		header('Location: '.$args[0]); # redirencionamento via PHP
			else: # redirencionamento via HTML
				echo '<META http-equiv="refresh" content="0;URL='.$args[0].'">'; exit;
					endif;
}
#####################################################################################################################
# pega o id da URL da aplicação atual, se não existe retorna zero
#####################################################################################################################
function get_id(){

	if(!empty($_REQUEST['id'])):
		return $_REQUEST['id'];
	endif;

	return 0;
}
#####################################################################################################################
#
#####################################################################################################################
	function object_to_array($var) {

		$result = array();
		$references = array();

		// loop over elements/properties
		foreach ($var as $key => $value) {
			//echo "|".$contador;
			// recursively convert objects
			if (is_object($value) || is_array($value)) {
				// but prevent cycles
				if (!in_array($value, $references)) {
					$result[$key] = object_to_array($value);
					$references[] = $value;
					//echo "<br />(key: $key)";
				}
			} else {
				// simple values are untouched
				$result[$key] = $value;
				//echo "<br />(key: $key / value: $value)";
			}//if
		}//foreach'
		return $result;
	}
#####################################################################################################################
#
#####################################################################################################################
	function json_encode2($param) {
		if (is_object($param) || is_array($param)) {
			$param = object_to_array($param);
		}//if
		return json_encode($param);
	}//fnc
#####################################################################################################################
#
#####################################################################################################################
	function num2alpha($n) {
		$r = '';
		for ($i = 1; $n >= 0 && $i < 10; $i++) {
			$r = chr(0x41 + ($n % pow(26, $i) / pow(26, $i - 1))) . $r;
			$n -= pow(26, $i);
		}
		return $r;
	}//fnc

#####################################################################################################################
#
#####################################################################################################################
	function printToolTip($campo,$tela = ''){
		global $global_tela;
		if($tela == '')$tela = $global_tela;
		$oListaTootip = TooltipBD::getLista("ttp_tela = '".$tela."' AND ttp_campo = '".$campo."' AND ttp_status = 'A'","ttp_id DESC",0,1);
		if(count($oListaTootip) > 0){
			$tooltip = '<a href="" onclick="return false;" class="classTooltip" data-original-title="'.$oListaTootip[0]->Texto.'"><i class="glyphicon glyphicon-question-sign white"></i></a>';
		}else{
			if($_SESSION["sss_usr_tipo"]=="A"){
				$tooltip = '<a href="" onclick="return false;" class="classTooltip" data-original-title="[campo:'.$campo.", tela:".$tela.']" style="color:#f00;"><i class="glyphicon glyphicon-question-sign white"></i></a>';
			}else{
				$tooltip = "<!-- '".$campo."','".$tela."' -->";
			}//if
		}//if
		echo $tooltip;
		return;
	}//fnc

#####################################################################################################################
#  Busca a porcentagem de desconto de acordo com a variavel de entrada
#####################################################################################################################

function getVariavelConfig($variavel){

	$retorno = "";

	$oListaConfiguracao = ConfiguracaoBD::getLista("cnf_chave like '".$variavel."'",0,1);
	if(count($oListaConfiguracao) > 0){
		$retorno = $oListaConfiguracao[0]->Valor;
	}//if

	return $retorno;

}


function verificaCidadeEstadoGlobal($aux_uf,$aux_cdd, $oListaTextoCidade){
	$bool_achou = false;
	foreach($oListaTextoCidade as $oTextoCidade){
		if($oTextoCidade->Uf == $aux_uf){
			//&&
			if($aux_cdd >= 0){
				if($oTextoCidade->_Cidade == $aux_cdd){
					$bool_achou = true;
					break;
				}//if
			}else{
				$bool_achou = true;
				break;
			}//if
		}//if
	}//foreach
	return $bool_achou;
}//fnc

function printArray($arr_tmp){
	echo "<pre>";
	print_r($arr_tmp);
	echo "</pre>";
}//fnc

function bigintval($value) {
  $value = trim($value);
  if (ctype_digit($value)) {
    return $value;
  }
  $value = preg_replace("/[^0-9](.*)$/", '', $value);
  if (ctype_digit($value)) {
    return $value;
  }
  return 0;
}//fnc

function randomPassword($tamanho = 8) {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';//!@#$%^&*()_-=+;:,.?
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $tamanho; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

?>