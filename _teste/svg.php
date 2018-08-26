<?
require_once('../assets/chart/php/SVGGraph/SVGGraph.php');

$colours = array('#32b754', '#ff9c43', '#316dc4');

$arr_values = explode(",",$_REQUEST["v"]);
 
$settings = array(
  //'auto_fit' => true,
  'pad_top' => 0,
  'pad_bottom' => 0,
  'pad_left' => 0,
  'pad_right' => 0,
  'back_colour' => '#fff',   'stroke_colour' => '#fff',
  'back_stroke_width' => 0,  'back_stroke_colour' => '#eee',
  'pad_right' => 0,         'pad_left' => 0,
  'link_base' => '/',        'link_target' => '_top',
  'show_labels' => false,     //'show_label_amount' => true,
  'label_font' => 'Georgia', 'label_font_size' => '11',
  'label_colour' => '#000',  //'units_before_label' => '$',
  'sort' => false, 'inner_radius' => 0.4
);
 
$values = array();

foreach($arr_values as $valor){
  $values[] = $valor;
}//foreach

//$links = array('Dough' => 'jpegsaver.php', 'Ray' => 'crcdropper.php', 'Me' => 'svggraph.php');
 
$graph = new SVGGraph(20, 20, $settings);
$graph->colours = $colours;
$graph->Values($values);
//$graph->Links($links);
$graph->Render('DonutGraph');
?>