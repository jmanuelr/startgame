<?php
//inclui o arquivo da classe basica de manipulação de dados
require_once('class.manipulacao_dados.php');

class Prefeitura extends ObjetoDados{}
class PrefeituraBD extends ManipulacaoDados{
	
	// ---- PROPRIEDADES -----
	public static $campos = array(
		array('nome' => 'prf_id',				'tipo' => 'num', 	'atributo' => 'Id', 	'extra' => 'primaria autoinc'),
		array('nome' => 'prf_nome',				'tipo' => 'alfa', 	'atributo' => 'Nome'),
		array('nome' => 'prf_cnpj',				'tipo' => 'alfa', 	'atributo' => 'Cnpj'),
		array('nome' => 'prf_logo',				'tipo' => 'alfa', 	'atributo' => 'Logo'),
		array('nome' => 'prf_endereco',				'tipo' => 'alfa', 	'atributo' => 'Endereco'),
		array('nome' => 'prf_fone',				'tipo' => 'alfa', 	'atributo' => 'Fone'),
		array('nome' => 'prf_email',				'tipo' => 'alfa', 	'atributo' => 'Email'),
		array('nome' => 'prf_uf',				'tipo' => 'alfa', 	'atributo' => 'Uf'),
		array('nome' => 'prf_sigla_protocolo',				'tipo' => 'alfa', 	'atributo' => 'SiglaProtocolo'),
		array('nome' => 'prf_inicio_sequencia',				'tipo' => 'num', 	'atributo' => 'InicioSequencia'),
		array('nome' => 'prf_flag_fiscal',				'tipo' => 'alfa', 	'atributo' => 'FlagFiscal'),
		array('nome' => 'prf_status',				'tipo' => 'alfa', 	'atributo' => 'Status')
	);
	public static $tabela = array('nome' => 'gnb_prefeitura', 'classe' => 'Prefeitura');
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
