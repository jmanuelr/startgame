<?php

class RN{

	//mtodo construtor da classe RN
	public function RN(){
	}

	public static function microtime_float(){
	    list($usec, $sec) = explode(" ", microtime());
	    return ((float)$usec + (float)$sec);
	}

	//-----------------------------------------------------------------------------------------------------------------------
	//Retorna a data passada no formado dd/mm/aaaa
	public static function NormalDate ($data, $tipo="br") {
		if(strlen($data)>8){//0123-56-89 12-45-78
			$data = sprintf ("%s%s/%s%s/%s%s%s%s", $data[8], $data[9], $data[5], $data[6], $data[0], $data[1], $data[2], $data[3]);
			return $data;
		}else{
			switch ($tipo) {
				case "br2":
					//Converte uma data no formato aaaammdd para o formato mm/dd/aaaa
					if (!empty($data)) $data = sprintf ("%s%s/%s%s/%s%s%s%s", $data[7], $data[8], $data[5], $data[6], $data[0], $data[1], $data[2], $data[3]);
					return $data;
				case "br":
					//Converte uma data no formato aaaammdd para o formato mm/dd/aaaa
					if (!empty($data)) $data = sprintf ("%s%s/%s%s/%s%s%s%s", $data[6], $data[7], $data[4], $data[5], $data[0], $data[1], $data[2], $data[3]);
					return $data;
				case "en":
					//Converte uma data no formato aaaammdd para o formato mm/dd/aaaa
					if (!empty($data)) $data = sprintf ("%s%s%s%s/%s%s/%s%s",  $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7]);
					return $data;
			}//sw
		}//if
	}

	//-----------------------------------------------------------------------------------------------------------------------
	//Retorna a data passada no formado aaaammdd
	public static function StringDate($data, $tipo="br") {
		if(strlen($data)>10){//01/34/6789 12:45:78
			$data = sprintf ("%s%s%s%s-%s%s-%s%s %s%s:%s%s:%s%s", $data[6], $data[7], $data[8], $data[9], $data[3], $data[4], $data[0], $data[1], $data[11], $data[12], $data[14], $data[15], $data[17], $data[18]);
			return $data;
		}else{
			switch ($tipo) {
				case "br":
					if(!empty($data))
						$data = $data[6] . $data[7] . $data[8] . $data[9] . $data[3] . $data[4] . $data[0] . $data[1];
					else
						$data =  "";
					return $data;
				case "en":
					if(!empty($data))
						$data = $data[6] . $data[7] . $data[8] . $data[9] . $data[0] . $data[1] . $data[3] . $data[4];
					else
						$data = "";
					return $data;
			}//sw
		}//if
	}
	//-----------------------------------------------------------------------------------------------------------------------
	public static function CaosDate($data) {
		//tenta arrumar formatos detonados de data para o formato dd/mm/yyyy
		//por enquanto funciona soh com formatos ex: 01/dez/09, 1/dic/09, 1/1/09, 13-feb-2009 e semelhantes, em dia, mes e ano
		//atualmente suporta idiomas: pt, es, en.
		//anos de 2 digitos funcionam assim: entre 80 a 99 -> 1900, outros -> 2000
		//--------------------------------------
		$mes[0] = array("jan","ene");
		$mes[1] = array("fev","feb");
		$mes[2] = array("mar");
		$mes[3] = array("abr","apr");
		$mes[4] = array("mai","may");
		$mes[5] = array("jun");
		$mes[6] = array("jul");
		$mes[7] = array("ago","aug");
		$mes[8] = array("set","set","sep");
		$mes[9] = array("out","oct");
		$mes[10] = array("nov");
		$mes[11] = array("dez","dic","dec");
		//--------------------------------------
		$string_cut = eregi_replace("[0-9]","",$data);
		$separador	= $string_cut[0];
		$arr_data	= @explode($separador,$data);
		//--------------------------------------
		$new_dia	= $arr_data[0];
		if(strlen($new_dia)<2){
			$new_dia = "0".$new_dia;
		}//if
		//--------------------------------------
		$new_ano	= $arr_data[2];
		if(strlen($new_ano)<4){
			if( ($new_ano >= 80) && ($new_ano <= 99) ){
				$new_ano = "19".$new_ano;
			}else{
				$new_ano = "20".$new_ano;
			}
		}//if
		//--------------------------------------
		$achou = false;
		$new_mes = $arr_data[1];
		if(is_numeric($new_mes)){
			if(strlen($new_mes)<2)$new_mes = "0".$new_mes;
		}else{
			for($i=0;$i<count($mes);$i++){
				for($j=0;$j<count($mes[$i]);$j++){
					if(eregi($mes[$i][$j],$new_mes)){
						//echo "<br>i: $i - j: $j";
						$new_mes = $i + 1;
						if($new_mes<10)$new_mes = "0".$new_mes;
						$achou = true;
						break;
					}
					//echo "<br>i: $i - j: $j";
				}//for j
				if($achou)break;
			}//for i
		}//if
		//--------------------------------------
		return $new_dia . "/" . $new_mes . "/" . $new_ano;
	}//function
	//-----------------------------------------------------------------------------------------------------------------------
	//Retorna o nome do mes numerico passado como paramentro
	public static function getNomeMes($mes,$idioma = 0) {

		switch($mes) {
			case 1:
				$nombre[0] = "Janeiro";
				$nombre[1] = "Enero";
			break;
			case 2:
				$nombre[0] = "Fevereiro";
				$nombre[1] = "Febrero";
			break;
			case 3:
				$nombre[0] = "Mar?";
				$nombre[1] = "Marzo";
			break;
			case 4:
				$nombre[0] = "Abril";
				$nombre[1] = "Abril";
			break;
			case 5:
				$nombre[0] = "Maio";
				$nombre[1] = "Mayo";
			break;
			case 6:
				$nombre[0] = "Junho";
				$nombre[1] = "Junio";
			break;
			case 7:
				$nombre[0] = "Julho";
				$nombre[1] = "Julio";
			break;
			case 8:
				$nombre[0] = "Agosto";
				$nombre[1] = "Agosto";
			break;
			case 9:
				$nombre[0] = "Setembro";
				$nombre[1] = "Setiembre";
			break;
			case 10:
				$nombre[0] = "Outubro";
				$nombre[1] = "Octubre";
			break;
			case 11:
				$nombre[0] = "Novembro";
				$nombre[1] = "Noviembre";
			break;
			case 12:
				$nombre[0] = "Dezembro";
				$nombre[1] = "Diciembre";
			break;
		}//switch

		return $nombre[$idioma];

	}//function

	//-----------------------------------------------------------------------------------------------------------------------
	//gera string aleatoria
	public static function geraString($length) {
   		$nps = "";
   		for($i=0;$i<$length;$i++){
	       $nps .= chr( (mt_rand(1, 36) <= 26) ? mt_rand(97, 122) : mt_rand(48, 57 ));
   		}
   		return $nps;
	}
	//-----------------------------------------------------------------------------------------------------------------------
	public static function somenteNumeros($valor) {
		$numeros = ereg_replace("[^0-9]","",$valor);
   		return $numeros;
	}
	//-----------------------------------------------------------------------------------------------------------------------
	// $corte_texto: N - Nao corta palavras. Mostra at?o fim da palavra mesmo estourando o limite.
	//               A - Nao corta palavras. Mostr?at?a palavra anterior que o limite desejado.
	//               C - Corta a palavra no limite desejado.
	public static function cortaFrase($frase,$limite,$corte_texto="N"){
		$tam_orig = strlen(rtrim($frase));
		if ($corte_texto == "N"){
			if(strpos($frase, " ") !== false){
				$pos = strpos( substr( $frase, $limite, strlen($frase) ), " " );
				if(!is_numeric($pos)) $pos = 0;
				$frase = substr( $frase, 0, $limite + $pos );
	//			if( (strlen($frase) > $limite) || (($pos == 0) && (strlen($frase) == $limite)) ) $frase .= "...";
			}
		} else if ($corte_texto == "A"){
			if(strpos($frase, " ") !== false){
				$pos = strrpos( substr( $frase, 0, $limite ), " " );
				if(!is_numeric($pos)) $pos = 0;
				$frase = substr( $frase, 0, $pos );
			}
		} else if ($corte_texto == "C"){
			$frase = substr( $frase, 0, $limite );
		}
		if ($tam_orig > $limite) $frase .= "...";
		return $frase;
	}
	//-----------------------------------------------------------------------------------------------------------------------
	public static function RemoveAcentos($Msg){
		$a = array(
					'/[ÂÀÁÄÃ]/'=>'A',
					'/[âãàáä]/'=>'a',
					'/[ÊÈÉË]/'=>'E',
					'/[êèéë]/'=>'e',
					'/[ÎÍÌÏ]/'=>'I',
					'/[îíìï]/'=>'i',
					'/[ÔÕÒÓÖ]/'=>'O',
					'/[ôõòóö]/'=>'o',
					'/[ÛÙÚÜ]/'=>'U',
					'/[ûúùü]/'=>'u',
					'/ç/'=>'c',
					'/Ç/'=> 'C'
				);
					// Tira o acento pela chave do array
					return preg_replace(array_keys($a), array_values($a), $Msg);
	}
	//-----------------------------------------------------------------------------------------------------------------------
	public static function getFileSize($bytes){
		switch(TRUE){
			case ($bytes<1024):
				return ($bytes . " bytes");
				break;
			case ($bytes>1023):
				return (ceil($bytes/1024) . " KB");
				break;
			case ($bytes>104858):
				return (ceil($bytes/1000000) . " MB");
				break;
		}
	}
	//------------------------------------------------------------------------------------------------------------------------
	public static function dateDiff($sDataInicial, $sDataFinal){// dd-mm-YYYY
		$sDataI = explode("-", $sDataInicial);
		$sDataF = explode("-", $sDataFinal);

		$nDataInicial = mktime(0, 0, 0, $sDataI[1], $sDataI[0], $sDataI[2]);
		$nDataFinal = mktime(0, 0, 0, $sDataF[1], $sDataF[0], $sDataF[2]);


		$resultado = ($nDataInicial > $nDataFinal) ? floor(($nDataInicial - $nDataFinal)/86400) : floor(($nDataFinal - $nDataInicial)/86400);
		$div = 0;//bcdiv($resultado, 365.65, 0);
		return $resultado - $div;
	}
	public static function dateDiff2($fecha_min, $fecha_max){// YYYYmmdd
		//--------------------------->>
	    if($fecha_min == "")$fecha_min = date("Ymd");
	    if($fecha_max == "")$fecha_max = date("Ymd");

	    $fecha_min = substr($fecha_min,0,4)."-".substr($fecha_min,4,2)."-".substr($fecha_min,6,2);
	    $fecha_max = substr($fecha_max,0,4)."-".substr($fecha_max,4,2)."-".substr($fecha_max,6,2);

	    //---------------------------
	    $start    = new DateTime($fecha_min);
	    //$start->modify('first day of this month');
	    $end      = new DateTime($fecha_max);
	    //$end->modify('first day of next month');
		/*
	    $interval = DateInterval::createFromDateString('1 day');//
	    $period   = new DatePeriod($start, $interval, $end);
	    //---------------------------<<
	     foreach($period as $dt){
                                    $this_dt    = $dt->format("Ym");
                                    $ano        = substr($this_dt,2,2);
                                    $mes        = substr($this_dt,4,2);
                                    $mes_str    = RN::getNomeMes(intval($mes));
                                    $mes_str    = utf8_encode($mes_str);
                                    ?><th class="thmes"><?=$mes_str."'".$ano?></th><?
                                }//foreach
	    */

        //$interval = $start->diff($end);
        //$interval->format('%Y years %m month, %d days');
	    return $start->diff($end)->days;
	}//fnc

	//------------------------------------------------------------------------------------------------------------------------
	public static function primeiraPalavra($frase){
		$pos = strpos($frase, " ");
		if(!is_numeric($pos)) $pos = 0;
		if($pos > 0){
			$frase_nova = substr( $frase, 0, $pos );
		}else{
			$frase_nova = $frase;
		}
		return $frase_nova;
	}
	//------------------------------------------------------------------------------------------------------------------------
	public static function en_de_crypt($Str_Message) {
		//Function : encrypt/decrypt a string message v.1.0  without a known key
		//Author   : Aitor Solozabal Merino (spain)
		//Email    : aitor-3@euskalnet.net
		//Date     : 01-04-2005
		$Len_Str_Message=strlen($Str_Message);
		$Str_Encrypted_Message="";
		for($Position = 0;$Position<$Len_Str_Message;$Position++){
			// long code of the function to explain the algoritm
			//this function can be tailored by the programmer modifyng the formula
			//to calculate the key to use for every character in the string.
			$Key_To_Use = (($Len_Str_Message+$Position)+1); // (+5 or *3 or ^2)
			//after that we need a module division because can?t be greater than 255
			$Key_To_Use = (255+$Key_To_Use) % 255;
			$Byte_To_Be_Encrypted = substr($Str_Message, $Position, 1);
			$Ascii_Num_Byte_To_Encrypt = ord($Byte_To_Be_Encrypted);
			$Xored_Byte = $Ascii_Num_Byte_To_Encrypt ^ $Key_To_Use;  //xor operation
			$Encrypted_Byte = chr($Xored_Byte);
			$Str_Encrypted_Message .= $Encrypted_Byte;

			//short code of  the function once explained
			//$str_encrypted_message .= chr((ord(substr($str_message, $position, 1))) ^ ((255+(($len_str_message+$position)+1)) % 255));
		}
		$Str_Encrypted_Message = ereg_replace("['\\]","\\\\0", $Str_Encrypted_Message);
		return $Str_Encrypted_Message;
	} //en

	//------------------------------------------------------------------------------------------------------------------------
/**
* Validate URL
* Allows for port, path and query string validations
* @param    string      $url       string containing url user input
* @return   boolean     Returns TRUE/FALSE
*/
	public static function validateURL($url){
		$pattern = '/^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&amp;?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/';
		return preg_match($pattern, $url);
	}
	//------------------------------------------------------------------------------------------------------------------------

	public static function validateEmail($endereco_mail) {
		if (preg_match("/^([a-z0-9]([a-z0-9_-]*\.?[a-z0-9])*)(\+[a-z0-9]+)?@([a-z0-9]([a-z0-9-]*[a-z0-9])*\.)*([a-z0-9]([a-z0-9-]*[a-z0-9]+)*)\.[a-z]{2,6}$/", $endereco_mail)) {
			return true;
		} else {
			return false;
		}
	}
	//------------------------------------------------------------------------------------------------------------------------

	public static function formataPadrao($input,$tipo){
		$input = RN::somenteNumeros($input);
		if(strtoupper($tipo)=="CPF"){
			$retorno = str_pad($input, 11, "0", STR_PAD_LEFT);
			$retorno = substr($retorno,0,3) . "." . substr($retorno,3,3) . "." . substr($retorno,6,3) . "-" . substr($retorno,9,2);
		}elseif(strtoupper($tipo)=="CNPJ"){
			$retorno = str_pad($input, 14, "0", STR_PAD_LEFT);
			$retorno = substr($retorno,0,2) . "." . substr($retorno,2,3) . "." . substr($retorno,5,3) . "/" . substr($retorno,8,4) . "-" . substr($retorno,12,2);
		}else{//CEP
			$retorno = str_pad($input, 8, "0", STR_PAD_LEFT);
			$retorno = substr($retorno,0,5) . "-" . substr($retorno,5,3);
		}
		return $retorno;
	}//function
	//------------------------------------------------------------------------------------------------------------------------

	public static function diaSemana($data,$idioma = 1){

		$idioma = $idioma - 1;

		$ano =  substr("$data", 0, 4);
		$mes =  substr("$data", 4, 2);
		$dia =  substr("$data", 6, 2);

		$diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );
		switch($diasemana) {
			case"0": $diasemana = array("Domingo","Domingo","Sunday");				break;
			case"1": $diasemana = array("Segunda-Feira","Lunes","Monday");			break;
			case"2": $diasemana = array("Ter?-Feira","Domingo","Tuesday");			break;
			case"3": $diasemana = array("Quarta-Feira","Mi?coles","Wednesday");	break;
			case"4": $diasemana = array("Quinta-Feira","Jueves","Thursday");		break;
			case"5": $diasemana = array("Sexta-Feira","Viernes","Friday");			break;
			case"6": $diasemana = array("S?ado","S?ado","Saturday");				break;
		}//sw
		return $diasemana[$idioma];
	}//fnc

	public static function limpaLixo($string){
		$string = eregi_replace("[??]","\"",$string);
		$string = str_replace("?","-",$string);//o primeiro eh um tra? estranho, mais largo.
		return $string;
	}//fnc

	public static function getYouTubeID($url){
		if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $id)) {
		  $values = $id[1];
		} else if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $id)) {
		  $values = $id[1];
		} else if (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $url, $id)) {
		  $values = $id[1];
		} else if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $id)) {
		  $values = $id[1];
		}
		else if (preg_match('/youtube\.com\/verify_age\?next_url=\/watch%3Fv%3D([^\&\?\/]+)/', $url, $id)) {
		    $values = $id[1];
		} else {
		// not an youtube video
		}
		return $values;
	}//fnc
}
?>
