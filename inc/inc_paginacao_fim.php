<?
//------------------------------------------------------------------- cfg paginacao -->>
$style_a_page 	= "";
$link_separador = "";
$html_paginacao = "";
$menos	= $pagina - 1;
$mais	= $pagina + 1;
$pgs 	= ceil($total_count / $max);

if($total_count > 0 ) {
	$html_paginacao .= "<div class=\"row\">";
		$html_paginacao .= "<div class=\"col-sm-6\">";
			$html_paginacao .= "<div class=\"dataTables_info\" id=\"dataTables-example_info\" role=\"alert\">Mostrando ".($inicio+1)." a ".($inicio+$result_count)." de ".$total_count."</div>";
		$html_paginacao .= "</div>";

	$html_paginacao .= "<div class=\"col-sm-6\">";
    	$html_paginacao .= "<div class=\"dataTables_paginate paging_simple_numbers\" id=\"dataTables-example_paginate\">";
		//-----------------------------------
		if($pgs > 1 ) {

			$html_paginacao .= "<ul class=\"pagination\" style=\"float:right;\">";

			if($menos>0){
				if($menos>1)$html_paginacao .= "<li><a href='".str_replace("§","1",$link_paginacao)."' style=\"".$style_a_page."\" title=\"Primeira\" class=\"bt_nav_esq\">&laquo;</a></li>".$link_separador;
				$html_paginacao .= "<li><a href='".str_replace("§",$menos,$link_paginacao)."' style=\"".$style_a_page."\" title=\"Anterior\" class=\"bt_nav_esq\">&lt;</a></li>".$link_separador;
			}//if

			$anterior	= (($pagina-$pag_qtde_show) < 1 ) ? 1 : $pagina-$pag_qtde_show;
			$posterior	= (($pagina+$pag_qtde_show) > $pgs ) ? $pgs : $pagina + $pag_qtde_show;

			for($i=$anterior; $i <= $posterior;$i++) $html_paginacao .=  ($i != $pagina) ? " <li class=\"paginate_button \"><a href='".str_replace("§",$i,$link_paginacao)."' style=\"".$style_a_page."\"title=\"".$i."\" >".$i."</a></li>" : " <li class=\"paginate_button active\" class=\"active\"><a>".$i."</a></li>";


			if($mais <= $pgs){
				$html_paginacao .=  $link_separador."<li class=\"paginate_button \"><a href='".str_replace("§",$mais,$link_paginacao)."' style=\"".$style_a_page."\" title=\"Pr&oacute;xima\" class=\"bt_nav_dir\">&gt;</a></li>";
				if($mais < $pgs)$html_paginacao .=  $link_separador."<li class=\"paginate_button \"><a href='".str_replace("§",$pgs,$link_paginacao)."' style=\"".$style_a_page."\" title=\"&Uacute;ltima\" class=\"bt_nav_dir\">&raquo;</a></li>";
			}//if

			$html_paginacao .=  "</ul>";
		}//if($pgs > 1 )
		//-----------------------------------
		$html_paginacao .=  "</div>";
	$html_paginacao .=  "</div>";
}//if

echo $html_paginacao;
//------------------------------------------------------------------- cfg paginacao --<<
/*
?>
<div class="row">

    <div class="col-sm-6">
        <div class="dataTables_info" id="dataTables-example_info" role="alert">Showing 1 to 10 of 57 entries</div>
    </div>

    <div class="col-sm-6">
        <div class="dataTables_paginate paging_simple_numbers" id="dataTables-example_paginate">
            <ul class="pagination">
                <li class="paginate_button previous disabled" tabindex="0" id="dataTables-example_previous"><a href="#">Previous</a></li>
                <li class="paginate_button active" tabindex="0"><a href="#">1</a></li>
                <li class="paginate_button " tabindex="0"><a href="#">2</a></li>
                <li class="paginate_button " tabindex="0"><a href="#">3</a></li>
                <li class="paginate_button " tabindex="0"><a href="#">4</a></li>
                <li class="paginate_button " tabindex="0"><a href="#">5</a></li>
                <li class="paginate_button " tabindex="0"><a href="#">6</a></li>
                <li class="paginate_button next" tabindex="0" id="dataTables-example_next"><a href="#">Next</a></li>
            </ul>
        </div>
    </div>
    
</div>
<?
*/
?>