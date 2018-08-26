<?
    require_once(__DIR__."/../inc_user_check.php");
    include(__DIR__."/ini.php");


?>{
    "draw": <?=intval($_REQUEST["draw"])?>,
    "recordsTotal" : <?=$total_count?>,
    "recordsFiltered" : <?=$total_count?>,
  "data": [
    <?
    $contador = 0;
    foreach ($result_registros as $chave_reg => $valor_reg) {
        ?>
        {<?
            $i=0;
            foreach ($result_campos as $chave => $valor) {
                ?>"<?=$chave?>": "<?=$valor_reg[$valor[0]]?>",
                <?
                $i++;
            }//while
            ?>
            "buttom": "<a class='btn btn-default' href='./?mnu=<?=$page_id_mnu?>&act=frm&id=<?=$valor_reg[0]?>'><i class='fa fa-edit'></i> Editar</a>"
          }<?
        $contador++;
        if($contador<count($result_registros))echo ",";
    }//foreach
    ?>
  ]
}