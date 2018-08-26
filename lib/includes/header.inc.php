<?
	//error_reporting(E_ALL);
	//ini_set('display_errors', '1');

    include_once(dirname(__FILE__)."/session.inc.php");
    include_once(dirname(__FILE__)."/functions.php");

	session::start();

	if(!empty($_SESSION["validadordesessao"])){
		header("Expires: Wed, 21 Dec 1983 09:00:00 GMT");
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
	}  else {
		//header("Location: login_frm.php?erro=2");
		//exit;
		session::destroy();
		header("Location: auth/");
		exit;
	}
?>