<?php
//inclui o arquivo da classe basica de manipulação de dados
require_once('class.manipulacao_dados.php');

class Resultado extends ObjetoDados{}
class ResultadoBD extends ManipulacaoDados{
	
	// ---- PROPRIEDADES -----
	public static $campos = array(
		array('nome' => 'rst_id',			'tipo' => 'num', 	'atributo' => 'Id', 			'extra' => 'primaria autoinc'),
		array('nome' => 'rst_id_usr',		'tipo' => 'num', 	'atributo' => 'Usuario', 	'extra' => 'estrangeira', 'classe' => 'Usuario', 'arquivo_classe' => 'class.usuarioBD.php'),
		array('nome' => 'rst_id_exm',		'tipo' => 'num', 	'atributo' => 'Exame', 		'extra' => 'estrangeira', 'classe' => 'Exame', 'arquivo_classe' => 'class.exameBD.php'),
		array('nome' => 'rst_id_ant',		'tipo' => 'num', 	'atributo' => 'Antropometria', 		'extra' => 'estrangeira', 'classe' => 'Antropometria', 'arquivo_classe' => 'class.antropometriaBD.php'),
		array('nome' => 'rst_nome',			'tipo' => 'alfa', 	'atributo' => 'Nome'),
		array('nome' => 'rst_valor',		'tipo' => 'alfa', 	'atributo' => 'Valor'),
		array('nome' => 'rst_string',		'tipo' => 'alfa', 	'atributo' => 'String'),
		array('nome' => 'rst_status',		'tipo' => 'alfa', 	'atributo' => 'Status')
	);
	public static $tabela = array('nome' => 'gnb_resultado', 'classe' => 'Resultado');
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
