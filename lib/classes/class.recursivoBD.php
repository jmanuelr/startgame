<?php
//inclui o arquivo da classe basica de manipulação de dados
require_once('class.manipulacao_dados.php');

class Recursivo extends ObjetoDados{}
class RecursivoBD extends ManipulacaoDados{
	
	// ---- PROPRIEDADES -----
	public static $campos = array(
		array('nome' => 'rcr_id',			'tipo' => 'num', 	'atributo' => 'Id', 			'extra' => 'primaria autoinc'),
		array('nome' => 'rcr_tipo',			'tipo' => 'alfa', 	'atributo' => 'Tipo'),
		//array('nome' => 'rcr_id_cls',		'tipo' => 'num', 	'atributo' => 'Classificacao', 	'extra' => 'estrangeira', 'classe' => 'Classificacao', 'arquivo_classe' => 'class.classificacaoBD.php'),
		array('nome' => 'rcr_id_rcr',		'tipo' => 'num', 	'atributo' => 'Recursivo', 			'extra' => 'estrangeira', 'classe' => 'Recursivo', 'arquivo_classe' => 'class.RecursivoBD.php'),
		array('nome' => 'rcr_nome',			'tipo' => 'alfa', 	'atributo' => 'Nome'),
		array('nome' => 'rcr_descricao',	'tipo' => 'alfa', 	'atributo' => 'Descricao'),
		array('nome' => 'rcr_status',		'tipo' => 'alfa', 	'atributo' => 'Status')
	);
	public static $tabela = array('nome' => 'gnb_recursivo', 'classe' => 'Recursivo');
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