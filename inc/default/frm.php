<?
    include(dirname(__FILE__)."/ini.php");

?>
<div class="col-md-6">

                        <!-- Advanced legend -->
                        <form action="./?mnu=<?=$page_id_mnu?>&act=act&id=<?=$obj_id?>&key=<?=$frm_key?>" method="POST" target="ifr_action">
                            <div class="panel panel-flat">

                                <div class="panel-body">

                                    <input type="hidden" name="hdd_id" id="hdd_id" value="<?=$obj_id?>">

                                    <fieldset>
                                        <legend class="text-semibold">
                                            <i class="icon-file-text2 position-left"></i>
                                            <?
                                            if($obj_id > 0){
                                                echo "#".$obj_id." - ".$obj_titulo;
                                            }else{
                                                echo "Registro Novo";
                                            }//if
                                            ?>
                                            <a class="control-arrow" data-toggle="collapse" data-target="#demo1">
                                                <i class="icon-circle-down2"></i>
                                            </a>
                                        </legend>

                                        <div class="collapse in" id="demo1">

                                            <?
                                                //echo "<pre>";
                                                //print_r($result_objeto);
                                                //echo "</pre>";
                                                $i=0;
                                                foreach ($result_campos as $chave => $valor) {
                                                    $campo  = $valor[0];
                                                    $tipo   = $valor[1];

                                                    if($tb_prefixo!=""){
                                                        $campo = str_replace($tb_prefixo."_", "", $campo);
                                                    }//if

                                                    $value = (isset($result_objeto))?trim($result_objeto[0][$chave]):"";

                                                    $tamanho = 0;
                                                    $classNoLimit = "noLimit";

                                                    if(stripos($tipo, "varchar")!==false){
                                                        $pattern = "/varchar\(([0-9]+)\)/i";
                                                        $matches = array();
                                                        preg_match($pattern, $tipo, $matches);
                                                        $tamanho = $matches[1];
                                                        $classNoLimit = "";
                                                        //print_r($resultado);
                                                    }//if

                                                    //echo "[\$tamanho: $tamanho]";

                                                    if($campo=="id"){//hdd
                                                        ?>
                                                        <div class="form-group">
                                                            <label><?=$campo?>:</label>
                                                            <input type="hidden" name="hdd_id" id="hdd_id" value="<?=($value!="")?$value:0;?>" />
                                                            <span class="">#<?=$value?></span>
                                                        </div>
                                                        <?
                                                    }elseif($campo =="status"){
                                                        ?>
                                                        <div class="form-group">
                                                            <label class="display-block">Status</label>

                                                            <label class="radio-inline">
                                                                <input type="radio" class="styled" name="txt_status" id="txt_status_A" value="A" <?=(($value=="A")?" checked=\"checked\"":"")?>>
                                                                Ativo
                                                            </label>

                                                            <label class="radio-inline">
                                                                <input type="radio" class="styled" name="txt_status"  id="txt_status_I" value="I" <?=(($value!="A")?" checked=\"checked\"":"")?> />
                                                                Inativo
                                                            </label>
                                                        </div>
                                                        <?
                                                    }else{//txt
                                                        ?>
                                                        <div class="form-group">
                                                            <label><?=$campo?>:</label>
                                                            <input type="text" class="form-control <?=$classNoLimit?>" id="txt_<?=$campo?>" name="txt_<?=$campo?>"placeholder="<?=$campo?>" value="<?=$value?>" <?=(($tamanho>0)?" maxlength=\"".$tamanho."\"":"")?> />
                                                        </div>
                                                        <?
                                                    }//if
                                                    $i++;
                                                }//foreach
                                                ?>

                                        </div>
                                    </fieldset>

                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Salvar <i class="icon-arrow-right14 position-right"></i></button>
                                        <button type="reset" class="btn btn-default">Reset</button>
                                        <button class="btn btn-warning" onclick="if(!cancelEdit())return false;">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- /a legend -->

</div>