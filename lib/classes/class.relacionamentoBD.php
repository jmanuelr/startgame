<?php
//inclui o arquivo da classe basica de manipulação de dados
require_once('class.manipulacao_dados.php');

class Relacionamento extends ObjetoDados{}
class RelacionamentoBD extends ManipulacaoDados{
	
	// ---- PROPRIEDADES -----
	public static $campos = array(
		array('nome' => 'rlc_id',				'tipo' => 'num', 	'atributo' => 'Id', 	'extra' => 'primaria'),
		array('nome' => 'rlc_tabela',			'tipo' => 'alfa', 	'atributo' => 'Tabela', 'extra' => 'primaria'),
		array('nome' => 'rlc_id_cdd',			'tipo' => 'num', 	'atributo' => 'Cidade', 'extra' => 'primaria estrangeira', 'classe' => 'CidadeIbge', 'arquivo_classe' => 'class.cidade_ibgeBD.php'),
		array('nome' => 'rlc_uf',				'tipo' => 'alfa', 	'atributo' => 'Uf', 	'extra' => 'primaria'),
		array('nome' => 'rlc_tipo',				'tipo' => 'alfa', 	'atributo' => 'Tipo', 	'extra' => 'primaria'),
		array('nome' => 'rlc_id_tipo',			'tipo' => 'num', 	'atributo' => 'IdTipo', 'extra' => 'primaria')
	);
	public static $tabela = array('nome' => 'gnb_relacionamento', 'classe' => 'Relacionamento');
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
