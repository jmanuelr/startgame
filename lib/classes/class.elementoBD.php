<?php
//inclui o arquivo da classe basica de manipulação de dados
require_once('class.manipulacao_dados.php');

class Elemento extends ObjetoDados{}
class ElementoBD extends ManipulacaoDados{
	
	// ---- PROPRIEDADES -----
	public static $campos = array(
		array('nome' => 'elm_id',				'tipo' => 'num', 	'atributo' => 'Id', 		'extra' => 'primaria autoinc'),
		array('nome' => 'elm_id_sis',			'tipo' => 'num', 	'atributo' => 'Sistema', 	'extra' => 'estrangeira', 'arquivo_classe' => 'class.sistemaBD.php'),
		array('nome' => 'elm_id_jnl',			'tipo' => 'num', 	'atributo' => 'Janela', 	'extra' => 'estrangeira', 'arquivo_classe' => 'class.janelaBD.php'),
		array('nome' => 'elm_type',				'tipo' => 'alfa', 	'atributo' => 'Type'),
		array('nome' => 'elm_by_id',			'tipo' => 'alfa', 	'atributo' => 'ById'),
		array('nome' => 'elm_by_name',			'tipo' => 'alfa', 	'atributo' => 'ByName'),
		array('nome' => 'elm_path',				'tipo' => 'alfa', 	'atributo' => 'Path'),
		array('nome' => 'elm_trigger',			'tipo' => 'alfa', 	'atributo' => 'Trigger'),
		array('nome' => 'elm_callback',			'tipo' => 'alfa', 	'atributo' => 'Callback'),
		array('nome' => 'elm_status',			'tipo' => 'alfa', 	'atributo' => 'Status'),
		array('nome' => 'elm_ordem',			'tipo' => 'num', 	'atributo' => 'Ordem'),
		array('nome' => 'elm_titulo',			'tipo' => 'alfa', 	'atributo' => 'Titulo'),
		array('nome' => 'elm_descricao',		'tipo' => 'alfa', 	'atributo' => 'Descricao')
		
		
	);
	public static $tabela = array('nome' => 'gnb_elemento', 'classe' => 'Elemento');
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
