<?php
//inclui o arquivo da classe basica de manipulação de dados
require_once('class.manipulacao_dados.php');

class Ficha extends ObjetoDados{}
class FichaBD extends ManipulacaoDados{
	
	// ---- PROPRIEDADES -----
	public static $campos = array(
		array('nome' => 'fch_id',					'tipo' => 'num', 	'atributo' => 'Id', 		'extra' => 'primaria autoinc'),
		array('nome' => 'fch_id_frm',				'tipo' => 'num', 	'atributo' => 'Formulario',	'extra' => 'estrangeira', 'classe' => 'Formulario',  'arquivo_classe' => 'class.formularioBD.php'),
		array('nome' => 'fch_id_tfc',				'tipo' => 'num', 	'atributo' => 'TipoFicha',	'extra' => 'estrangeira', 'classe' => 'TipoFicha', 	 'arquivo_classe' => 'class.tipo_fichaBD.php'),
		array('nome' => 'fch_id_atv',				'tipo' => 'num', 	'atributo' => 'Atividade' , 'extra' => 'estrangeira', 'classe' => 'Atividade', 	 'arquivo_classe' => 'class.atividadeBD.php'),
		array('nome' => 'fch_id_cln',				'tipo' => 'num', 	'atributo' => 'Cliente', 	'extra' => 'estrangeira', 'classe' => 'Cliente', 	 'arquivo_classe' => 'class.clienteBD.php'),
		array('nome' => 'fch_id_cdd',				'tipo' => 'num', 	'atributo' => 'Cidade',		'extra' => 'estrangeira' , 'classe' => 'CidadeIbge', 'arquivo_classe' => 'class.cidade_ibgeBD.php' ),
		array('nome' => 'fch_id_mdl',				'tipo' => 'num', 	'atributo' => 'Modalidade', 'extra' => 'estrangeira', 'classe' => 'Modalidade',  'arquivo_classe' => 'class.modalidadeBD.php'),
		array('nome' => 'fch_id_emp',				'tipo' => 'num', 	'atributo' => 'IdEmp'),
		array('nome' => 'fch_id_usr',				'tipo' => 'num', 	'atributo' => 'Usuario', 	'extra' => 'estrangeira', 'classe' => 'Usuario', 	'arquivo_classe' => 'class.usuarioBD.php'),
		array('nome' => 'fch_id_usr_anl',			'tipo' => 'num', 	'atributo' => 'Analista', 	'extra' => 'estrangeira', 'classe' => 'Usuario', 	'arquivo_classe' => 'class.usuarioBD.php'),
		array('nome' => 'fch_id_prt',				'tipo' => 'num', 	'atributo' => 'IdPrt'),
		array('nome' => 'fch_dt_registro',			'tipo' => 'alfa', 	'atributo' => 'DtRegistro'),
		array('nome' => 'fch_hr_registro',			'tipo' => 'alfa', 	'atributo' => 'HrRegistro'),
		array('nome' => 'fch_ano',					'tipo' => 'num', 	'atributo' => 'Ano'),
		array('nome' => 'fch_status',				'tipo' => 'num', 	'atributo' => 'Status'),
		array('nome' => 'fch_status_andamento',		'tipo' => 'num', 	'atributo' => 'StatusAndamento'),
		array('nome' => 'fch_validacao_dados',		'tipo' => 'num', 	'atributo' => 'ValidacaoDados'),
		array('nome' => 'fch_status_fiscal',		'tipo' => 'alfa', 	'atributo' => 'StatusFiscal')
	);
	public static $tabela = array('nome' => 'gnb_ficha', 'classe' => 'Ficha');
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
	public static function getCurrentFicha($cln_id = 0, $usr_id = 0, $frm_id = 0){
		//------------------
		$ano_referencia = 0;
		//------------------
		if($frm_id == 0){
			$ano_referencia = intval(getVariavelConfig("AR"));
			$oListaFormulario = FormularioBD::getLista("frm_ano = ".$ano_referencia." AND frm_status = 'A'","frm_id");
			if(count($oListaFormulario)>0){
				$oFormulario = $oListaFormulario[0];
				$frm_id = $oFormulario->Id;
			}//if
			unset($oListaFormulario);
		}//if
		//------------------
		$paramCondicao = "fch_id_cln = ".$cln_id;
		if($frm_id > 0)$paramCondicao.= " AND fch_id_frm = ".$frm_id;
		if($usr_id > 0)$paramCondicao.= " AND fch_id_usr = ".$usr_id;
		if($ano_referencia > 0)$paramCondicao.= " AND fch_ano = ".$ano_referencia;
		//------------------
		//echo "[\$paramCondicao: ".$paramCondicao."]";
		//------------------
		$paramOrderBy  = "fch_id DESC";
		$oListaFicha = parent::getLista($paramCondicao, $paramOrderBy,0,1);
		//------------------
		if(count($oListaFicha)>0){
			return $oListaFicha[0];
		}else{
			return null;
		}//if
		//------------------
	}//fnc
	//-----------------------------------------------------------------------------------------------
	public function valCampo(&$objeto,$paramCondicao = ''){
		return parent::valCampo($objeto,$paramCondicao = '');
	}//pbl
}
?>
