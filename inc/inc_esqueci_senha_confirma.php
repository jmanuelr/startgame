<?
//require_once("lib/classes/class.RN.php");
//require_once("lib/classes/class.usuarioBD.php");
//include("inc_breadcrumb.php");
//echo  RN::en_de_crypt("﻿rb{}o");

$strUrlSite = Config::appSettings('strUrlSite');

$usr_id = preg_replace("/[^0-9]/i","",strtolower($_REQUEST["id"]));
//$usr_cnpj = preg_replace("/[^0-9]/i","",strtolower($_REQUEST["cnpj"]));
//$usr_email = trim($_REQUEST['email']);

$condicao = "usr_id = '".$usr_id."' AND usr_status = 'A'";//AND usr_email  = '".$usr_email."'
//if($usr_cnpj!="")$condicao.=" AND usr_cnpj = '".$usr_cnpj."'";

$oListaUsuario = UsuarioBD::getLista($condicao,"",0,1);

$bool_mostra_formulario = true;
$bool_mostra_erro = false;

if(count($oListaUsuario)>0){

    $oUsuario = $oListaUsuario[0];

    $sha1 = sha1($oUsuario->Id.$oUsuario->Cpf.$oUsuario->Tipo.$oUsuario->Senha);

    //echo "[oUsuario: ".$oUsuario->Id.".".$oUsuario->Cpf.".".$oUsuario->Tipo.".".$oUsuario->Senha."]";
    //echo "[sha1: $sha1]";

    if($sha1 == $_REQUEST['key'] && ($_REQUEST['txt_password1']!="") ){
        if( $_REQUEST['txt_password1'] == $_REQUEST['txt_password2'] ){
            /* Altera senha do usuário */
            $oUsuario = UsuarioBD::get($oUsuario->Id);
            $oUsuario->Senha = sha1($_REQUEST['txt_password1']);
            UsuarioBD::alter($oUsuario);
            $bool_mostra_formulario = false;
        }else{
            //echo "[txt_password1: $txt_password1]";
        }//if
    }//if

}else{
    $bool_mostra_erro = true;
}//if

?>
<div class="col-lg-12">

                    <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-edit font-blue-sunglo"></i>
                                            <span class="caption-subject font-blue-sunglo bold uppercase">
                                                Estabelecer Nova Senha
                                            </span>
                                            <span class="caption-helper"></span>
                                        </div>

                                    </div>
                                    <div class="portlet-body form">
                                        <!-- BEGIN FORM-->
                                        <form name="form_nova_senha" id="form_nova_senha" method="post" class="form-horizontal" action="./?area=esqueci_minha_senha_confirmacao&id=<?=$_REQUEST['id']?>&key=<?=$_REQUEST['key'] ?>">


                                            <div class="form-body">
                                                <?
                                                /* <input type="hidden" name="hdd_id" id="hdd_id" value="<?=$obj_id?>" /> */

                                                if(!$bool_mostra_erro){
                                                    if($bool_mostra_formulario){
                                                        ?>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Nova Senha</label>
                                                            <div class="col-md-4">
                                                                <span class="help-block"></span>
                                                                <div class="input-icon right">
                                                                    <i class="fa fa-key"></i>
                                                                    <input class="form-control placeholder-no-fix noLimit" type="password" autocomplete="off" placeholder="Nova Senha" name="txt_password1"  id="txt_password1" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Confirma Nova Senha</label>
                                                            <div class="col-md-4">
                                                                <span class="help-block"></span>
                                                                <div class="input-icon right">
                                                                    <i class="fa fa-key"></i>
                                                                    <input class="form-control placeholder-no-fix noLimit" type="password" autocomplete="off" placeholder="Nova Senha" name="txt_password2"  id="txt_password2" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?
                                                    }else{
                                                        ?>
                                                        <div class="alert alert-success">
                                                            <p>A sua senha foi alterada. Clique <a href="./" title="Clique aqui para logar">aqui</a> para logar.</p>
                                                        </div>
                                                        <?
                                                    }//if

                                                }else{
                                                    ?>
                                                    <div class="alert alert-danger">
                                                        <p>Não foi possível identificar o usuário.
                                                        <br/>Por favor, reinicie o processo de restabelecer a senha.</p>
                                                    </div>
                                                    <?
                                                }//if
                                                ?>
                                            </div>
                                            <?
                                            if( !$bool_mostra_erro && $bool_mostra_formulario ){
                                                ?>
                                                <div class="form-actions">
                                                    <div class="row">
                                                        <div class="col-md-offset-3 col-md-9">
                                                            <button type="submit" class="btn green">Enviar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?
                                            }//if
                                            ?>
                                        </form>
                                        <!-- END FORM-->
                                    </div>
                                </div>


</div>