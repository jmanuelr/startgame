<?
	require_once(__DIR__.'/../lib/classes/class.usuarioBD.php');
	require_once(__DIR__.'/../lib/classes/class.clienteBD.php');
	require_once(__DIR__.'/../lib/classes/class.workflowBD.php');
	require_once(__DIR__.'/../lib/classes/class.faseBD.php');
	require_once(__DIR__.'/../lib/classes/class.questionBD.php');
	require_once(__DIR__.'/../lib/classes/class.equipe_questionBD.php');
	require_once(__DIR__.'/../lib/classes/class.taskBD.php');

	$wrk_id = $_REQUEST["wrk"];
	$fse_id = $_REQUEST["fse"];
	$tsk_id = $_REQUEST["tsk"];

	$oListaQuestion = QuestionBD::getLista("qst_id_fse = ".$fse_id." AND qst_status = 'A'", "qst_seq");

	$contador_question = 0;
	foreach($oListaQuestion as $oQuestion){
		$contador_question++;
		$class_active = "";//($contador==1)?"active":"";

		$oListaEquipeQuestion = EquipeQuestionBD::getLista("eqs_id_qst = ".$oQuestion->Id);
		$str_equipe = "";
		foreach($oListaEquipeQuestion as $oEquipeQuestion){
			$int_equipe  = $oEquipeQuestion->_Equipe;
			$int_usuario = $oEquipeQuestion->_Usuario;
			$tmp_str = "";

			if($int_equipe != "" && $int_equipe > 0){
				$tmp_str = "t:".$int_equipe;
			}elseif($int_usuario != "" && $int_usuario > 0){
				$tmp_str = "u:".$int_usuario;
			}//if

			if($tmp_str !=""){
				if($str_equipe !="")$str_equipe.=",";
				$str_equipe.=$tmp_str;
			}//if

		}//foreach

		?>
		<li class="<?=$class_active?> has-feedback ui-sortable-handle liItem" id="li_qst_<?=$contador_question?>" qst="<?=$oQuestion->Id?>"  titulo="<?=$oQuestion->Titulo?>" descricao="<?=$oQuestion->Descricao?>" obrigatorio="<?=$oQuestion->Required?>" equipe="<?=$str_equipe?>">
			<a id="a_titulo_qst_<?=$contador_question?>" href="#" onclick="selectItem(this.id,true, <?=$contador_question?>);return false;">
				<span class="badgecontador badge badge-danger pull-left"><?=$contador_question?></span>
				<i class="icon-dots dragula-handle pull-right"></i>
				<span id="spn_titulo_qst_<?=$contador_question?>" onclick="editItem(this,true, <?=$contador_question?>);">
					<?=$oQuestion->Titulo?>
				</span>
			</a>
			<input id="txt_titulo_qst_<?=$contador_question?>" type="text" class="form-control faseHiddenText inputAutoSave" value="<?=$oQuestion->Titulo?>" onblur="editItem(this,false, <?=$contador_question?>);" />
			<div class="form-control-feedback" style="display:none;">
				<i class="icon-edit"></i>
			</div>
			<span class="dropdown pull-right spanOptions">
				<a href="#" class="text-default dropdown-toggle" data-toggle="dropdown"><i class="icon-cog"></i> <span class="caret"></span></a>
				<ul class="dropdown-menu dropdown-menu-right">
					<li><a href="#" onclick="selectItem('a_titulo_fse_<?=$contador_question?>',true, <?=$contador_question?>);return false;"><i class="icon-pencil7"></i> Editar</a></li>
					<li><a href="#" onclick="arquivaItem('qst', <?=$contador_question?>);return false;"><i class="icon-drawer-in"></i> Arquivar</a></li>
				</ul>
			</span>
		</li>
		<?
	}//foreach
?>