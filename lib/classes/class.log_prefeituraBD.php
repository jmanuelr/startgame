<?php
//inclui o arquivo da classe basica de manipulação de dados
require_once('class.manipulacao_dados.php');

class LogPrefeitura extends ObjetoDados{}
class LogPrefeituraBD extends ManipulacaoDados{
	
	// ---- PROPRIEDADES -----
	public static $campos = array(
		array('nome' => 'lgp_id',				'tipo' => 'num', 	'atributo' => 'Id', 	'extra' => 'primaria autoinc'),
		array('nome' => 'lgp_dt_registro',				'tipo' => 'alfa', 	'atributo' => 'DtRegistro'),
		array('nome' => 'lgp_hr_registro',				'tipo' => 'alfa', 	'atributo' => 'HrRegistro'),
		array('nome' => 'lgp_id_fch',				'tipo' => 'num', 	'atributo' => 'IdFch'),
		array('nome' => 'lgp_id_prf',				'tipo' => 'num', 	'atributo' => 'IdPrf'),
		array('nome' => 'lgp_id_usr',				'tipo' => 'num', 	'atributo' => 'IdUsr'),
		array('nome' => 'lgp_acao',				'tipo' => 'alfa', 	'atributo' => 'Acao'),
		array('nome' => 'lgp_id_extra',				'tipo' => 'num', 	'atributo' => 'IdExtra'),
		array('nome' => 'lgp_table_extra',				'tipo' => 'alfa', 	'atributo' => 'TableExtra'),
		array('nome' => 'lgp_obs',				'tipo' => 'alfa', 	'atributo' => 'Obs')
	);
	public static $tabela = array('nome' => 'gnb_log_prefeitura', 'classe' => 'LogPrefeitura');
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
