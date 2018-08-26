<?
	//-----------------------------------------------------------
	require_once(__DIR__."/../lib/includes/session.inc.php");
	//-----------------------------------------------------------

	session::start();
	session::destroy();

	header("Location: ../auth/");
?>