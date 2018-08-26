<?php
//inclui o arquivo da classe basica de manipulação de dados
require_once('class.manipulacao_dados.php');

class Atividade extends ObjetoDados{}
class AtividadeBD extends ManipulacaoDados{
	
	// ---- PROPRIEDADES -----
	public static $campos = array(
		array('nome' => 'atv_id',			'tipo' => 'num', 	'atributo' => 'Id', 			'extra' => 'primaria autoinc'),
		array('nome' => 'atv_id_cls',		'tipo' => 'num', 	'atributo' => 'Classificacao', 	'extra' => 'estrangeira', 'classe' => 'Classificacao', 'arquivo_classe' => 'class.classificacaoBD.php'),
		array('nome' => 'atv_id_are',		'tipo' => 'num', 	'atributo' => 'Area', 			'extra' => 'estrangeira', 'classe' => 'Area', 'arquivo_classe' => 'class.areaBD.php'),

		array('nome' => 'atv_id_agr',		'tipo' => 'num', 	'atributo' => 'AtividadeGrupo', 			'extra' => 'estrangeira', 'classe' => 'AtividadeGrupo', 'arquivo_classe' => 'class.atividade_grupoBD.php'),
		array('nome' => 'atv_id_asg',		'tipo' => 'num', 	'atributo' => 'AtividadeSubGrupo', 			'extra' => 'estrangeira', 'classe' => 'AtividadeSubGrupo', 'arquivo_classe' => 'class.atividade_subgrupoBD.php'),
		array('nome' => 'atv_id_importado',	'tipo' => 'num', 	'atributo' => 'IdImportado'),

		array('nome' => 'atv_descricao',	'tipo' => 'alfa', 	'atributo' => 'Descricao'),
		array('nome' => 'atv_cnae',			'tipo' => 'alfa', 	'atributo' => 'Cnae'),
		array('nome' => 'atv_codigo',		'tipo' => 'alfa', 	'atributo' => 'Codigo'),
		array('nome' => 'atv_status',		'tipo' => 'alfa', 	'atributo' => 'Status')
	);
	public static $tabela = array('nome' => 'gnb_atividade', 'classe' => 'Atividade');
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
