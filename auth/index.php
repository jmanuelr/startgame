<?

	require_once(__DIR__.'/../lib/includes/session.inc.php');

	session::start();

	$arr_target = array("login","cadastro","confirma","senha","desuscribir");

	$target = $_REQUEST["target"];

	//http://www.noobets.com/auth/?target=confirma&mail=jmanuelr@hotmail.com&hash=5ef429118b356ff7e7c85a4dfed0a457d29dc1aa

	if(!empty($_SESSION["validadordesessao"]) && !in_array($target, $arr_target)){
		header("Location: ../");
		exit;
	}//if

	//-----------------------------------------------------------
	require_once(__DIR__."/../lib/classes/class.clienteBD.php");
	require_once(__DIR__."/../lib/classes/class.usuarioBD.php");
	require_once(__DIR__."/../lib/classes/class.formata_string.php");
	//-----------------------------------------------------------


	if(!in_array($target, $arr_target))$target = "login";


	$mensagem_confirmacao_cadastro = "";
	$icone_confirmacao = "user-cancel";
	$class_confirmacao = "danger";

	if($target == "confirma"){
		$url_user = trim($_REQUEST["mail"]);
		$url_hash = trim($_REQUEST["hash"]);
		$oListaUsuario = UsuarioBD::getLista("usr_email = '".$url_user."' AND usr_status = 'A'","",0,1);
		if(count($oListaUsuario)>0){
			$oUsuario = $oListaUsuario[0];
			if($oUsuario->Confirmacao > 0){
				//-- ja confirmado
				$mensagem_confirmacao_cadastro = "O e-mail já está confirmado. Obrigado!";
				$icone_confirmacao = "user-lock";
					$class_confirmacao = "warning";
			}else{
				if($url_hash == sha1($oUsuario->Id."|".$oUsuario->DtRegistro."|".$oUsuario->HrRegistro)){
					$oUsuario->Confirmacao = 1;
					UsuarioBD::alter($oUsuario);
					$mensagem_confirmacao_cadastro = "Seu e-mail foi confirmado com sucesso!";
					$icone_confirmacao = "user-check";
					$class_confirmacao = "success";
				}else{
					$mensagem_confirmacao_cadastro = "Cadastro não encontrado.";
				}//if

			}//if
		}else{
			$mensagem_confirmacao_cadastro = "Cadastro não encontrado.";
		}//if
	}//if confirma

?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Noobets</title>

	<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico?v=3">
	<link rel="icon" type="image/x-icon" href="../favicon.ico?v=3">

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="../assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="../assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="../assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="../assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="../assets/css/colors.css" rel="stylesheet" type="text/css">
	<link href="../assets/css/custom.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="../assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="../assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="../assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
	<script type="text/javascript" src="../assets/js/plugins/ui/nicescroll.min.js"></script>
	<script type="text/javascript" src="../assets/js/plugins/ui/drilldown.js"></script>
	<script type="text/javascript" src="../assets/js/plugins/forms/inputs/formatter.min.js"></script>


	<!-- /core JS files -->
	<script type="text/javascript" src="../assets/js/plugins/forms/validation/validate.min.js"></script>
	<script src="../assets/js/plugins/forms/validation/localization/messages_pt_BR.js"></script>

	<!-- Theme JS files -->
	<script type="text/javascript" src="../assets/js/core/app.js"></script>

	<!-- /theme JS files -->
	<script type="text/javascript" src="../js/geral.js"></script>
	<script type="text/javascript" src="../js/cadastro.js"></script>

</head>

<body class="login-container">

	<!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="./"><img src="../imgs/logo_noobets_white.png" alt=""></a>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">
				<? /* ============================ LOGIN ============================ */ ?>
				<!-- Simple login form -->
				<form id="frm_login" action="../act/login.php" target="ifr_action" method="POST" style="display:<?=(($target=="login")?"":"none")?>;">
					<div class="panel panel-body login-form">
						<div class="text-center">

							<img src="../imgs/logo_noobets.png" width="195" height="auto" class="" />
							<h5 class="content-group">Acesse sua conta <small class="display-block">Informe seu login e senha</small></h5>
						</div>

						<div class="form-group has-feedback has-feedback-left">
							<input type="text" class="form-control" placeholder="E-mail" id="username" name="username">
							<div class="form-control-feedback">
								<i class="icon-mention text-muted"></i>
							</div>
						</div>

						<div class="form-group has-feedback has-feedback-left">
							<input type="password" class="form-control" placeholder="Senha" id="password" name="password">
							<div class="form-control-feedback">
								<i class="icon-lock2 text-muted"></i>
							</div>
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-primary btn-block">Entrar <i class="icon-circle-right2 position-right"></i></button>
						</div>

						<div class="text-center">
							<a href="javascript:showBoxLogin('senha');">Esqueceu sua senha?</a>
						</div>
						<div class="text-center">
							<span class="text-muted">Ainda não tem uma conta?</span>
							<a href="javascript:showBoxLogin('cadastro');">Cadastre-se!</a>
						</div>
					</div>
				</form>
				<!-- /simple login form -->
				<? /* ============================ SENHA PASSO 1 - SEND EMAIL ============================ */ ?>
				<!-- Password recovery -->
				<form id="frm_senha" action="../act/esqueci.php" target="ifr_action" method="POST" style="display:<?=(($target=="senha")?"":"none")?>;">
					<div class="panel panel-body login-form">
						<div class="text-center">
							<div class="icon-object border-warning text-warning"><i class="icon-spinner11"></i></div>
							<h5 class="content-group">Redefinir senha <small class="display-block">Enviaremos um link para o seu e-mail</small></h5>
						</div>

						<div class="form-group has-feedback">
							<input type="email" class="form-control" placeholder="Seu e-mail" id="txt_senha_email" name="txt_senha_email" />
							<div class="form-control-feedback">
								<i class="icon-mail5 text-muted"></i>
							</div>
						</div>

						<button type="submit" class="btn bg-blue btn-block">Enviar link <i class="icon-arrow-right14 position-right"></i></button>

						<div class="text-center">
							<br />
							<a href="javascript:showBoxLogin('login');"><i class="icon-arrow-left52"></i>&nbsp;Voltar ao Login</a>
						</div>
					</div>
				</form>
				<!-- /password recovery -->
				<? /* ============================ SENHA PASSO 2 - RESET SENHA ============================ * / ?>
				<!-- Password reset -->
				<form id="frm_reset" action="../act/esqueci.php?act=reset" target="ifr_action" method="POST" style="display:<?=(($target=="reset")?"":"none")?>;">
					<input type="hidden" name="hdd_reset_id" id="hdd_reset_id" value="<?=$_REQUEST["id"]?>" />
					<input type="hidden" name="hdd_reset_email" id="hdd_reset_email" value="<?=$_REQUEST["email"]?>" />
					<input type="hidden" name="hdd_reset_hash" id="hdd_reset_hash" value="<?=$_REQUEST["hash"]?>" />
					<div class="panel panel-body login-form">
						<div class="text-center">
							<div class="icon-object border-warning text-warning"><i class="icon-spinner11"></i></div>
							<h5 class="content-group">Nova senha <small class="display-block">Enviaremos um link para o seu e-mail</small></h5>
						</div>

						<div class="form-group has-feedback">
							<input type="password" class="form-control" placeholder="Nova senha" id="txt_reset_senha" name="txt_reset_senha" />
							<div class="form-control-feedback">
								<i class="icon-mail5 text-muted"></i>
							</div>
						</div>

						<div class="form-group has-feedback">
							<input type="password" class="form-control" placeholder="Digite novamente a nova senha" id="txt_reset_confirma" name="txt_reset_confirma" />
							<div class="form-control-feedback">
								<i class="icon-mail5 text-muted"></i>
							</div>
						</div>

						<button type="submit" class="btn bg-blue btn-block">Enviar link <i class="icon-arrow-right14 position-right"></i></button>

						<div class="text-center">
							<br />
							<a href="javascript:showBoxLogin('login');"><i class="icon-arrow-left52"></i>&nbsp;Voltar ao Login</a>
						</div>
					</div>
				</form>
				<!-- /password recovery -->
				<? /* ============================ CADASTRO ============================ */ ?>
				<!-- Advanced login -->
				<form id="frm_cadastro" action="../act/cadastro.php" target="ifr_action" method="POST" style="display:<?=(($target=="cadastro")?"":"none")?>;">
					<div class="panel panel-body login-form">
						<div class="text-center">
							<div class="icon-object border-success text-success"><i class="icon-plus3"></i></div>
							<h5 class="content-group">Criar conta <small class="display-block">Todos os campos são obrigatórios</small></h5>
						</div>

						<div id="cad_div_alert" class="text-center" style="display: none;">
							<div class="alert alert-danger">
								<i class="icon-warning"></i>&nbsp;<span id="cad_spn_desc"></span>
							</div>
						</div>


						<div class="content-divider text-muted form-group"><span>Informe seus dados</span></div>

						<div class="form-group has-feedback has-feedback-left">
							<input type="text" class="form-control" placeholder="Seu nome" name="txt_cadastro_nome" id="txt_cadastro_nome" required="required" />
							<div class="form-control-feedback">
								<i class="icon-user-check text-muted"></i>
							</div>
						</div>

						<div class="form-group has-feedback has-feedback-left">
							<input type="text" class="form-control" placeholder="Sua empresa" name="txt_cadastro_empresa" id="txt_cadastro_empresa" required="required" />
							<div class="form-control-feedback">
								<i class="icon-collaboration text-muted"></i>
							</div>
						</div>

						<div class="form-group has-feedback has-feedback-left">
							<input type="text" class="form-control format-phone-number" placeholder="Seu Telefone" name="txt_cadastro_fone" id="txt_cadastro_fone" required="required" />
							<div class="form-control-feedback">
								<i class="icon-phone2 text-muted"></i>
							</div>
						</div>

						<div class="content-divider text-muted form-group"><span>Dados de Login</span></div>

						<div class="form-group has-feedback has-feedback-left">
							<input type="text" class="form-control" placeholder="Seu e-mail" name="txt_cadastro_email" id="txt_cadastro_email" required="required" />
							<div class="form-control-feedback">
								<i class="icon-mention text-muted"></i>
							</div>
							<!-- <span class="help-block text-danger"><i class="icon-cancel-circle2 position-left"></i> This username is already taken</span> -->
						</div>

						<div class="form-group has-feedback has-feedback-left">
							<input type="password" class="form-control" placeholder="Defina uma senha" name="txt_cadastro_senha" id="txt_cadastro_senha" required="required" />
							<div class="form-control-feedback">
								<i class="icon-user-lock text-muted"></i>
							</div>
						</div>

						<div class="form-group has-feedback has-feedback-left">
							<input type="password" class="form-control" placeholder="Repita a senha" name="txt_cadastro_senha_conf" id="txt_cadastro_senha_conf" required="required" />
							<div class="form-control-feedback">
								<i class="icon-user-lock text-muted"></i>
							</div>
						</div>

						<div class="content-divider text-muted form-group"><span>Fique atento ao Noobets</span></div>

						<div class="form-group">

							<div class="checkbox">
								<label>
									<input type="checkbox" class="styled" name="chk_newsletter" id="chk_newsletter" checked="checked" value="1">
									Quero receber notícias do Noobets
								</label>
							</div>
							<? /* ?>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="chk_termos" id="chk_termos" class="styled" required="required" value="1" />
									Aceito os <a href="#">Termos de serviço</a>
								</label>
							</div>
							<? */ ?>
						</div>

						<button type="submit" class="btn bg-teal btn-block btn-lg">Cadastrar! <i class="icon-circle-right2 position-right"></i></button>

						<div class="text-center">
							<br />
							<a href="javascript:showBoxLogin('login');"><i class="icon-arrow-left52"></i>&nbsp;Voltar ao Login</a>
						</div>

					</div>
				</form>
				<!-- /advanced login -->
				<? /* ============================ CADASTRO CONFIRMACAO ============================ */ ?>
				<!-- Password reset -->
				<form id="frm_confirma" action="#" target="ifr_action" method="POST" style="display:<?=(($target=="confirma")?"":"none")?>;">
					<div class="panel panel-body login-form">
						<div class="text-center">
							<div class="icon-object border-<?=$class_confirmacao?> text-<?=$class_confirmacao?>"><i class="icon-<?=$icone_confirmacao?>"></i></div>
							<h5 class="content-group">Confirmação de cadastro <small class="display-block">&nbsp;</small></h5>
						</div>

						<div class="form-group text-center">
							<div class="alert alert-<?=$class_confirmacao?>">
								<i class="icon-<?=$icone_confirmacao?>"></i>&nbsp;<span><?=$mensagem_confirmacao_cadastro?></span>
							</div>
						</div>

						<div class="text-center">
							<br />
							<a href="javascript:showBoxLogin('login');"><i class="icon-arrow-left52"></i>&nbsp;Ir ao Login</a>
						</div>
					</div>
				</form>
				<!-- /password recovery -->


				<iframe id="ifr_action" name="ifr_action" frameborder="0" width="0" height="0"></iframe>

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->


	<!-- Footer -->
	<div class="footer text-muted text-center">
		&copy; <?=date("Y")?>. <a href="#">Noobets</a> by <a href="http://www.tere.red" target="_blank">Tere.red</a>
	</div>
	<!-- /footer -->

</body>
</html>
