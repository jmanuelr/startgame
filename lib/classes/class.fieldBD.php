<?php
//inclui o arquivo da classe basica de manipulação de dados
require_once('class.manipulacao_dados.php');

class Field extends ObjetoDados{}
class FieldBD extends ManipulacaoDados{

	// ---- PROPRIEDADES -----
	public static $campos = array(
		array('nome' => 'fld_id',				'tipo' => 'num', 	'atributo' => 'Id', 		'extra' => 'primaria autoinc'),
		array('nome' => 'fld_id_cln',			'tipo' => 'num', 	'atributo' => 'Cliente', 	'extra' => 'estrangeira', 'arquivo_classe' => 'class.clienteBD.php'),
		array('nome' => 'fld_nome',				'tipo' => 'alfa', 	'atributo' => 'Nome'),
		array('nome' => 'fld_descricao',		'tipo' => 'alfa', 	'atributo' => 'Descricao'),
		array('nome' => 'fld_default',			'tipo' => 'alfa', 	'atributo' => 'Default'),
		array('nome' => 'fld_tipo',				'tipo' => 'alfa', 	'atributo' => 'Tipo'),
		array('nome' => 'fld_decimal',			'tipo' => 'num', 	'atributo' => 'Decimal'),
		array('nome' => 'fld_status',			'tipo' => 'alfa', 	'atributo' => 'Status'),
		array('nome' => 'fld_cadastro',			'tipo' => 'num', 	'atributo' => 'Cadastro')
	);
	public static $tabela = array('nome' => 'gnb_field', 'classe' => 'Field');
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
