<?php
/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

//error_reporting(E_ALL | E_STRICT);
require('UploadHandler.php');

//print_r($_REQUEST);

//fonte=1&dir=texto&id=1
/*
[QUERY_STRING] => fonte=1&dir=texto&id=1
[REQUEST_URI] => /epla/lib/componentes/jquery-file-upload/server/php/?fonte=1&dir=texto&id=1
[SCRIPT_NAME] => /epla/lib/componentes/jquery-file-upload/server/php/index.php
[PHP_SELF] => /epla/lib/componentes/jquery-file-upload/server/php/index.php
*/

	$arr_dir_allowed = array("texto","ficha");

	$dir_contexto = $_REQUEST["dir"];

	if(!in_array($dir_contexto, $arr_dir_allowed))$dir_contexto = "outros";

	$base_url     = "http://" . $_SERVER['HTTP_HOST'] . substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],"/lib"));

	$id_dir 		= str_pad($_REQUEST["id"],16,"0",STR_PAD_LEFT);
	$relative_dir 	= "download/".$dir_contexto."/".$id_dir."/";
	$path_download = __DIR__ . "/../../../../../".$relative_dir;

	$arr_opcoes = array(
					//'script_url' => 
					'upload_dir' => $path_download,
					'upload_url' => $base_url."/".$relative_dir//,
					//'param_name' => 'files'
					);

	$upload_handler = new UploadHandler($arr_opcoes);
?>