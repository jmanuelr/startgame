<?php

//error_reporting(0);

//date_default_timezone_set('America/Sao_Paulo');

// incluso do arquivo de classe Config
if (!defined("_CLASS_CONFIG")) {
	define("_CLASS_CONFIG", 1);

	class Config{

		//Atributos do banco de dados
		private $server;
		private $user;
		private $password;
		private $base;

		//--------------------------------------------------------------------------------------------------

		//construtor da classe Config
		public function __construct(){

			//var_dump($_SERVER);

			$arr_localhost = array("localhost","127.0.0.1");

			if($_SERVER['HTTP_HOST'] == "www.noobets.com" || $_SERVER['HTTP_HOST'] == "noobets.com"){
				$this->server 		= "mysql.noobets.com";
				$this->user			= "noobets";
				$this->password		= "31ns3nb4hn";
				$this->base			= "noobets";
			}else{//in_array($_SERVER['HTTP_HOST'], $arr_localhost)
				$this->server 		= "127.0.0.1";
				$this->user			= "root";
				$this->password		= "";//
				$this->base			= "noobets";//
				//if($_SERVER['DOCUMENT_ROOT']== "/Library/WebServer/Documents")
			}//if

		}

		//server
		private function setServer($paramServer){
			$this->server = $paramServer;
		}

		public function getServer(){
			return $this->server;
		}

		//user
		private function setUser($paramUser){
			$this->user = $paramUser;
		}

		public function getUser(){
			return $this->user;
		}

		//password
		private function setPassword($paramPassword){
			$this->password = $paramPassword;
		}

		public function getPassword(){
			return $this->password;
		}

		//base
		private function setBase($paramBase){
			$this->base = $paramBase;
		}

		public function getBase(){
			return $this->base;
		}

		//tags internas do appSettings
		public static function appSettings($indice){

			$rootpath = str_replace("lib/config","", dirname(__FILE__));

			$arr_localhost = array("localhost","127.0.0.1");

			if (in_array($_SERVER['HTTP_HOST'], $arr_localhost)){

				$arrAppSettings = array(
									"strWebTittle" 		=> "Noobets",
									"prefixoBD"			=> "gnb",
									"strUrlSite" 		=> $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']."/",
									"strDirBaseSite" 	=> $rootpath,
									"arquivoLogErro" 	=> $rootpath."logs/log_".date("Ymd").".txt",
									"emailFromGeral" 	=> "contato@noobets.com",
									"emailLogErro" 		=> "",
									"emailContato" 		=> "contato@noobets.com"
								  );
			}else{
				// Cliente
				$arrAppSettings = array(
									"strWebTittle" 		=> "Noobets",
									"prefixoBD"			=> "gnb",
									"strUrlSite" 		=> $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']."/",
									"strDirBaseSite" 	=> $rootpath,
									"arquivoLogErro" 	=> $rootpath."logs/log_".date("Ymd").".txt",
									"emailFromGeral" 	=> "contato@noobets.com",
									"emailLogErro" 		=> "",
									"emailContato" 		=> "contato@noobets.com"
								  );
			}

			if (isset($arrAppSettings[$indice]))
				return $arrAppSettings[$indice];
			else
				return "";
		}

	}
}

?>