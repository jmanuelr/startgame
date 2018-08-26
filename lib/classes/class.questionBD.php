<?php
//inclui o arquivo da classe basica de manipulação de dados
require_once('class.manipulacao_dados.php');

class Question extends ObjetoDados{}
class QuestionBD extends ManipulacaoDados{
	
	// ---- PROPRIEDADES -----
	public static $campos = array(
		array('nome' => 'qst_id',				'tipo' => 'num', 	'atributo' => 'Id', 	 'extra' => 'primaria autoinc'),
		array('nome' => 'qst_id_fse',			'tipo' => 'num', 	'atributo' => 'Fase', 	 'extra' => 'estrangeira', 'arquivo_classe' => 'class.faseBD.php'),
		array('nome' => 'qst_id_wrk',			'tipo' => 'num', 	'atributo' => 'Workflow', 'extra' => 'estrangeira', 'arquivo_classe' => 'class.workflowBD.php'),
		array('nome' => 'qst_id_cln',			'tipo' => 'num', 	'atributo' => 'Cliente', 'extra' => 'estrangeira', 'arquivo_classe' => 'class.clienteBD.php'),
		array('nome' => 'qst_id_usr',			'tipo' => 'num', 	'atributo' => 'Usuario', 'extra' => 'estrangeira', 'arquivo_classe' => 'class.usuarioBD.php'),
		array('nome' => 'qst_seq',				'tipo' => 'num', 	'atributo' => 'Seq'),
		array('nome' => 'qst_titulo',			'tipo' => 'alfa', 	'atributo' => 'Titulo'),
		array('nome' => 'qst_descricao',		'tipo' => 'alfa', 	'atributo' => 'Descricao'),
		array('nome' => 'qst_tipo',				'tipo' => 'alfa', 	'atributo' => 'Tipo'),
		array('nome' => 'qst_option',			'tipo' => 'alfa', 	'atributo' => 'Option'),
		array('nome' => 'qst_required',			'tipo' => 'alfa', 	'atributo' => 'Required'),
		array('nome' => 'qst_status',			'tipo' => 'alfa', 	'atributo' => 'Status')
	);
	public static $tabela = array('nome' => 'gnb_question', 'classe' => 'Question');
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
