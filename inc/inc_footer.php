<iframe id="ifr_action" name="ifr_action" frameborder="0" width="0" height="0"></iframe>



    <!-- Core JS files -->
    <script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>

    <script src="js/jquery.mask.min.js" type="text/javascript"></script>
    <? /* <script type="text/javascript" src="assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script><? */  ?>
    <script type="text/javascript" src="js/bootstrap-maxlength.min.js"></script>

    <script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/ui/nicescroll.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/ui/drilldown.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script type="text/javascript" src="assets/js/plugins/ui/dragula/dragula.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/ui/autoscroller/dom-autoscroller.min.js"></script>

    <script type="text/javascript" src="assets/js/plugins/visualization/d3/d3.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/visualization/d3/d3_tooltip.js"></script>

    <script type="text/javascript" src="assets/js/plugins/forms/styling/switchery.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
    <script type="text/javascript" src="assets/js/plugins/ui/moment/moment.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/pickers/daterangepicker.js"></script>
    <script type="text/javascript" src="assets/js/plugins/tables/datatables/datatables.min.js"></script>

    <script type="text/javascript" src="assets/js/plugins/notifications/bootbox.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>

    <script type="text/javascript" src="assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
    <script type="text/javascript" src="assets/js/core/libraries/jquery_ui/touch.min.js"></script>

    <script type="text/javascript" src="assets/js/core/app.js?dt=<?=$date_ymdhis?>"></script>

    <script type="text/javascript" src="assets/js/pages/dashboard.js?dt=<?=$date_ymdhis?>"></script>
    <script type="text/javascript" src="assets/js/pages/table_responsive.js"></script>
    <script type="text/javascript" src="assets/js/plugins/forms/tags/tagsinput.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/forms/tags/tokenfield.min.js"></script>

    <script type="text/javascript" src="assets/js/plugins/notifications/pnotify.min.js"></script>

    <script type="text/javascript" src="assets/js/plugins/editors/wysihtml5/wysihtml5.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/editors/wysihtml5/toolbar.js"></script>
    <script type="text/javascript" src="assets/js/plugins/editors/wysihtml5/parsers.js"></script>
    <script type="text/javascript" src="assets/js/plugins/editors/wysihtml5/locales/bootstrap-wysihtml5.ua-UA.js"></script>
    <script type="text/javascript" src="assets/js/plugins/notifications/jgrowl.min.js"></script>


    <script type="text/javascript" src="assets/js/plugins/visualization/echarts/echarts.js"></script>
    <? /* <script type="text/javascript" src="assets/js/charts/echarts/lines_areas.js"></script> */ ?>


<script type="text/javascript" src="js/geral.js?dt=<?=$date_ymdhis?>"></script>
<script type="text/javascript" src="js/default.js?dt=<?=$date_ymdhis?>"></script>
<?
    if($page_mnu_include!=""){
        $arr_mnu_include = explode(";",$page_mnu_include);
        foreach($arr_mnu_include as $mnu_include){
            if(is_file("./js/".$mnu_include)){
                $tmp_id = (isset($index_id))?$index_id:$_REQUEST["id"];//setar $index_id nas páginas ou pegar direto request id
                //if($_REQUEST["mnu"]==19 && $mnu_include=='questionario.php'){
                //   $tmp_id = $frm_id;
                //}//if
                ?>
                <script src="./js/<?=$mnu_include?>?id=<?=$tmp_id.$include_extra_params?>&dt=<?=$date_ymdhis?>"></script>
                <?
            }//if
        }//foreach
    }//if

    if(is_file("./inc/".$obj_path."/script.js")){
        ?>
        <script type="text/javascript" src="./inc/<?=$obj_path?>/script.js?dt=<?=$date_ymdhis?>"></script>
        <?
    }//if
?>
<?
	/*
    foreach($arr_js_includes as $js_include){
            if(is_file("./js/".$js_include)){
                ?>
                <script src="./js/<?=$js_include?>?dt=<?=$date_ymdhis?>"></script>
                <?
            }//if
    }//foreach
    */
    if($bool_show_footer){
    	?>
    	<!-- Footer -->
		<div class="footer text-muted" style="z-index: 1;">
			&copy; <?=date("Y")?>. <a href="#"><?=$sys_general["sys_name"]?></a> by <a href="#" target="_blank"><?=$sys_general["sys_name"]?></a>
		</div>
		<!-- /footer -->
    	<?
    }//if
?>
<script>
    $(document).ready(function() {
    <?
    if(($oLoggedUsuario->Confirmacao == 0) && (strpos($page_include, "dashboard")!==false)) {
        ?>
        myPNConfirmMail();
        <?
    }//if
    if($_REQUEST["page"]=="workflow" && isset($_REQUEST["task"])){
        ?>
        $('#a_tsk_<?=$_REQUEST["task"]?>_title').trigger('click');
        <?
    }//if
    ?>
    });
    <?
    if($_REQUEST["mnu"]==""){
        include(__DIR__."/inc_lineas_area_js.php");
    }//if
    ?>
</script>