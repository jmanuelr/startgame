<?php
//inclui o arquivo da classe basica de manipulação de dados
require_once('class.manipulacao_dados.php');

class Trello extends ObjetoDados{}
class TrelloBD extends ManipulacaoDados{
	
	// ---- PROPRIEDADES -----
	public static $campos = array(
		array('nome' => 'trl_id',				'tipo' => 'num', 	'atributo' => 'Id', 	'extra' => 'primaria autoinc'),
		array('nome' => 'trl_trello_id',		'tipo' => 'alfa', 	'atributo' => 'TrelloId'),
		array('nome' => 'trl_type',				'tipo' => 'alfa', 	'atributo' => 'Type'),
		array('nome' => 'trl_id_board',			'tipo' => 'num', 	'atributo' => 'IdBoard'),
		array('nome' => 'trl_id_list',			'tipo' => 'num', 	'atributo' => 'IdList'),
		array('nome' => 'trl_id_card',			'tipo' => 'num', 	'atributo' => 'IdCard'),
		array('nome' => 'trl_id_chk',			'tipo' => 'num', 	'atributo' => 'IdChk'),
		array('nome' => 'trl_name',				'tipo' => 'alfa', 	'atributo' => 'Name'),
		array('nome' => 'trl_text',				'tipo' => 'alfa', 	'atributo' => 'Text'),
		array('nome' => 'trl_progress',			'tipo' => 'num', 	'atributo' => 'Progress'),
		array('nome' => 'trl_status',			'tipo' => 'alfa', 	'atributo' => 'Status')
	);
	public static $tabela = array('nome' => 'gnb_trello', 'classe' => 'Trello');
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
}
?>
