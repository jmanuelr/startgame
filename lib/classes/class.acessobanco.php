<?php
require('class.conexaobanco.php');

if (!defined("_CLASS_ACESSOBANCO")) {
	define("_CLASS_ACESSOBANCO", 1);

	class AcessoBanco{

		private $base;
		private $conexao;

		//mtodo construtor
		public function AcessoBanco(){

			//instancia o objeto Config
			$this->config = new Config();

			//pega o nome do banco de dados
			$this->base = $this->config->getBase();

			//conexão com o banco de dados
			$oConexaoBanco = ConexaoBanco::getInstancia();
			$this->conexao = $oConexaoBanco->getConexao();
			$this->conexao->execute("SET NAMES utf8");
			if($_REQUEST["db"]=="ok"){
				$this->conexao->debug=1;
			}//if
			//$this->conexao->debug=1;
		}//

		//mtodo que retorna o valor do campo informado no parmetro
		public function getInsertId(){
			return $this->conexao->Insert_ID();
		}

		//mtodo que retorna o valor do campo informado no parmetro
		public function getValorCampo($paramCampo, $paramFrom, $paramWhere){

			$valorCampo = "";

			//comando SQL que busca o valor do campo informado
			$comandoSql = "SELECT " . $paramCampo . " FROM " . $paramFrom;
			if($paramWhere!="") $comandoSql .= "  WHERE " . $paramWhere;

			//executa o comando SQL no banco de dados
			$resultado =& $this->conexao->Execute($comandoSql);

			if(!$resultado->EOF){
				$valorCampo = $resultado->fields[$paramCampo];
			}

			return $valorCampo;

		}


		//mtodo que retorna o valor do campo informado no parmetro
		public function getValorCampoBySQL($comandoSql){

			$valorCampo = "";

			//executa o comando SQL no banco de dados
			$resultado =& $this->conexao->Execute($comandoSql);

			if(!$resultado->EOF){
				$valorCampo = $resultado->fields[0];
			}

			return $valorCampo;

		}


		public function getLastId($campo,$tabela){

			$valorCampo = "";

			//comando SQL que busca o valor do campo informado
			$comandoSql = "SELECT MAX(".$campo.") as ultimo_id FROM " . $tabela;

			//executa o comando SQL no banco de dados
			$resultado =& $this->conexao->Execute($comandoSql);

			if(!$resultado->EOF){
				$valorCampo = $resultado->fields["ultimo_id"];
			}

			return $valorCampo;

		}


		//mtodo que seleciona registros no banco de dados
		public function selectRegistro($paramTabela, $paramCampos, $paramCondicao = "", $paramOrdenacao = "", $paramStart = 0, $paramMax = 0){

			//comando SQL que seleciona os dados no banco de dados
			$comandoSql = "SELECT " . $paramCampos . " FROM " . $paramTabela;

			//inclui condio quando existir
			if (!empty($paramCondicao)){
				$comandoSql .= " WHERE " . $paramCondicao;
			}

			//inclui ordenao quando existir
			if (!empty($paramOrdenacao)){
				$comandoSql .= " ORDER BY " . $paramOrdenacao;
			}
			//$this->conexao->debug=1;

			if(isset($_GET['debug'])){
				echo $comandoSql;
			}

			//oracle usa ao contrario o select limit..
			if ($paramStart > 0){
				if($paramMax > 0){
					$resultado =& $this->conexao->SelectLimit($comandoSql,$paramMax,$paramStart);
				}else{
					$resultado =& $this->conexao->Execute($comandoSql);
				}
			}elseif($paramMax > 0){
				$resultado =& $this->conexao->SelectLimit($comandoSql,$paramMax,0);
			}else{
				$resultado =& $this->conexao->Execute($comandoSql);
			}//if

			$i = 0;
			$arrayRegistro = array();
			//echo $comandoSql;
			//seta o array de Registros com os registros retornados
			while(!$resultado->EOF){
				$arrayRegistro[$i] = $resultado->fields;// mysql
				//$arrayRegistro[$i] = $resultado->_array[$i];// oracle
				$resultado->MoveNext();
				$i++;
			}


			unset($resultado);
			return $arrayRegistro;
		}


		//mtodo que seleciona registros no banco de dados
		public function selectRegistrobySQL($comandoSql, $paramStart = 0, $paramMax = 0){

			//oracle usa ao contrario o select limit..
			if ($paramStart > 0){
				if($paramMax > 0){
					$resultado =& $this->conexao->SelectLimit($comandoSql,$paramMax,$paramStart);
				}else{
					$resultado =& $this->conexao->Execute($comandoSql);
				}
			}elseif($paramMax > 0){
				$resultado =& $this->conexao->SelectLimit($comandoSql,$paramMax,0);
			}else{
				$resultado =& $this->conexao->Execute($comandoSql);
			}//if

			$i = 0;
			$arrayRegistro = array();

			//seta o array de Registros com os registros retornados
			while(!$resultado->EOF){
				$arrayRegistro[$i] = $resultado->fields;// mysql
				//$arrayRegistro[$i] = $resultado->_array[$i];// oracle
				$resultado->MoveNext();
				$i++;
			}
			unset($resultado);
			return $arrayRegistro;

		}

				//mtodo que insere registros no banco de dados e retorna o ltimo id inserido
		public function insertRegistro($paramTabela, $paramCampos, $paramValores){

			//comando SQL que insere os dados no banco de dados
			$comandoSql = "INSERT INTO " . $paramTabela . " (" . $paramCampos . ")  VALUES(" . $paramValores . ") ";
			//$this->conexao->debug=1;

			//echo $comandoSql;
			//executa o comando SQL no banco de dados
			$this->conexao->Execute($comandoSql);

			//retorna o id
			$id = $this->conexao->Insert_ID();

			return $id;
		}


		//mtodo que altera registros no banco de dados
		public function updateRegistro($paramTabela, $paramCampos, $paramCondicao){

			//$this->conexao->debug=1;
			//comando SQL que altera os dados no banco de dados
			$comandoSql = "UPDATE " . $paramTabela . " SET " . $paramCampos . "  WHERE " . $paramCondicao;
			//echo $comandoSql;

			//executa o comando SQL no banco de dados
			$this->conexao->Execute($comandoSql);
		}


		//mtodo que altera registros no banco de dados
		public function deleteRegistro($paramTabela, $paramCondicao){

			//comando SQL que apaga os dados no banco de dados
			$comandoSql = "DELETE FROM " . $paramTabela . " WHERE " . $paramCondicao;

			//echo $comandoSql;

			//executa o comando SQL no banco de dados
			$this->conexao->Execute($comandoSql);
		}

		public function truncateTable($paramTabela){
			//comando SQL que apaga os dados no banco de dados
			$comandoSql = "TRUNCATE TABLE " . $paramTabela;
			//executa o comando SQL no banco de dados
			$this->conexao->Execute($comandoSql);
		}
		//---------------------------------------------
		public function getNumOfRows($tabela,$condicao = "1=1", $campo = "Count(*)"){
			$acessoBanco = new AcessoBanco();
			$rs = $acessoBanco->getValorCampo($campo,$tabela,$condicao);
			unset($acessoBanco);
			return $rs;
		}
		//---------------------------------------------
		public function getNumOfRowsBySQL($comandoSql){
			$acessoBanco = new AcessoBanco();
			$rs = $acessoBanco->getValorCampoBySQL($comandoSql);
			unset($acessoBanco);
			return $rs;
		}
		//---------------------------------------------
		public function setAutoIncrement($paramTabela, $new_value){
			//comando SQL que apaga os dados no banco de dados
			$comandoSql = "alter table " . $paramTabela . " auto_increment=" . $new_value;
			//executa o comando SQL no banco de dados
			$this->conexao->Execute($comandoSql);
		}
		//---------------------------------------------
	}

}
?>