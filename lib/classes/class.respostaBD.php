<?php
//inclui o arquivo da classe basica de manipulação de dados
require_once('class.manipulacao_dados.php');

class Resposta extends ObjetoDados{}
class RespostaBD extends ManipulacaoDados{
	
	// ---- PROPRIEDADES -----
	public static $campos = array(
		array('nome' => 'rsp_id',					'tipo' => 'num', 	'atributo' => 'Id', 		'extra' => 'primaria autoinc'),
		array('nome' => 'rsp_id_fch',				'tipo' => 'num', 	'atributo' => 'Ficha', 		'extra' => 'estrangeira', 	'classe' => 'Ficha', 		'arquivo_classe' => 'class.fichaBD.php'),
		array('nome' => 'rsp_id_frm',				'tipo' => 'num', 	'atributo' => 'Formulario', 'extra' => 'estrangeira', 	'classe' => 'Formulario', 	'arquivo_classe' => 'class.formularioBD.php'),
		array('nome' => 'rsp_id_txt',				'tipo' => 'num', 	'atributo' => 'Texto', 		'extra' => 'estrangeira', 	'classe' => 'Texto', 		'arquivo_classe' => 'class.textoBD.php'),
		array('nome' => 'rsp_id_cln',				'tipo' => 'num', 	'atributo' => 'Cliente',	'extra' => 'estrangeira' , 	'classe' => 'Cliente', 		'arquivo_classe' => 'class.clienteBD.php'),
		array('nome' => 'rsp_id_usr',				'tipo' => 'num', 	'atributo' => 'Usuario' ,	'extra' => 'estrangeira' , 	'classe' => 'Usuario', 		'arquivo_classe' => 'class.usuarioBD.php'),
		array('nome' => 'rsp_id_opc',				'tipo' => 'num', 	'atributo' => 'Opcao' ,		'extra' => 'estrangeira' , 	'classe' => 'Opcao', 		'arquivo_classe' => 'class.opcaoBD.php'),
		array('nome' => 'rsp_extra',				'tipo' => 'alfa', 	'atributo' => 'Extra'),
		array('nome' => 'rsp_numero',				'tipo' => 'alfa', 	'atributo' => 'Numero'),
		array('nome' => 'rsp_validacao_automatica',	'tipo' => 'num', 	'atributo' => 'ValidacaoAutomatica'),
		array('nome' => 'rsp_validacao_manual',		'tipo' => 'num', 	'atributo' => 'ValidacaoManual')
	);
	public static $tabela = array('nome' => 'gnb_resposta', 'classe' => 'Resposta');
	//-----------------------------------------------------------------------------------------------	
	// ---- METODOS DA CLASSE-----
	//metodo construtor da classe 
	public function __construct(){
	}

	//lista os objetos encontrados no banco de dados de acordo com os parâmetros da consulta
	public static function getLista($paramCondicao = '', $paramOrderBy = '', $startRs = '', $maxRs = ''){
		return parent::getLista($paramCondicao, $paramOrderBy, $startRs, $maxRs);
	}
	
	//lista os objetos encontrados no banco de dados de acordo com os parâmetros da consulta personalizada
	public static function getCustomLista($paramCondicao = '', $paramOrderBy = '', $paramCampo = '', $paramTabela = '', $paramGroupBy = '', $startRs = '', $maxRs = '', $boolGeraObj = true){
		return parent::getCustomLista($paramCondicao, $paramOrderBy, $paramCampo, $paramTabela, $paramGroupBy, $startRs, $maxRs, $boolGeraObj);
	}

	//carrga o objeto pela sua chave primária
	public static function get(){
		$objeto = parent::get(func_get_args());
		return $objeto;
	}

	//adiciona o objeto ao banco de dados
	public static function add(&$objeto){
		return parent::add($objeto);
	}

	//altera os dados do objeto no banco de dados
	public static function alter(&$objeto){
		return parent::alter($objeto);
	}

	//deleta o objeto Marca do banco de dados
	public static function del(&$objeto){
		return parent::del($objeto);
	}
	//----------------------------------------------------------------------------------------------- custom
	public static function addCustom($arr_campos_valores){
		return parent::addCustom($arr_campos_valores);
	}//pbl
	public static function delByCondition($paramCondicao = ''){
		return parent::delByCondition($paramCondicao);
	}//pbl
	//-----------------------------------------------------------------------------------------------
	public function valCampo(&$objeto,$paramCondicao = ''){
		return parent::valCampo($objeto,$paramCondicao = '');
	}//pbl

	public function getValidacao($fch_id){
		$paramCondicao = "rsp_id_fch = ".$fch_id;
		$paramOrderBy  = "";
		$paramCampo    = "rsp_validacao_manual,count(rsp_validacao_manual) as qtde";
		$paramTabela   = "";
		$paramGroupBy  = "rsp_validacao_manual";
		$startRs       = "";
		$maxRs         = "";
		$boolGeraObj   = false;
		$arr_resposta  = parent::getCustomLista($paramCondicao, $paramOrderBy, $paramCampo, $paramTabela, $paramGroupBy, $startRs, $maxRs, $boolGeraObj);
		$arr_retorno = array();
		foreach($arr_resposta as $resposta){
			$arr_retorno[$resposta['rsp_validacao_manual']] = $resposta['qtde'];
		}//foreach
		return $arr_retorno;
	}//pbl
}
?>
