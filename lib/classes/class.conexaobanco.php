<?php
require(dirname(__FILE__)."/../componentes/adodb/adodb.inc.php");
require(dirname(__FILE__)."/../config/class.config.php");

class ConexaoBanco {
	//Propriedade Estática referenciando um tipo da mesma Classe
	static $instancia = false;

	private $config;
	private $server;
	private $user;
	private $password;
	private $base;
	private $conexao;

	//Construtor Private - Não é possível utilizar new em outras classes
	private function __construct() {
		//instancia o objeto Config
		$this->config = new Config();

		//seta os valores do Banco de Dados nos atributos da classe AcessoBanco
		$this->server = $this->config->getServer();
		$this->user = $this->config->getUser();
		$this->password = $this->config->getPassword();
		$this->base = $this->config->getBase();

		//faz a conexo com o banco de dados
		$this->conexao =& ADONewConnection('mysql');

		if ( !$this->conexao->Connect($this->server, $this->user, $this->password, $this->base) ){
			//echo "Problemas de conexão com a base de dados"; exit;
			return false;
		}

		//$this->conexao->debug=1;
	}

	//Metodo para recuperar instancia
	public function getInstancia() {
		if (!ConexaoBanco::$instancia) {
			ConexaoBanco::$instancia = new ConexaoBanco();//chamando construtor
		}
		return ConexaoBanco::$instancia;
	}

	public function getConexao(){
		return $this->conexao;
	}

	//destrutor - destrói conexão com o banco
	function __destruct(){
		//mysql_close($this->conexao);
		//print_r($this->conexao);
		$this->conexao->Disconnect();
	}


}

?>