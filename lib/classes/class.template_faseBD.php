<?php
//inclui o arquivo da classe basica de manipulação de dados
require_once('class.manipulacao_dados.php');

class TemplateFase extends ObjetoDados{}
class TemplateFaseBD extends ManipulacaoDados{

	// ---- PROPRIEDADES -----
	public static $campos = array(
		array('nome' => 'tfs_id_tmp',			'tipo' => 'num', 	'atributo' => 'Template', 	'extra' => 'primaria estrangeira', 'arquivo_classe' => 'class.templateBD.php'),
		array('nome' => 'tfs_id_fse',			'tipo' => 'num', 	'atributo' => 'Fase',		'extra' => 'primaria estrangeira', 'arquivo_classe' => 'class.faseBD.php'),
		array('nome' => 'tfs_id_wrk',			'tipo' => 'num', 	'atributo' => 'Workflow', 	'extra' => 'primaria estrangeira', 'arquivo_classe' => 'class.workflowBD.php'),
		array('nome' => 'tfs_seq',				'tipo' => 'num', 	'atributo' => 'Seq'),
		array('nome' => 'tfs_send_in',			'tipo' => 'alfa', 	'atributo' => 'SendIn'),
		array('nome' => 'tfs_send_out',			'tipo' => 'alfa', 	'atributo' => 'SendOut'),
		array('nome' => 'tfs_send_time',		'tipo' => 'num', 	'atributo' => 'SendTime'),
		array('nome' => 'tfs_send_team',		'tipo' => 'alfa', 	'atributo' => 'SendTeam'),
		array('nome' => 'tfs_send_resp',		'tipo' => 'alfa', 	'atributo' => 'SendResp'),
		array('nome' => 'tfs_send_cln',			'tipo' => 'alfa', 	'atributo' => 'SendCln'),
		array('nome' => 'tfs_send_mail',		'tipo' => 'alfa', 	'atributo' => 'SendMail')
	);
	public static $tabela = array('nome' => 'gnb_template_fase', 'classe' => 'TemplateFase');
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
