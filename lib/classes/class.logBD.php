<?php
//inclui o arquivo da classe basica de manipulação de dados
require_once('class.manipulacao_dados.php');

class Log extends ObjetoDados{}
class LogBD extends ManipulacaoDados{
	
	// ---- PROPRIEDADES -----
	public static $campos = array(
		array('nome' => 'log_id',				'tipo' => 'num', 	'atributo' => 'Id', 	'extra' => 'primaria autoinc'),
		array('nome' => 'log_dt_registro',				'tipo' => 'alfa', 	'atributo' => 'DtRegistro'),
		array('nome' => 'log_hr_registro',				'tipo' => 'alfa', 	'atributo' => 'HrRegistro'),
		array('nome' => 'log_id_fch',				'tipo' => 'num', 	'atributo' => 'IdFch'),
		array('nome' => 'log_id_prf',				'tipo' => 'num', 	'atributo' => 'IdPrf'),
		array('nome' => 'log_id_usr',				'tipo' => 'num', 	'atributo' => 'IdUsr'),
		array('nome' => 'log_acao',				'tipo' => 'alfa', 	'atributo' => 'Acao'),
		array('nome' => 'log_id_extra',				'tipo' => 'num', 	'atributo' => 'IdExtra'),
		array('nome' => 'log_table_extra',				'tipo' => 'alfa', 	'atributo' => 'TableExtra'),
		array('nome' => 'log_obs',				'tipo' => 'alfa', 	'atributo' => 'Obs')
	);
	public static $tabela = array('nome' => 'gnb_log', 'classe' => 'Log');
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
