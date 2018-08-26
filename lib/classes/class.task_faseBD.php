<?php
//inclui o arquivo da classe basica de manipulação de dados
require_once('class.manipulacao_dados.php');

class TaskFase extends ObjetoDados{}
class TaskFaseBD extends ManipulacaoDados{

	// ---- PROPRIEDADES -----
	public static $campos = array(
		array('nome' => 'tfs_id_tsk',			'tipo' => 'num', 	'atributo' => 'Task', 'extra' => 'primaria estrangeira', 'classe' => 'Task', 	'arquivo_classe' => 'class.taskBD.php'),
		array('nome' => 'tfs_id_fse',			'tipo' => 'num', 	'atributo' => 'Fase', 'extra' => 'primaria estrangeira', 'classe' => 'Fase', 	'arquivo_classe' => 'class.faseBD.php'),
		array('nome' => 'tfs_seq',				'tipo' => 'num', 	'atributo' => 'Seq'),
		array('nome' => 'tfs_dt_ini',			'tipo' => 'alfa', 	'atributo' => 'DtIni'),
		array('nome' => 'tfs_dt_fim',			'tipo' => 'alfa', 	'atributo' => 'DtFim'),
		array('nome' => 'tfs_dt_dif',			'tipo' => 'num', 	'atributo' => 'DtDif'),
		array('nome' => 'tfs_hr_ini',			'tipo' => 'alfa', 	'atributo' => 'HrIni'),
		array('nome' => 'tfs_hr_fim',			'tipo' => 'alfa', 	'atributo' => 'HrFim'),
		array('nome' => 'tfs_id_usr_in',		'tipo' => 'num', 	'atributo' => 'UsuarioIn', 		'extra' => 'estrangeira', 'classe' => 'Usuario', 	'arquivo_classe' => 'class.usuarioBD.php'),
		array('nome' => 'tfs_id_usr_out',		'tipo' => 'num', 	'atributo' => 'UsuarioOut', 	'extra' => 'estrangeira', 'classe' => 'Usuario', 	'arquivo_classe' => 'class.usuarioBD.php')
	);
	public static $tabela = array('nome' => 'gnb_task_fase', 'classe' => 'TaskFase');
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
