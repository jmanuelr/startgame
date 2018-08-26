<?
	$db_prefixo 		= "gnb";
	//$upload_path 		= dirname(__FILE__)."/../../upload/";
	//$arr_subdir_allowed = array("mrc","usr","prd","ind","mdl");

	$arr_field_tipos = array( // [I]nput [T]extarea [N]umero inteiro [D]ecimal [S]elect [R]adio [C]heckbox
		"I" => array("text-color", "Texto Curto", "A"),
		"T" => array("file-text", "Textarea", "A"),
		"N" => array("calculator", "Numérico (Inteiro)", "A"),
		"D" => array("pencil-ruler", "Numérico (Decimal)", "A"),
		"S" => array("select2", "Select", "A"),
		"R" => array("radio-checked", "Radio", "A"),
		"C" => array("checkbox-checked", "Checkbox", "A"),
		"F" => array("calendar2", "Data", "A")
	);


	$arr_substituicao = array(
		"[USUARIO_NOME]" 			=> "\$oUsuario->Nome",
		"[USUARIO_EMAIL]" 			=> "\$oUsuario->Email",
		"[CLIENTE_NOME_FANTASIA]" 	=> "\$oCliente->Nome",
		"[CLIENTE_RAZAO_SOCIAL]" 	=> "\$oCliente->RazaoSocial",
		"[CLIENTE_CNPJ]" 			=> "\$oFormata->getCNPJ(\$oCliente->CnpjCpf)",
		"[CONTATO_NOME]" 			=> "\$oContato->Nome",
		"[CONTATO_EMAIL]" 			=> "\$oContato->Email",
		"[EQUIPE_NOME]" 			=> "\$oEquipe->Nome",
		"[FASE_TITULO]" 			=> "\$oFase->Titulo",
		"[FASE_DESCRICAO]" 			=> "\$oFase->Descricao",
		"[DEAL_TITULO]" 			=> "\$oTask->Titulo",
		"[DEAL_DESCRICAO]" 			=> "\$oTask->Descrcao"
	);
?>