<?php
//inclui o arquivo da classe basica de manipulação de dados
require_once('class.manipulacao_dados.php');

class Menu extends ObjetoDados{}
class MenuBD extends ManipulacaoDados{
	
	// ---- PROPRIEDADES -----
	public static $campos = array(
		array('nome' => 'mnu_id',				'tipo' => 'num', 	'atributo' => 'Id', 	'extra' => 'primaria autoinc'),
		array('nome' => 'mnu_id_mnu',				'tipo' => 'num', 	'atributo' => 'IdMnu'),
		array('nome' => 'mnu_titulo',				'tipo' => 'alfa', 	'atributo' => 'Titulo'),
		array('nome' => 'mnu_subtitulo',				'tipo' => 'alfa', 	'atributo' => 'Subtitulo'),
		array('nome' => 'mnu_label',				'tipo' => 'alfa', 	'atributo' => 'Label'),
		array('nome' => 'mnu_default',				'tipo' => 'alfa', 	'atributo' => 'Default'),
		array('nome' => 'mnu_template',				'tipo' => 'alfa', 	'atributo' => 'Template'),
		array('nome' => 'mnu_include',				'tipo' => 'alfa', 	'atributo' => 'Include'),
		array('nome' => 'mnu_icon',				'tipo' => 'alfa', 	'atributo' => 'Icon'),
		array('nome' => 'mnu_permisso',				'tipo' => 'alfa', 	'atributo' => 'Permisso'),
		array('nome' => 'mnu_ordem',				'tipo' => 'num', 	'atributo' => 'Ordem'),
		array('nome' => 'mnu_show',				'tipo' => 'alfa', 	'atributo' => 'Show'),
		array('nome' => 'mnu_status',				'tipo' => 'alfa', 	'atributo' => 'Status')
	);
	public static $tabela = array('nome' => 'gnb_menu', 'classe' => 'Menu');
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
