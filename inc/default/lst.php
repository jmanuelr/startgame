<?
    include(__DIR__."/ini.php");

    //echo "<pre>";
    //print_r($result_campos);
    //echo "</pre>";
    /*
    [0] => cdd_id
        [Field] => cdd_id
    [1] => int(11) unsigned
        [Type] => int(11) unsigned
    [2] => NO
        [Null] => NO
    [3] => PRI
        [Key] => PRI
    [4] =>
        [Default] =>
    [5] => auto_increment
        [Extra] => auto_increment

    field comment: {label:"Cidade booh",editable:1,showlist:1,showform:1,option:{"A":"Ativo","I","Inativo"}}
    */

?>
<div class="panel panel-flat">
    <div class="panel-body">
        <div id="div_lista" class="table-responsive">
            <table class="table datatable-ajax">
                <thead>
                    <?
                    if(count($result_registros)==0){
                        ?><th>Não foram encontrados registros</th><?
                    }else{
                        $i=0;
                        foreach ($result_campos as $chave => $valor) {
                            $campo  = $valor[0];
                            $tipo   = $valor[1];
                            //----
                            //$comando         = "SELECT COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = 'goonbo' AND TABLE_NAME = '".$db_table."' AND COLUMN_NAME = '".$campo."'";
                            //$result_comment   = $acessoBanco->selectRegistrobySQL($comando);
                            //$result_comment[0][0]
                            //----
                            if($tb_prefixo!=""){
                                $campo = str_replace($tb_prefixo."_", "", $campo);
                            }//if
                            ?>
                            <th class="<?=(($i>1)?"hidden-sm hidden-xs":"")?>"><?=$campo?></th>
                            <?
                            $i++;
                        }//foreach
                        ?>
                        <th>&nbsp;</th>
                        <?
                    }//if
                    ?>
                </thead>
            </table>
        </div>
        <? /* =========================================== */ ?>
        <div id="div_form"></div>
    </div>
</div>