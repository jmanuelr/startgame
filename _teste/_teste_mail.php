<?
  if($_REQUEST["showerror"]=="ok"){
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
  }//if


  echo "hein: ".$_SERVER['REQUEST_SCHEME'] . '://'.$_SERVER['HTTP_HOST'].dirname($_SERVER["REQUEST_URI"]);

  echo "<pre>";
  print_r($_SERVER);
  echo "</pre>";

  //die("die");
?>
<pre>
<?

	require_once "../lib/classes/class.envio_email.php";

  //-------------------------------------------------------------------
  $usuario_primeiro_nome = "José";
  $mensagem = 'Olá, <strong>'.$usuario_primeiro_nome.'</strong>!';
  $mensagem.= '<br />Recebemos seu cadastro no <strong>Noobets</strong>.';
  $mensagem.= '<br />Para conluí-lo, por favor, confirme seu e-mail clicando no link abaixo:';
  $mensagem.= '<br /><br /><a href="'.$link_confirmacao.'" style="color:#3498db;">'.$link_confirmacao.'</a>';
    //-------------------------------------------------------------------

	$strUrlSite = Config::appSettings("strUrlSite");

    $dados = array(
      "##_urlsite_##" => $strUrlSite,
      "##_titulo_##" => $titulo,
      "##_mensagem_##" => $mensagem
    );
    //------------------------------------------
    $end_email    = "jmanuelr@gmail.com";
    $assunto      = "Recibo de envio eletrônico - teste email";
    $template     = "../webmails/template_email.html";
    $reply_email  = $end_email;
    $attachPath   = "";
    $attachName   = "";

    $bool_enviou = EnvioEmail::enviar($end_email,$assunto,$template,$dados,$reply_email,$attachPath,$attachName,true);

    if($bool_enviou){
    	echo "#sim#".$strUrlSite;
    }else{
    	echo "#nao#".$strUrlSite;
    }
?>
</pre>