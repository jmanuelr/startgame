<?php
//inclui o arquivo da classe AcessoBanco
require_once('class.acessobanco.php');

//###############################################################################################################
//######################### CLASSE DO OBJETO QUE ARMAZENA O REGISTRO DE BANCO DE DADOS  #########################
//###############################################################################################################
class ObjetoDados{

	//atributos da classe
	public $atributos = array();//private
	private $arquivo_relacao = array();
	private $classes = array();

	//metodo construtor da classe table_exemplo
	public function __construct(){
		$atributosClass = get_class_vars(get_class($this).'BD');
	    foreach($atributosClass['campos'] as $key ){
			if ($key['tipo'] == 'num'){
	    		$this->atributos[$key['atributo']] = 0;
				if ((isset($key['extra'])) && (strpos($key['extra'],'estrangeira') !== FALSE)){
					$this->atributos['_'.$key['atributo']] = 0;
				}
			} else {
	    		$this->atributos[$key['atributo']] = '';
				if ((isset($key['extra'])) && (strpos($key['extra'],'estrangeira') !== FALSE)){
					$this->atributos['_'.$key['atributo']] = '';
				}
			}

			if ((isset($key['extra'])) && (strpos($key['extra'],'estrangeira') !== FALSE)){
				$this->arquivo_relacao[$key['atributo']] = $key['arquivo_classe'];
				$this->arquivo_relacao['_'.$key['atributo']] = $key['arquivo_classe'];
			} else {
				$this->arquivo_relacao[$key['atributo']] = 0;
			}

			if (isset($key['classe'])){
				$this->classes[$key['atributo']] = $key['classe'];
			} else {
				$this->classes[$key['atributo']] = "";
			}
		}
	}

	//Inicio - Faz as chamadas dos metodos de visualizacao e atribuicao de propriedades
    public function __get($nm) {
		if (isset($this->atributos[$nm])){
			if (isset($this->arquivo_relacao[$nm])){
				if (($this->arquivo_relacao[$nm]) && (substr($nm,0,1) != "_")){
		        	return $this->getAtributoRelacionado($nm);
				} else {
	        		return $this->getAtributo($nm);
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
    }

	public function __set($nm, $val) {
		if ($this->arquivo_relacao[$nm]){
	        return $this->setAtributoRelacionado($nm, $val);
		} else {
	        return $this->setAtributo($nm, $val);
		}
    }

    public function __isset($nm) {
        return isset($this->atributos[$nm]);
    }

    public function __unset($nm) {
        unset($this->atributos[$nm]);
    }

	//Fim - Faz as chamadas dos metodos de visualizacao e atribuicao de propriedades

	//metodos da classe
	//-------- atributo simples --------
	public function setAtributo($attribSet, $paramSet){
		$this->atributos[$attribSet] = $paramSet;
		return true;
	}

	public function getAtributo($attribGet){
		return $this->atributos[$attribGet];
	}
	//----------------------------

	//-------- atributo relacionado --------
	public function setAtributoRelacionado($attribSet, $paramSet){
		$this->atributos['_'.$attribSet] = $paramSet;
		$this->atributos[$attribSet] = $paramSet;
		return true;
	}

	public function getAtributoRelacionado($attribGet){
		if ((!is_object($this->atributos[$attribGet])) && ($this->atributos[$attribGet] != '') && ($this->atributos[$attribGet] != 0)){
			// inclusao do arquivo de classe TableExemploBD
			require_once($this->arquivo_relacao[$attribGet]);
			if(!empty($this->classes["$attribGet"])){
				//echo "\$this->atributos[\"$attribGet\"] = ".$this->classes[$attribGet]."BD::get({$this->atributos[$attribGet]});";
				eval("\$this->atributos[\"$attribGet\"] = ".$this->classes[$attribGet]."BD::get({$this->atributos[$attribGet]});");
			}else{
				eval("\$this->atributos[\"$attribGet\"] = {$attribGet}BD::get({$this->atributos[$attribGet]});");
			}
		}
		return $this->atributos[$attribGet];
	}
	//----------------------------

}//fim da classe


//###############################################################################################################
//######################### CLASSE DE MANIPULA��O DOS DADOS DO OBJETO DE BANCO DE DADOS #########################
//###############################################################################################################
abstract class ManipulacaoDados{

	// ---- METODOS -----
	//metodo construtor da classe BD
	public function __construct(){
	}

//---------------------------------------------------------------------------------------------------------------
	//retorna o array dos campos da classe filha
	protected function camposFilho(){
        $bt = debug_backtrace();
		$class_filha = '';
		$campos = array();
		for ($idx=0;$idx < sizeof($bt);$idx++){
			if ((isset($bt[$idx]['class'])) && ($bt[$idx]['class'] != 'ManipulacaoDados')){
		        $class_filha = $bt[$idx]['class'];
				break;
			}
		}
        if ($class_filha != '') $campos = get_class_vars($class_filha);
		return $campos;
	}

//---------------------------------------------------------------------------------------------------------------
	//retorna o valor do campo tratado para o sql
	protected function valCampo(&$objeto, $idxCampo){
		//determina a classe derivada
        $static = self::camposFilho();

		$valor = $objeto->{$static['campos'][$idxCampo]['atributo']};

		// Trata a caracter de escape e s� coloca um se vier duplicado
		if(strpos(str_replace("\\\\",'',$valor),"\\")!=false)
			$valor = addslashes($valor);
		if(strpos(str_replace("\'",'',$valor),"'")!=false)
			$valor = addslashes($valor);

		// Traba as aspas simples para os strings
		if ($static['campos'][$idxCampo]['tipo'] == 'alfa')
			$valor = "'".$valor."'";

		return $valor;
	}

//---------------------------------------------------------------------------------------------------------------
	//retorna o valor passado por parametro segundo tipo do campo expecificado
	protected static function trataValorCampo($valor, $idxCampo){
		//determina a classe derivada
        $static = self::camposFilho();

		// Trata a caracter de escape e s� coloca um se vier duplicado
		if(strpos(str_replace("\\\\",'',$valor),"\\")!=false)
			$valor = addslashes($valor);
		if(strpos(str_replace("\'",'',$valor),"'")!=false)
			$valor = addslashes($valor);

		// Traba as aspas simples para os strings
		if ($static['campos'][$idxCampo]['tipo'] == 'alfa')
			$valor = "'".$valor."'";

		return $valor;
	}

//---------------------------------------------------------------------------------------------------------------
	//retorna uma lista de objetos
	public static function getLista($paramCondicao = '', $paramOrderBy = '', $startRs = '', $maxRs = ''){

		//determina a classe derivada
        $static = self::camposFilho();

		//inicializa��o
		$listaObjetos = '';

		//instancia o objeto AcessoBanco
		$acessoBanco = new AcessoBanco();

		//monta a estrutura de valores para passar por parametro
		$campos = '';
		$condicao = '';
		$idx_arg = 0;

		if (sizeof($static['campos']) > 0){
			//monta campos
			for ($idx = 0; $idx < sizeof($static['campos']); $idx++){
				if ($campos != '') $campos .= ', ';
				$campos .= $static['campos'][$idx]['nome'];
			}

			//pega a lista de registros
			$resultado = $acessoBanco->selectRegistro($static['tabela']['nome'], $campos, $paramCondicao, $paramOrderBy, $startRs, $maxRs);

			//gera a lista de objetos
			$listaObjetos = self::geraArrayObjeto($resultado);

		}
		//destroi objeto
		unset($acessoBanco);

		return $listaObjetos;

	}


//---------------------------------------------------------------------------------------------------------------
	//retorna uma lista de objetos com a consulta personalizada
	public static function getCustomLista($paramCondicao = '', $paramOrderBy = '', $paramCampo = '', $paramTabela = '', $paramGroupBy = '', $startRs = '', $maxRs = '', $boolGeraObj = true){

		//determina a classe derivada
        $static = self::camposFilho();

		//inicializa��o
		$listaObjetos = '';

		//-------- monta a estrutura de valores para passar por parametro ao SQL ---------
		$campos = '';
		$condicao = '';
		$groupBy = '';
		$idx_arg = 0;

		//atribui valor ao FROM do SQL
		$sqlFrom = $static['tabela']['nome'];
		if ($paramTabela != ''){
			$sqlFrom .= ' '.$paramTabela;
		}

		//atribui campos do SQL
		if ($paramCampo != '') {
			$campos = $paramCampo;
		} elseif (sizeof($static['campos']) > 0){
			//monta campos
			for ($idx = 0; $idx < sizeof($static['campos']); $idx++){
				if ($campos != '') $campos .= ', ';
				$campos .= $static['campos'][$idx]['nome'];
			}
		}

		//monta e attribui GROUP BY no SQL se existir refer�ncia no par�metro
		if ($paramGroupBy != '') {
			$groupBy = ' GROUP BY '.$paramGroupBy;
		}

		//instancia o objeto AcessoBanco
		$acessoBanco = new AcessoBanco();

		if (!empty($campos)){
			//pega a lista de registros
			$resultado = $acessoBanco->selectRegistro($sqlFrom, $campos, $paramCondicao.$groupBy, $paramOrderBy, $startRs, $maxRs);

			if ($boolGeraObj) {
				//if ($paramCampo != '') {
					//$listaObjetos = 'Fun��o n�o finalizada';
				//} else {
					// //gera a lista de objetos
					$listaObjetos = self::geraArrayObjeto($resultado);
				//}
			}else{
				$listaObjetos = $resultado;
			}//if
		} else {
			echo '<strong>ERRO DE CLASSE: </strong>Nenhum campo foi encotrado para a tabela da Classe!';
		}
		//destroi objeto
		unset($acessoBanco);

		return $listaObjetos;
	}
//---------------------------------------------------------------------------------------------------------------
	//metodo que recebe um array de CatalogoTmp e retorna um array de objeto CatalogoTmp
	private static function geraArrayObjeto($paramLista){

		//determina a classe derivada
        $static = self::camposFilho();

		$i = 0;
		$array_objetos = array();
		foreach ($paramLista as $indiceArray => $array_registro) {
			//instancia o objeto CatalogoTmp
			eval("\$objeto = new ".$static['tabela']['classe'].'();');
			for ($idx = 0; $idx < sizeof($static['campos']); $idx++){
					if (($static['campos'][$idx]['tipo'] == 'num') && ($array_registro[$static['campos'][$idx]['nome']] == '')){
						$objeto->{$static['campos'][$idx]['atributo']} = 'NULL';
					} else {
						$objeto->{$static['campos'][$idx]['atributo']} = $array_registro[$static['campos'][$idx]['nome']];
					}
			}

			//seta no array de CatalogoTmp
			$array_objetos[$i] = $objeto;
			$i++;
		}
		return $array_objetos;

	}

//---------------------------------------------------------------------------------------------------------------
	//retorna um objeto
	public static function get($array_param){

		//determina a classe derivada
		$static = self::camposFilho();

 		//inicializa��o
		$objeto = '';

		//instancia o objeto AcessoBanco
		$acessoBanco = new AcessoBanco();

		//monta a estrutura de valores para passar por parametro
		$campos = '';
		$condicao = '';
		$idx_arg = 0;
		if (sizeof($static['campos']) > 0){
			//monta campos
			for ($idx = 0; $idx < sizeof($static['campos']); $idx++){
				if ($campos != '') $campos .= ', ';
				$campos .= $static['campos'][$idx]['nome'];

				//monta a condicao com os campos que s�o chaves primarias
				if (isset($static['campos'][$idx]['extra']) && (strpos($static['campos'][$idx]['extra'],'primaria') !== false)){
					if ($condicao != '') $condicao .= ' AND ';
					$condicao .= $static['campos'][$idx]['nome'] . ' = ' . self::trataValorCampo($array_param[$idx_arg],$idx);
					$idx_arg++;
				}
			}

			//pega a lista de registros CatalogoTmp
			$resultado = $acessoBanco->selectRegistro($static['tabela']['nome'], $campos, $condicao);

			//verifica se retornou um resultado
			if(sizeof($resultado) > 0){
//SOLTESTE - NA LINHA ABAIXO � POSSIVEL QUE TENHA QUE PASSAR OS CAMPOS PARA A CLASSE CRIADA DENTRO DOS PARENTESES
				eval("\$objeto = new ".$static['tabela']['classe'].'();');
				for ($idx = 0; $idx < sizeof($static['campos']); $idx++){
					if (($static['campos'][$idx]['tipo'] == 'num') && ($resultado[0][$static['campos'][$idx]['nome']] == '')){
						$objeto->{$static['campos'][$idx]['atributo']} = 'NULL';
					} else {
						$objeto->{$static['campos'][$idx]['atributo']} = $resultado[0][$static['campos'][$idx]['nome']];
						if (isset($static['campos'][$idx]['extra']) && (strpos($static['campos'][$idx]['extra'],'estrangeira') !== false)){
							$objeto->{"_".$static['campos'][$idx]['atributo']} = $resultado[0][$static['campos'][$idx]['nome']];
						}
					}
				}
			}
		} else {
			die('<strong>ERRO DE CLASSE: </strong>Nenhum campo foi encotrado para a tabela da Classe!');
		}

		//destroi objeto
		unset($acessoBanco);

		return $objeto;
	}

//---------------------------------------------------------------------------------------------------------------
	public static function alter(&$objeto){
		//inicializacao
		$erro_bd = 0;

		//determina a classe derivada
        $static = self::camposFilho();

		//testa se � a classe declarada na tabela
		if (get_class($objeto) == $static['tabela']['classe']){

			//instancia o objeto AcessoBanco
			$acessoBanco = new AcessoBanco();

			//monta a estrutura de valores para passar por parametro
			$campos = '';
			$condicao = '';
			if (sizeof($static['campos']) > 0){
				//monta os campos
				for ($idx = 0; $idx < sizeof($static['campos']); $idx++){

					if ($campos != '') $campos .= ', ';

					if (strpos($static['campos'][$idx]['extra'],'estrangeira') !== false){
						$pos_ini = strpos($static['campos'][$idx]['extra'],'estrangeira');
						$pos_fim = strpos($static['campos'][$idx]['extra'],' ',$pos_ini);
						if ($pos_fim == 0) $pos_fim = strlen($static['campos'][$idx]['extra']);

						$str_estrangeira = substr($static['campos'][$idx]['extra'],$pos_ini,$pos_fim - $pos_ini);
						list($tmp,$str_parametro) = split(':', $str_estrangeira);

						if ($str_parametro == 'valida'){
							if (($static['campos'][$idx]['tipo'] != 'num') || (($static['campos'][$idx]['tipo'] == 'num') && ($objeto->{'_'.$static['campos'][$idx]['atributo']} != 'NULL'))) {
								if (!is_object($objeto->{$static['campos'][$idx]['atributo']})){
									$erro_bd = 1216;
									break;
								}
							}
						}

						$campos .= $static['campos'][$idx]['nome'] . ' = ' . self::trataValorCampo($objeto->{'_'.$static['campos'][$idx]['atributo']}, $idx);
					} else {
						$campos .= $static['campos'][$idx]['nome'] . ' = ' . self::valCampo($objeto, $idx);
					}

					//monta a condicao com os campos que s�o chaves primarias
					if (isset($static['campos'][$idx]['extra']) && (strpos($static['campos'][$idx]['extra'],'primaria') !== false)){
						if ($condicao != '') $condicao .= ' AND ';
						if (strpos($static['campos'][$idx]['extra'],'estrangeira') !== false){
							$condicao .= $static['campos'][$idx]['nome'] . ' = ' . self::trataValorCampo($objeto->{'_'.$static['campos'][$idx]['atributo']}, $idx);
						} else {
							$condicao .= $static['campos'][$idx]['nome'] . ' = ' . self::valCampo($objeto, $idx);
						}
					}
				}

				if ($erro_bd == 0){
					//altera o Banco de Dados
					$resultado = $acessoBanco->updateRegistro($static['tabela']['nome'], $campos, $condicao);

					if ($resultado){
						$retorno = 1;
					} else {
						$retorno = '-'.$acessoBanco->erroNo;
					}
				} else {
					$retorno = '-'.$erro_bd;
				}
			} else {
				die('<strong>ERRO DE CLASSE: </strong>Nenhum campo foi encotrado para a tabela da Classe!');
			}

			//destroi objeto
			unset($acessoBanco);
		} else {
			print_r($objeto);
			die('1) Classe chamada inv�lida! '.get_class($objeto).'!='.$static['tabela']['classe']);
			$retorno = 0;
		}

		//retorna o n�mero do ID ou o Erro (codigo negativo)
		return $retorno;
	}

//---------------------------------------------------------------------------------------------------------------
	//adiciona o objeto ao banco de dados
	public static function add(&$objeto){
		//inicializacao
		$erro_bd = 0;

		//determina a classe derivada
        $static = self::camposFilho();

		//teste se � a classe declarada na tabela
		if (get_class($objeto) == $static['tabela']['classe']){

			//instancia o objeto AcessoBanco
			$acessoBanco = new AcessoBanco();

			//mota a estrutura de valores para passar por parametro
			$campos = '';
			$valor = '';
			if (sizeof($static['campos']) > 0){
				//monta campos
				for ($idx = 0; $idx < sizeof($static['campos']); $idx++){
					if (
						(
						!isset($static['campos'][$idx]['extra'])
						|| (strpos($static['campos'][$idx]['extra'],'autoinc') === false || $objeto->{"Id"} > 0)
						)&&( strpos($static['campos'][$idx]['extra'],'readonly') === false )
					){
						if ($campos != '') $campos .= ', ';
						$campos .= $static['campos'][$idx]['nome'];

						if (isset($static['campos'][$idx]['extra']) && (strpos($static['campos'][$idx]['extra'],'estrangeira') !== false)){
							$pos_ini = strpos($static['campos'][$idx]['extra'],'estrangeira');
							$pos_fim = strpos($static['campos'][$idx]['extra'],' ',$pos_ini);
							if ($pos_fim == 0) $pos_fim = strlen($static['campos'][$idx]['extra']);

							$str_estrangeira = substr($static['campos'][$idx]['extra'],$pos_ini,$pos_fim - $pos_ini);
							if (strpos($str_estrangeira,":") !== false)
								list($tmp,$str_parametro) = split(':', $str_estrangeira);
							else
								$str_parametro = "";

							if ($str_parametro == 'valida'){
								if (($static['campos'][$idx]['tipo'] != 'num') || (($static['campos'][$idx]['tipo'] == 'num') && ($objeto->{'_'.$static['campos'][$idx]['atributo']} != 'NULL'))) {
									if (!is_object($objeto->{$static['campos'][$idx]['atributo']})){
										$erro_bd = 1216;
										break;
									}
								}
							}

							if ($valor != '') $valor .= ', ';
							$valor .= self::trataValorCampo($objeto->{'_'.$static['campos'][$idx]['atributo']}, $idx);
						} else {
							if ($valor != '') $valor .= ', ';
							$valor .= self::valCampo($objeto, $idx);
						}
					}
				}

				if ($erro_bd == 0){
					//inseri no Banco de Dados
					$resultado = $acessoBanco->insertRegistro($static['tabela']['nome'], $campos, $valor);
					if ($resultado){
						$retorno = ($acessoBanco->getInsertId()>0)?$acessoBanco->getInsertId():1;
						for ($idx = 0; $idx < sizeof($static['campos']); $idx++){
							if (isset($static['campos'][$idx]['extra']) && (strpos($static['campos'][$idx]['extra'],'autoinc') !== false)){
								$objeto->{$static['campos'][$idx]['atributo']} = $acessoBanco->getInsertId();
							}
						}
					} else {
						$retorno = '-'.$acessoBanco->erroNo;
					}
				} else {
					$retorno = '-'.$erro_bd;
				}

			} else {
				die('<strong>ERRO DE CLASSE: </strong>Nenhum campo foi encotrado para a tabela da Classe!');
			}
			//destroi objeto
			unset($acessoBanco);
		} else {
			die('2) Classe chamada inv�lida! '.get_class($objeto).'!='.$static['tabela']['classe']);
			$retorno = 0;
		}
		//retorna o n�mero do novo ID ou o Erro (codigo negativo)
		return $retorno;
	}

//---------------------------------------------------------------------------------------------------------------
	//deleta o objeto do banco de dados
	public static function del(&$objeto){

		//determina a classe derivada
        $static = self::camposFilho();

		//instancia o objeto AcessoBanco
		$acessoBanco = new AcessoBanco();

		//monta a condicao com os campos que s�o chaves primarias
		$condicao = '';
		for ($idx = 0; $idx < sizeof($static['campos']); $idx++){
			if (isset($static['campos'][$idx]['extra']) && (strpos($static['campos'][$idx]['extra'],'primaria') !== false)){
				if ($condicao != '') $condicao .= ' AND ';
				if (strpos($static['campos'][$idx]['extra'],'estrangeira') !== false){
					$condicao .= $static['campos'][$idx]['nome'] . ' = ' . self::trataValorCampo($objeto->{'_'.$static['campos'][$idx]['atributo']}, $idx);
				} else {
					$condicao .= $static['campos'][$idx]['nome'] . ' = ' . self::valCampo($objeto, $idx);
				}
			}
		}

		//exclui do Banco de Dados
		$resultado = $acessoBanco->deleteRegistro($static['tabela']['nome'], $condicao);
		if ($resultado){
			$retorno = 1;
		} else {
			$retorno = '-'.$acessoBanco->erroNo;
		}

		//destroi objeto
		unset($acessoBanco);

		//retorna verdadeiro ou o Erro (codigo negativo)
		return $retorno;
	}

//---------------------------------------------------------------------------------------------------------------
	//deleta o objeto do banco de dados
	public static function truncateTable(){
        $static = self::camposFilho();
		$acessoBanco = new AcessoBanco();
		$resultado = $acessoBanco->truncateTable($static['tabela']['nome']);
		if ($resultado){
			$retorno = 1;
		} else {
			$retorno = '-'.$acessoBanco->erroNo;
		}
		unset($acessoBanco);
		return $retorno;
	}

//---------------------------------------------------------------------------------------------------------------
	//deleta uma lista de objetos do banco de dados
	public static function delLista($paramCondicao = ''){

		//determina a classe derivada
        $static = self::camposFilho();

		//instancia o objeto AcessoBanco
		$acessoBanco = new AcessoBanco();

		if (sizeof($static['campos']) > 0){

			//pega a lista de registros
			if (paramCondicao != '')
				$resultado = $acessoBanco->deleteRegistro($static['tabela']['nome'], $paramCondicao);

		}
		//destroi objeto
		unset($acessoBanco);

		return $listaObjetos;
	}

	//---------------------------------------------------------------------------------------------------------------
	//adiciona o objeto ao banco de dados
	public static function addCustom($arr_campos_valores){
		//inicializacao
		$erro_bd = 0;

		//determina a classe derivada
        $static = self::camposFilho();

		//instancia o objeto AcessoBanco
		$acessoBanco = new AcessoBanco();

		$campos = "";
		$valores = "";
		$bool_proceder = false;

		if(is_array($arr_campos_valores)){

			foreach($arr_campos_valores as $this_campo => $this_valor){

				if ($campos != "") $campos .= ", ";
				$campos .= $this_campo;

				if ($valores != "") $valores .= ", ";
				$valores .= $this_valor;

				$bool_proceder = true;

			}//foreach

			if ($bool_proceder){
				//inseri no Banco de Dados
				$resultado = $acessoBanco->insertRegistro($static['tabela']['nome'], $campos, $valores);
				if ($resultado){
					$retorno = ($acessoBanco->insertId >0)?$acessoBanco->insertId:1;
				} else {
					$retorno = '-'.$acessoBanco->erroNo;
				}//if

			}else{
				$retorno = '-'.$erro_bd;
			}//if
		}//if arr

		//destroi objeto
		unset($acessoBanco);

		//retorna o n�mero do novo ID ou o Erro (codigo negativo)
		return $retorno;
	}
//---------------------------------------------------------------------------------------------------------------
	public static function alterByCondition($arr_campos_valores, $condicao = ""){

		//determina a classe derivada
        $static = self::camposFilho();

		//instancia o objeto AcessoBanco
		$acessoBanco = new AcessoBanco();

		//monta a estrutura de valores para passar por parametro
                /*
		$campos = '';
		if (sizeof($static['campos']) > 0){
			//monta os campos
			for ($idx = 0; $idx < sizeof($static['campos']); $idx++){

				if ($campos != '') $campos .= ', ';

				if (array_key_exists($static['campos'][$idx]['atributo'], $arr_campos_valores)){
					$campos .= $static['campos'][$idx]['nome'] . ' = ' . self::trataValorCampo($arr_campos_valores[$static['campos'][$idx]['atributo']], $idx);
				}
			}

			//altera o Banco de Dados

		} else {
			die('<strong>ERRO DE CLASSE: </strong>Nenhum campo foi encotrado para a tabela da Classe!');
		}
                */

                $resultado = $acessoBanco->updateRegistro($static['tabela']['nome'], $arr_campos_valores, $condicao);
                if ($resultado){
                        $retorno = 1;
                } else {
                        $retorno = '-'.$acessoBanco->erroNo;
                }

		//destroi objeto
		unset($acessoBanco);

		//retorna o n�mero do ID ou o Erro (codigo negativo)
		return $retorno;
	}

//---------------------------------------------------------------------------------------------------------------
	//deleta o objeto do banco de dados
	public static function delByCondition($condicao = ""){

		//determina a classe derivada
        $static = self::camposFilho();

		//instancia o objeto AcessoBanco
		$acessoBanco = new AcessoBanco();

		//exclui do Banco de Dados
		if($condicao != "")$resultado = $acessoBanco->deleteRegistro($static['tabela']['nome'], $condicao);

		if($resultado){
			$retorno = 1;
		}else{
			$retorno = '-'.$acessoBanco->erroNo;
		}//if

		//destroi objeto
		unset($acessoBanco);

		//retorna verdadeiro ou o Erro (codigo negativo)
		return $retorno;
	}
	//---------------------------------------------------------

}
?>