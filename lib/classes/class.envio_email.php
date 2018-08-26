<?
//define("PHPMAILER",0);

require_once(__DIR__."/class.phpmailer.php");
require_once(__DIR__."/../config/class.config.php");
require_once(__DIR__."/class.configuracaoBD.php");
require_once(__DIR__."/../includes/functions.php");

class EnvioEmail{
	//---------------------------------------------------------
	public function EnvioEmail(){
	}

	public static function enviar($end_email,$assunto,$template,$dados,$reply_email,$attachPath="",$attachName="",$boolDebug = false){

		//return true;

		$sys_name                = getVariavelConfig("sys_name");
		$sys_email_contact       = getVariavelConfig("sys_email_contact");
		$sys_email_smtp_host     = getVariavelConfig("sys_email_smtp_host");
		$sys_email_smtp_port     = intval(getVariavelConfig("sys_email_smtp_port"));
		$sys_email_smtp_user     = getVariavelConfig("sys_email_smtp_user");
		$sys_email_smtp_password = getVariavelConfig("sys_email_smtp_password");

		$dados["##_social_facebook_##"] = getVariavelConfig("web_social_facebook");
		$dados["##_social_linkedin_##"] = getVariavelConfig("web_social_linkedin");
		$dados["##_social_instagram_##"] = getVariavelConfig("web_social_instagram");

		//echo "<br />\$sys_name                = ".$sys_name;
		//echo "<br />\$sys_email_contact       = ".$sys_email_contact;
		//echo "<br />\$sys_email_smtp_host     = ".$sys_email_smtp_host;
		//echo "<br />\$sys_email_smtp_port     = ".$sys_email_smtp_port;
		//echo "<br />\$sys_email_smtp_user     = ".$sys_email_smtp_user;
		//echo "<br />\$sys_email_smtp_password = ".$sys_email_smtp_password;

		//$sys_name                = Config::appSettings("sys_name");
		//$sys_email_contact       = Config::appSettings("sys_email_contact");
		//$sys_email_smtp_host     = Config::appSettings("sys_email_smtp_host");
		//$sys_email_smtp_port     = Config::appSettings("sys_email_smtp_port");
		//$sys_email_smtp_user     = Config::appSettings("sys_email_smtp_user");
		//$sys_email_smtp_password = Config::appSettings("sys_email_smtp_password");
		/*
		dreamhost
		The port numbers you set determine the protocol your email client uses. There are four basic options. IMAP secure is the recommended configuration:
		IMAP (insecure)
		IMAP (secure)
		POP3 (insecure)
		POP3 (secure)
		Below are the settings you can use for each protocol along with the security settings.

		Incoming
		IMAP | Port 143 (Insecure Transport — No SSL function enabled)
		IMAP | Port 993 (Secure Transport   — SSL function enabled)
		POP3 | Port 110 (Insecure Transport — No SSL function enabled)
		POP3 | Port 995 (Secure Transport   — SSL function enabled)
		Outgoing
		SMTP | Port 587 (Insecure Transport — No SSL function enabled)
		SMTP | Port 465 (Secure Transport   — SSL function enabled)
		SMTP | Port 25 (username/password authentication MUST also be enabled!)
		*/
		//-------------------------------
		//if ($reply_email == "")
			$reply_email 	= "";
		//if ($nome_reply_to == "")
			$nome_reply_to 	= $sys_name;
		//-------------------------------
		$arquivo = file(dirname(__FILE__)."/../".$template);
		$arquivo_novo = array();
		foreach($arquivo as $idlinha => $linha){
			foreach($dados as $busca => $troca){
				if(strpos($linha, $busca)){
					$troca = utf8_decode($troca);
					$linha = str_replace($busca, html_entity_decode($troca, ENT_QUOTES), $linha);
				}//if
			}//foreach
			array_push($arquivo_novo, $linha);
		}//foreach
		$Html = implode("",	$arquivo_novo);
		$Html = trim($Html);//."[hola]";
		//*******************************************************************************
		$mail 				= new PHPMailer();
		$mail->PluginDir	= "./";//class.smtp.php
		$mail->Mailer 		= "smtp";
		$mail->IsSMTP();
		$mail->SMTPSecure 	= 'tls';//tls / ssl
		$mail->Host 		= $sys_email_smtp_host;
		$mail->Port		 	= $sys_email_smtp_port;
		$mail->SMTPAuth 	= true;

		if($boolDebug)$mail->SMTPDebug 	= 2;
		$mail->Username 	= $sys_email_smtp_user;
		$mail->Password 	= $sys_email_smtp_password;

		$mail->From 		= $sys_email_contact;
		$mail->FromName 	= $sys_name;

		$mail->AddReplyTo($reply_email,$nome_reply_to);//address, name
		$mail->AddAddress($end_email);
		if($copias!="")$mail->AddCC($copias);//para q receba copias.
		//$mail->AddCC("");

		$mail->Timeout		=	30;
		$mail->IsHTML(true);
		$mail->Subject 		= utf8_decode($assunto);
		$mail->Body 		= $Html;
		$mail->AltBody 		= 'Seu cliente de e-mail não suporta HTML';

		if(!empty($attachPath) && is_file(dirname(__FILE__)."/".$attachPath)){
			$mail->AddAttachment(dirname(__FILE__)."/".$attachPath,$attachName);
		}//if

		$exito = $mail->Send();

		if(!$exito){
		   echo "Message could not be sent. ";
		   echo "Mailer Error: " . $mail->ErrorInfo;
		   echo "\n host: ".$sys_email_smtp_host." - port: ".$sys_email_smtp_port;
		   echo "\n";
		   //exit;
		}
		return $exito;
		//*******************************************************************************
	}//function
}
?>