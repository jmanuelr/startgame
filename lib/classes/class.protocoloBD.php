<?php
//inclui o arquivo da classe basica de manipulação de dados
require_once('class.manipulacao_dados.php');

class Protocolo extends ObjetoDados{}
class ProtocoloBD extends ManipulacaoDados{
	
	// ---- PROPRIEDADES -----
	public static $campos = array(
		array('nome' => 'prt_id',			'tipo' => 'num', 	'atributo' => 'Id', 		'extra' => 'primaria'),
		array('nome' => 'prt_id_cdd',		'tipo' => 'num', 	'atributo' => 'Cidade', 	'extra' => 'estrangeira', 'classe' => 'CidadeIbge', 'arquivo_classe' => 'class.cidade_ibgeBD.php'),
		array('nome' => 'prt_id_fch',		'tipo' => 'num', 	'atributo' => 'Ficha', 		'extra' => 'estrangeira', 'classe' => 'Ficha', 		'arquivo_classe' => 'class.fichaBD.php'),
		array('nome' => 'prt_numero',		'tipo' => 'num', 	'atributo' => 'Numero'),
		array('nome' => 'prt_stamp',		'tipo' => 'alfa', 	'atributo' => 'Stamp'),
		array('nome' => 'prt_dt_registro',	'tipo' => 'alfa', 	'atributo' => 'DtRegistro'),
		array('nome' => 'prt_hr_registro',	'tipo' => 'alfa', 	'atributo' => 'HrRegistro')
	);
	public static $tabela = array('nome' => 'gnb_protocolo', 'classe' => 'Protocolo');
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

		//adiciona o objeto ao banco de dados
	public static function getStamp($idcdd,$idldo){

		$oPrefeitura = PrefeituraBD::get($idcdd);

		$maxOrdem 	= parent::getCustomLista("prt_id_cdd = ".$idcdd, '', 'MAX(prt_numero) as atual', '', '', '', '', false);
		$atual 		= intval($maxOrdem[0]["atual"]);

		if($atual == 0){
			$proximo = intval($oPrefeitura->InicioSequencia);
			if($proximo==0)$proximo++;
		}else{
			$proximo	= intval($maxOrdem[0]["atual"]) + 1;
		}//if

        $carimbo	= $oPrefeitura->SiglaProtocolo . "" . str_pad($proximo, 10, "0", STR_PAD_LEFT);

		$oProtocolo = new Protocolo;
		
		$oProtocolo->Cidade 	= $idcdd;
		$oProtocolo->Laudo 		= $idldo;
		$oProtocolo->Numero 	= $proximo;
		$oProtocolo->Stamp 		= $carimbo;
		$oProtocolo->DtRegistro = date("Ymd");
		$oProtocolo->HrRegistro = date("H:i");

		$novo_id = parent::add($oProtocolo);

		$arr_retorno = array($novo_id, $carimbo);

		return $arr_retorno;
	}//fnc

}
?>
