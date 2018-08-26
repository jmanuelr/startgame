<?
	require_once(__DIR__."/../lib/classes/class.RN.php");
	require_once(__DIR__."/../lib/classes/class.faseBD.php");
	require_once(__DIR__."/../lib/classes/class.taskBD.php");
	require_once(__DIR__."/../lib/classes/class.task_faseBD.php");

	$condicao_filtro = "";

	if($_REQUEST["wrk"]!=""){
		$wrk_id = $_REQUEST["wrk"];
		if( strlen( trim($_REQUEST["q"]) ) > 2 ){
			$condicao_filtro = " AND ( tsk_titulo like '%".trim($_REQUEST["q"])."%' OR tsk_descricao like '%".trim($_REQUEST["q"])."%' )";
		}//if
	}else{
		$wrk_id = $oWorkflow->Id;
	}//if


	$oListaFase = FaseBD::getLista("fse_id_wrk = ".$wrk_id." AND fse_status = 'A'","fse_seq");
	$col_span = count($oListaFase) + 1;
?>
<tr class="active border-double">
	<td class="fix"></td>
	<?
	$int_sequencia_fase = 0;
	if(count($oListaFase)>0){

		$w_td = ceil(100/(count($oListaFase)+1));

		$total_tempo_pipe = 0;
		foreach($oListaFase as $oFase){

			$int_sequencia_fase++;

			$tempo_limite = intval($oFase->Tempo);
			$total_tempo_pipe += $tempo_limite;

			$oListaTask = TaskBD::getLista("tsk_id_fse = ".$oFase->Id." AND tsk_status = 'A'");
			$qntde_task_in_fase = count($oListaTask);
			$label_negocios = ($qntde_task_in_fase>0)?(($qntde_task_in_fase>1)?$qntde_task_in_fase." negócios":"1 negócio"):"Sem negócios";

			$arr_this_fase = array();

			foreach($oListaTask as $oTask){
				$arr_this_fase[] = $oTask->Id;
			}//id

			$condicao_task_fase = "tfs_id_fse = ".$oFase->Id;

			$oListaTaskFase = TaskFaseBD::getLista($condicao_task_fase);

			$arr_tmp_tsk = array();
			$arr_tmp_tsk_unicas = array();

			$int_total_dias = 0;

			foreach($oListaTaskFase as $oTaskFase){

				if($oTaskFase->DtFim == ''){
					$dias_diferenca = RN::dateDiff2($oTaskFase->DtIni,$dt_now);
				}else{
					$dias_diferenca = intval($oTaskFase->DtDif);
				}//if


				if(in_array($oTaskFase->_Task,$arr_this_fase)){

					if(!isset($arr_tmp_tsk[$oTaskFase->_Task])){
						$arr_tmp_tsk[$oTaskFase->_Task] = $dias_diferenca;
					}else{
						$arr_tmp_tsk[$oTaskFase->_Task] += $dias_diferenca;
					}//if

				}//if

				if(!in_array($oTaskFase->_Task,$arr_tmp_tsk_unicas)){
					$arr_tmp_tsk_unicas[$oTaskFase->_Task] = $oTaskFase->_Task;
				}//if



				$int_total_dias += $dias_diferenca;

			}//foreach

			$int_task_no_prazo = 0;
			$int_task_fora_do_prazo = 0;
			$int_total_tasks = count($arr_tmp_tsk);

			foreach($arr_tmp_tsk as $tmp_id_tsk => $dias_na_fase){
				if($dias_na_fase > $tempo_limite){
					$int_task_fora_do_prazo++;
				}else{
					$int_task_no_prazo++;
				}//if
			}//foreach
			$int_unicas_tasks = count($arr_tmp_tsk_unicas);
			$media_dias_x_task = ($int_unicas_tasks > 0)?($int_total_dias / $int_unicas_tasks):0;
			$percentual_negativo = ($int_total_tasks>0)?floor(100 * $int_task_fora_do_prazo / $int_total_tasks):0;
			$class_label = ($percentual_negativo > 0)?"danger":"success";
			?>
			<td class="tdTop">
				<label class="label label-info"><?=$int_sequencia_fase?></label>
				<?=$oFase->Titulo?><br clear="all" />
				<span class="progress-meter taskprogress pull-left" id="today-progress" data-progress="<?=$percentual_negativo?>" data-color="#F00"></span>
				<small class="text-<?=$class_label?> text-size-base pull-left"><?=$percentual_negativo?>%</small><br clear="all" />
				<span class="text-muted"><?=$label_negocios?></span><br clear="all" />
				<span class="text-muted" title="média dias/dias estimados"><i class="icon-calendar22"></i>&nbsp;<?=number_format($media_dias_x_task,2,",",".")?>/<?=intval($oFase->Tempo)?></span>
			</td>
			<?
		}//foreach
		/*
		?>
		<td class="tdLast">last</td>
		<?
		*/
	}else{
		?>
		<td colspan="<?=($col_span-1)?>">
			<span class="text-muted">Esta pipeline não possui fases ativas. <a href="#">Cadastre as fases aqui</a>.</span>
		</td>
		<?
	}//if
	?>
</tr>
<?
$oListaTask = TaskBD::getLista("tsk_id_wrk = ".$wrk_id." AND tsk_status = 'A'".$condicao_filtro);//,"tsk_dt_registro DESC"

if(count($oListaTask)==0 && count($oListaFase)>0){
	?>
	<td colspan="<?=($col_span)?>">
		<span class="text-muted">Não foram encontrados registros</span>
	</td>
	<?
}//if

foreach($oListaTask as $oTask){

	$tsk_id = $oTask->Id;
	$tsk_titulo = trim($oTask->Titulo);

	$int_qtde_dias_total_da_task = 0;

	if( $tsk_titulo=="" && is_object($oTask->Cliente) ){
		$tsk_titulo = $oTask->Cliente->Nome;
	}//if

	if( $tsk_titulo=="" ){
		$tsk_titulo = "Sem título";
	}//if

	$linha_processo = "";

	?>
	<tr>
	<?

		$count_fase = 0;
		$count_fase_parou_task = 0;
		$qntd_fases = count($oListaFase);



		foreach($oListaFase as $oFase){
			$fse_id = $oFase->Id;

			$oListaTaskFase = TaskFaseBD::getLista("tfs_id_tsk = ".$tsk_id." AND tfs_id_fse = ".$fse_id."","tfs_seq DESC");
			$int_qtde_dias_nesta_fase = 0;
			$label_data_saida = "";
			foreach($oListaTaskFase as $oTaskFase){
				if($oTaskFase->DtFim == ''){
					$dias_diferenca = RN::dateDiff2($oTaskFase->DtIni,$dt_now);
				}else{
					$dias_diferenca = intval($oTaskFase->DtDif);
					$label_data_saida =	substr(RN::NormalDate($oTaskFase->DtFim),0,5);
				}//if

				$int_qtde_dias_nesta_fase += $dias_diferenca;

			}//foreach

			$int_qtde_dias_total_da_task += $int_qtde_dias_nesta_fase;

			$tmp_cell = "";

			if(count($oListaTaskFase)>0){
				$bool_passou = true;
				$count_fase++;

				if($int_qtde_dias_nesta_fase > $oFase->Tempo){
					$label_duracao = "danger";
					$icone_duracao = "cancel";

				}else{
					$label_duracao = "success";
					$icone_duracao = "check";
				}//if

				if($oTask->_Fase==$fse_id){
					$icone = "pencil4";
					$count_fase_parou_task = $count_fase;
					$tooltip = "Dias nesta fase";
				}else{
					//$icone = "alarm-".$icone_duracao;
					$icone = "calendar22";
					$tooltip = "Data saída desta fase (Dias que ficou nesta fase)";
				}//if




				$label_duracao = "<small class=\"text-".$label_duracao." text-size-base\" title=\"".$tooltip ."\">"."<i class=\"icon-".$icone."\"></i>&nbsp;".$label_data_saida." (".$int_qtde_dias_nesta_fase.")</small>";

				$tmp_cell.= $label_duracao;

			}else{
				$bool_passou = false;

				$tmp_cell = "&nbsp;";
			}//if

			$linha_processo .= "<td>".$tmp_cell."</td>";

		}//foreach

		$int_estimativa = $total_tempo_pipe - $int_qtde_dias_total_da_task;

		if($int_estimativa>0){

			$color_package = "success";
			$color_fonte = "#4CAF50";

		}elseif($int_estimativa<0){
			$color_package = "danger";
			$color_fonte = "#F44336";
		}else{
			$color_package = "warning";
			$color_fonte = "#FF5722";
		}//if

		if($qntd_fases>0){
			$percentual_percorrido = floor($count_fase_parou_task * 100 / $qntd_fases);
		}else{
			$percentual_percorrido = 0;
		}//if

		//<i class=\"icon-package\"></i>

		$chart_task = "<span class=\"progress-meter taskprogress pull-left\" id=\"today-progress\" data-progress=\"".$percentual_percorrido."\" data-color=\"".$color_fonte."\"></span>";

		$linha_processo = "<td class=\"fix\">".$chart_task."<span class=\"text-".$color_package." pull-left\">&nbsp;".$tsk_titulo."</span></td>".$linha_processo;

		echo $linha_processo;

		/* <td class="tdLast">last</td> */
	?>
	</tr>
	<?
}//foreach
?>