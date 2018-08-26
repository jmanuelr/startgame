<?php
//inclui o arquivo da classe basica de manipulação de dados
require_once('class.manipulacao_dados.php');

class LayoutFicha extends ObjetoDados{}
class LayoutFichaBD extends ManipulacaoDados{
	
	// ---- PROPRIEDADES -----
	public static $campos = array(
		array('nome' => 'lfc_id_fch',		'tipo' => 'num', 	'atributo' => 'Ficha', 		'extra' => 'primaria estrangeira', 'classe' => 'Ficha', 	'arquivo_classe' => 'class.fichaBD.php'),
		array('nome' => 'lfc_id_txt',		'tipo' => 'num', 	'atributo' => 'Texto', 		'extra' => 'primaria estrangeira', 'classe' => 'Texto', 	'arquivo_classe' => 'class.textoBD.php'),
		array('nome' => 'lfc_id_pai',		'tipo' => 'num', 	'atributo' => 'Topico', 	'extra' => 'primaria estrangeira', 'classe' => 'Topico',	'arquivo_classe' => 'class.textoBD.php'),//apenas para agrupar em abas (topicos)
		array('nome' => 'lfc_ordem',		'tipo' => 'num', 	'atributo' => 'Ordem'),
		array('nome' => 'lfc_tipo',			'tipo' => 'alfa', 	'atributo' => 'Tipo'),
		array('nome' => 'lfc_mostrar',		'tipo' => 'alfa', 	'atributo' => 'Mostrar')
	);
	public static $tabela = array('nome' => 'gnb_layout_ficha', 'classe' => 'LayoutFicha');
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
