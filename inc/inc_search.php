<?
$txt_search = trim($_REQUEST["q"]);
$slc_search_status = trim($_REQUEST["s"]);
?>
<div class="col-lg-6" style="margin:10px;">
    <form role="form" class="form-inline" action="" method="post">
        <input type="hidden" id="hdd_current_page" name="hdd_current_page" value="<?=$sss_current_page?>" />
        <div class="form-group">
            <label>Buscar:</label>
            <input type="text" name="txt_search" id="txt_search" class="form-control noLimit" placeholder="Buscar..." value="<?=$txt_search?>" maxlength="150" onkeypress="if(TeclaEnter(event)){rSearch();return false;}" />
            <?
            if(!$bool_hidde_search_status){
                ?>
                <select name="slc_search_status" id="slc_search_status" class="form-control">
                    <option value="">Todos</option>
                    <option value="A"<?=(($slc_search_status=="A")?" selected":"")?>>Ativos</option>
                    <option value="I"<?=(($slc_search_status=="I")?" selected":"")?>>Inativos</option>
                </select>
                <?
            }//if
            ?>
            <a class="btn btn-default" name="btn_search" id="btn_search" onclick="rSearch();return false;">
                <i class="fa fa-search"></i> Buscar
            </a>
        </div>
    </form>
</div>