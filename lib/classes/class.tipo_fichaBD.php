<?php
//inclui o arquivo da classe basica de manipulação de dados
require_once('class.manipulacao_dados.php');

class TipoFicha extends ObjetoDados{}
class TipoFichaBD extends ManipulacaoDados{
	
	// ---- PROPRIEDADES -----
	public static $campos = array(
		array('nome' => 'tfc_id',				'tipo' => 'num', 	'atributo' => 'Id', 		'extra' => 'primaria autoinc'),
		array('nome' => 'tfc_id_tfc',			'tipo' => 'num', 	'atributo' => 'Pai'),
		array('nome' => 'tfc_nome',				'tipo' => 'alfa', 	'atributo' => 'Nome'),
		array('nome' => 'tfc_nivel',			'tipo' => 'num', 	'atributo' => 'Nivel'),
		array('nome' => 'tfc_status',			'tipo' => 'alfa', 	'atributo' => 'Status')
	);
	public static $tabela = array('nome' => 'gnb_tipo_ficha', 'classe' => 'TipoFicha');
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
	//-----------------------------------------------------------------------------------------------
	public static function getNivel($id_pai){
		$retorno = 0;
		$oTipoFicha = TipoFichaBD::get($id_pai);
		if(is_object($oTipoFicha)){
			$retorno++;
			if($oTipoFicha->Pai > 0){
				$val_temp = TipoFichaBD::getNivel($oTipoFicha->Pai);
				$retorno = $retorno + $val_temp;
			}//if
		}//if
		echo "<br />[$id_pai / $retorno]";
		return intval($retorno);
	}//fnc
	//-----------------------------------------------------------------------------------------------
	public static function getListaOrdenada($id_pai,$nivel = 0, $cond_extra = ""){

		$arr_categoria = array();

        if($id_pai > 0){
            $condicao = "tfc_id_tfc = ".$id_pai;
        }else{
            $condicao = "tfc_id_tfc IS NULL OR tfc_id_tfc = 0";
            $nivel--;
        }//if

        $oListaTipoFicha = TipoFichaBD::getLista($condicao." ".$cond_extra,"tfc_nome");

        if(count($oListaTipoFicha)>0){
            $nivel++;

            foreach($oListaTipoFicha as $oTipoFicha){

            	$caminho 	= $oTipoFicha->Nome;
            	$objeto_pai = $oTipoFicha->Pai;

            	while(is_object($objeto_pai)){
            		$caminho = $objeto_pai->Nome."/".$caminho;
            		$objeto_pai = $objeto_pai->Pai;
            	}//wh

                $arr_categoria[] = array(
                    $oTipoFicha->Id,
                    $oTipoFicha->Pai,
                    $oTipoFicha->Nome,
                    $oTipoFicha->Nivel,//$nivel,
                    $caminho
                );

                $arr_temp = TipoFichaBD::getListaOrdenada($oTipoFicha->Id,$nivel,$cond_extra);

                $arr_categoria = array_merge($arr_categoria, $arr_temp);
            }//foreach
        }//if

        return $arr_categoria;
	}//fnc
	//-----------------------------------------------------------------------------------------------
}
?>
