<?php
//inclui o arquivo da classe basica de manipulação de dados
require_once('class.manipulacao_dados.php');

class Usuario extends ObjetoDados{}
class UsuarioBD extends ManipulacaoDados{

	// ---- PROPRIEDADES -----
	public static $campos = array(
		array('nome' => 'usr_id',				'tipo' => 'num', 	'atributo' => 'Id', 	'extra' => 'primaria autoinc'),
		array('nome' => 'usr_id_cln',			'tipo' => 'num', 	'atributo' => 'Cliente' ,'extra' => 'estrangeira' , 'classe' => 'Cliente', 'arquivo_classe' => 'class.clienteBD.php'),
		array('nome' => 'usr_id_prf',			'tipo' => 'num', 	'atributo' => 'IdPrf'),
		array('nome' => 'usr_cpf',				'tipo' => 'alfa', 	'atributo' => 'Cpf'),
		array('nome' => 'usr_nome',				'tipo' => 'alfa', 	'atributo' => 'Nome'),
		array('nome' => 'usr_email',			'tipo' => 'alfa', 	'atributo' => 'Email'),
		array('nome' => 'usr_senha',			'tipo' => 'alfa', 	'atributo' => 'Senha'),
		array('nome' => 'usr_id_cdd',			'tipo' => 'num', 	'atributo' => 'Cidade' ,'extra' => 'estrangeira' , 'classe' => 'CidadeIbge', 'arquivo_classe' => 'class.cidade_ibgeBD.php' ),
		array('nome' => 'usr_uf',				'tipo' => 'alfa', 	'atributo' => 'Uf'),
		array('nome' => 'usr_tipo',				'tipo' => 'alfa', 	'atributo' => 'Tipo'),
		array('nome' => 'usr_supervisor',		'tipo' => 'alfa', 	'atributo' => 'Supervisor'),
		array('nome' => 'usr_status',			'tipo' => 'alfa', 	'atributo' => 'Status'),
		array('nome' => 'usr_flag_newsletter',	'tipo' => 'alfa', 	'atributo' => 'FlagNewsletter'),
		array('nome' => 'usr_dt_registro',		'tipo' => 'alfa', 	'atributo' => 'DtRegistro'),
		array('nome' => 'usr_hr_registro',		'tipo' => 'alfa', 	'atributo' => 'HrRegistro'),
		array('nome' => 'usr_confirmacao',		'tipo' => 'num', 	'atributo' => 'Confirmacao'),
		array('nome' => 'usr_todo',				'tipo' => 'num', 	'atributo' => 'Todo'),
		array('nome' => 'usr_dt_nasc',			'tipo' => 'alfa', 	'atributo' => 'DtNasc')
	);
	public static $tabela = array('nome' => 'gnb_usuario', 'classe' => 'Usuario');
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
