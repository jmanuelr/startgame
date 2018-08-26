<?php
//inclui o arquivo da classe basica de manipulação de dados
require_once('class.manipulacao_dados.php');

class FieldFase extends ObjetoDados{}
class FieldFaseBD extends ManipulacaoDados{

	// ---- PROPRIEDADES -----
	public static $campos = array(
		array('nome' => 'ffs_id_fld',			'tipo' => 'num', 	'atributo' => 'Field', 		'extra' => 'primaria estrangeira', 'arquivo_classe' => 'class.fieldBD.php'),
		array('nome' => 'ffs_id_fse',			'tipo' => 'num', 	'atributo' => 'Fase', 		'extra' => 'primaria estrangeira', 'arquivo_classe' => 'class.faseBD.php'),
		array('nome' => 'ffs_id_wrk',			'tipo' => 'num', 	'atributo' => 'Workflow', 	'extra' => 'primaria estrangeira', 'arquivo_classe' => 'class.workflowBD.php'),
		array('nome' => 'ffs_seq',				'tipo' => 'num', 	'atributo' => 'Seq'),
		array('nome' => 'ffs_obrigatorio',		'tipo' => 'alfa', 	'atributo' => 'Obrigatorio')
	);
	public static $tabela = array('nome' => 'gnb_field_fase', 'classe' => 'FieldFase');
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
