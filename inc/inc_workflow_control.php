<?
$dt_now = date("Ymd");

$wrk_id = $obj_id;

$oWorkflow 	= WorkflowBD::get($wrk_id);

$bool_is_workflow = false;
$str_titulo_workflow = "On Boardings";
if($_REQUEST["page"]=="workflow" && $_REQUEST["act"]=="dtl"){
	$bool_is_workflow = true;
	$str_titulo_workflow = $oWorkflow->Titulo;
}//if


//=================================================
/*
select tsk_id,tsk_titulo,tsk_descricao,tsk_id_fse,tsk_id_wrk,tsk_seq,qst_titulo,qst_descricao,tqs_id_tsk
from gnb_task
inner join gnb_question on qst_id_fse = tsk_id_fse
inner join gnb_equipe_question on eqs_id_qst = qst_id
left join gnb_task_question on tqs_id_tsk = tsk_id and tqs_id_qst = qst_id
where qst_status = 'A' AND tsk_status = 'A' AND (eqs_id_usr = 1 OR eqs_id_eqp in (select distinct(esr_id_eqp) from gnb_equipe_usuario where esr_id_usr = 1))
AND tqs_id_tsk is null
group by qst_id
order by tsk_seq,qst_seq

// ------ exemplo
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CalculaNota`( `id_prod` int)
BEGIN
    declare nota int(11);
    SELECT CEIL(SUM(sus_pontos)/COUNT(*)) INTO nota FROM frb_star_usuario WHERE sus_id_prd = id_prod;
    UPDATE frb_produto SET prd_star = nota WHERE prd_id = id_prod;
END;;
DELIMITER ;


select count(distinct(qst_id)) as qtde_todo#,tsk_id,tsk_titulo,tsk_descricao,tsk_id_fse,tsk_id_wrk,tsk_seq,qst_titulo,qst_descricao,tqs_id_tsk
from gnb_task
inner join gnb_question on qst_id_fse = tsk_id_fse
inner join gnb_equipe_question on eqs_id_qst = qst_id
left join gnb_task_question on tqs_id_tsk = tsk_id and tqs_id_qst = qst_id
where qst_status = 'A' AND tsk_status = 'A' AND (eqs_id_usr = 1 OR eqs_id_eqp in (select distinct(esr_id_eqp) from gnb_equipe_usuario where esr_id_usr = 1))
AND tqs_id_tsk is null;
#group by qst_id
#order by tsk_seq,qst_seq;

DELIMITER ;;
CREATE PROCEDURE `SP_CalculaToDo`( `id_user` int)
BEGIN
    declare qtde_todo int(11);

    select count(distinct(qst_id)) INTO qtde_todo
	from gnb_task
	inner join gnb_question on qst_id_fse = tsk_id_fse
	inner join gnb_equipe_question on eqs_id_qst = qst_id
	left join gnb_task_question on tqs_id_tsk = tsk_id and tqs_id_qst = qst_id
	where qst_status = 'A'
	AND tsk_status = 'A'
	AND (eqs_id_usr = id_user OR eqs_id_eqp in (select distinct(esr_id_eqp) from gnb_equipe_usuario where esr_id_usr = id_user))
	AND tqs_id_tsk is null;

    UPDATE gnb_usuario SET usr_todo = qtde_todo WHERE usr_id = id_user;
END;;
DELIMITER ;
-----
BEGIN
	      CALL SP_CalculaNota (new.sus_id_prd);
END
// ------


//$oListaTask 	= TaskBD::getLista("tsk_id_usr = ".$_SESSION["sss_usr_id"]." AND tsk_status = 'A'");


$int_val_task_todo = count($oListaTaskTodo);
*/
$int_val_task_todo = intval($oMainUsuario->Todo);
//=================================================
?>