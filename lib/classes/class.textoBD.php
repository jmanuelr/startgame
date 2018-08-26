<?php
//inclui o arquivo da classe basica de manipulação de dados
require_once('class.manipulacao_dados.php');

class Texto extends ObjetoDados{}
class TextoBD extends ManipulacaoDados{
	
	// ---- PROPRIEDADES -----
	public static $campos = array(
		array('nome' => 'txt_id',				'tipo' => 'num', 	'atributo' => 'Id', 	'extra' => 'primaria autoinc'),
		array('nome' => 'txt_tipo',				'tipo' => 'alfa', 	'atributo' => 'Tipo'),
		array('nome' => 'txt_titulo',			'tipo' => 'alfa', 	'atributo' => 'Titulo'),
		array('nome' => 'txt_descricao',		'tipo' => 'alfa', 	'atributo' => 'Descricao'),
		array('nome' => 'txt_conteudo',			'tipo' => 'alfa', 	'atributo' => 'Conteudo'),
		array('nome' => 'txt_regra',			'tipo' => 'alfa', 	'atributo' => 'Regra'),
		array('nome' => 'txt_msg_erro',			'tipo' => 'alfa', 	'atributo' => 'MsgErro'),
		array('nome' => 'txt_tooltip',			'tipo' => 'alfa', 	'atributo' => 'Tooltip'),
		array('nome' => 'txt_arquivo',			'tipo' => 'alfa', 	'atributo' => 'Arquivo'),
		array('nome' => 'txt_tipo_resposta',	'tipo' => 'alfa', 	'atributo' => 'TipoResposta'),
		array('nome' => 'txt_decimal',			'tipo' => 'alfa', 	'atributo' => 'Decimal'),
		array('nome' => 'txt_precisao',			'tipo' => 'num', 	'atributo' => 'Precisao'),
		array('nome' => 'txt_obrigatorio',		'tipo' => 'alfa', 	'atributo' => 'Obrigatorio'),
		array('nome' => 'txt_peso',				'tipo' => 'num', 	'atributo' => 'Peso'),
		array('nome' => 'txt_status',			'tipo' => 'alfa', 	'atributo' => 'Status')
	);
	public static $tabela = array('nome' => 'gnb_texto', 'classe' => 'Texto');
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
