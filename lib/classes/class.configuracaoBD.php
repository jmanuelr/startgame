<?php
//inclui o arquivo da classe basica de manipulação de dados
require_once('class.manipulacao_dados.php');

class Configuracao extends ObjetoDados{}
class ConfiguracaoBD extends ManipulacaoDados{
	
	// ---- PROPRIEDADES -----
	public static $campos = array(
		array('nome' => 'cnf_id',			'tipo' => 'num', 	'atributo' => 'Id', 	'extra' => 'primaria autoinc'),
		array('nome' => 'cnf_chave',		'tipo' => 'alfa', 	'atributo' => 'Chave'),
		array('nome' => 'cnf_descricao',	'tipo' => 'alfa', 	'atributo' => 'Descricao'),
		array('nome' => 'cnf_valor',		'tipo' => 'alfa', 	'atributo' => 'Valor')
	);
	public static $tabela = array('nome' => 'gnb_configuracao', 'classe' => 'Configuracao');
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

	//lista os objetos encontrados no banco de dados de acordo com os parâmetros da consulta
	public static function getByKeyword($chave = '', $uf = '', $cdd = 0){
		$retorno = "";
		$paramCondicao = "cnf_chave = '".$chave."'";
		$resultado_lista = parent::getLista($paramCondicao, '', 0, 1);
		//print_r($resultado_lista);
		return $resultado_lista[0]->Valor;
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
