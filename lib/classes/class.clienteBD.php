<?php
//inclui o arquivo da classe basica de manipulação de dados
require_once('class.manipulacao_dados.php');

class Cliente extends ObjetoDados{}
class ClienteBD extends ManipulacaoDados{
	
	// ---- PROPRIEDADES -----
	public static $campos = array(
		array('nome' => 'cln_id',						'tipo' => 'num', 	'atributo' => 'Id', 	'extra' => 'primaria autoinc'),
		array('nome' => 'cln_id_cln',					'tipo' => 'num', 	'atributo' => 'Cliente', 'extra' => 'estrangeira', 'classe' => 'Cliente', 'arquivo_classe' => 'class.clienteBD.php'),
		array('nome' => 'cln_id_usr',					'tipo' => 'num', 	'atributo' => 'Usuario', 'extra' => 'estrangeira', 'classe' => 'Usuario', 'arquivo_classe' => 'class.usuarioBD.php'),
		array('nome' => 'cln_tipo',						'tipo' => 'alfa', 	'atributo' => 'Tipo'),
		array('nome' => 'cln_cnpj_cpf',					'tipo' => 'alfa', 	'atributo' => 'CnpjCpf'),
		array('nome' => 'cln_nome',						'tipo' => 'alfa', 	'atributo' => 'Nome'),
		array('nome' => 'cln_razao_social',				'tipo' => 'alfa', 	'atributo' => 'RazaoSocial'),
		array('nome' => 'cln_id_cdd',					'tipo' => 'num', 	'atributo' => 'Cidade' ,'extra' => 'estrangeira' , 'classe' => 'CidadeIbge', 'arquivo_classe' => 'class.cidade_ibgeBD.php' ),
		array('nome' => 'cln_uf',						'tipo' => 'alfa', 	'atributo' => 'Uf'),
		array('nome' => 'cln_end_rua',					'tipo' => 'alfa', 	'atributo' => 'EndRua'),
		array('nome' => 'cln_end_nro',					'tipo' => 'alfa', 	'atributo' => 'EndNro'),
		array('nome' => 'cln_end_compl',				'tipo' => 'alfa', 	'atributo' => 'EndCompl'),
		array('nome' => 'cln_end_cep',					'tipo' => 'alfa', 	'atributo' => 'EndCep'),
		array('nome' => 'cln_bairro',					'tipo' => 'alfa', 	'atributo' => 'Bairro'),
		array('nome' => 'cln_fone',						'tipo' => 'alfa', 	'atributo' => 'Fone'),
		array('nome' => 'cln_tipo_assinatura',			'tipo' => 'alfa', 	'atributo' => 'TipoAssinatura'),//Tipo Cliente: [R]egistrado | [A]ssinante
		array('nome' => 'cln_id_reg',					'tipo' => 'num', 	'atributo' => 'Regiao', 	'extra' => 'estrangeira', 'classe' => 'Regiao', 	'arquivo_classe' => 'class.regiaoBD.php'),
		array('nome' => 'cln_id_atv',					'tipo' => 'num', 	'atributo' => 'Atividade', 	'extra' => 'estrangeira', 'classe' => 'Atividade', 	'arquivo_classe' => 'class.atividadeBD.php'),
		array('nome' => 'cln_num_empregados_anterior',	'tipo' => 'num', 	'atributo' => 'NumEmpregadosAnterior'),
		array('nome' => 'cln_id_prt',					'tipo' => 'num', 	'atributo' => 'PorteEmpresa', 	'extra' => 'estrangeira', 'classe' => 'PorteEmpresa', 	'arquivo_classe' => 'class.porte_empresaBD.php'),
		array('nome' => 'cln_relacao_parceiro',			'tipo' => 'alfa', 	'atributo' => 'RelacaoParceiro'),
		array('nome' => 'cln_parceiros',				'tipo' => 'alfa', 	'atributo' => 'Parceiros'),
		array('nome' => 'cln_autoriza_divulgacao',		'tipo' => 'alfa', 	'atributo' => 'AutorizaDivulgacao'),
		array('nome' => 'cln_dt_cadastro',				'tipo' => 'alfa', 	'atributo' => 'DtCadastro'),
		array('nome' => 'cln_hr_cadastro',				'tipo' => 'alfa', 	'atributo' => 'HrCadastro'),
		array('nome' => 'cln_obs',						'tipo' => 'alfa', 	'atributo' => 'Obs'),
		array('nome' => 'cln_id_mdl',					'tipo' => 'num', 	'atributo' => 'Modalidade', 'extra' => 'estrangeira', 'classe' => 'Modalidade', 'arquivo_classe' => 'class.modalidadeBD.php'),
		array('nome' => 'cln_validacao_dados',			'tipo' => 'num', 	'atributo' => 'ValidacaoDados'),
		array('nome' => 'cln_status',					'tipo' => 'alfa', 	'atributo' => 'Status'),
		array('nome' => 'cln_int_pagamento',			'tipo' => 'num', 	'atributo' => 'IntPagamento'),
		array('nome' => 'cln_dt_venc_anuidade',			'tipo' => 'alfa', 	'atributo' => 'DtVencAnuidade'),
		array('nome' => 'cln_id_ffn',					'tipo' => 'num', 	'atributo' => 'FaixaFuncionario', 'extra' => 'estrangeira', 'classe' => 'FaixaFuncionario', 'arquivo_classe' => 'class.faixa_funcionarioBD.php'),
		array('nome' => 'cln_pipedrive_token',			'tipo' => 'alfa', 	'atributo' => 'PipedriveToken')
	);
	public static $tabela = array('nome' => 'gnb_cliente', 'classe' => 'Cliente');
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
