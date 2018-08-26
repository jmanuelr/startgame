<?php
require_once 'CompoundDocument.inc.php';
require_once 'BiffWorkbook.inc.php';

$fileName = 'test.xls';

if (!is_readable ($fileName)) die ('Cannot read ' . $fileName);

$doc = new CompoundDocument ('utf-8');
$doc->parse (file_get_contents ($fileName));
$wb = new BiffWorkbook ($doc);
$wb->parse ();

foreach ($wb->sheets as $sheetName => $sheet)
{
	echo '<h1>' . $sheetName . '</h1>';
	echo '<table cellspacing = "0" border="1">';
	for ($row = 0; $row < $sheet->rows (); $row ++)
	{
		echo '<tr>';
		for ($col = 0; $col < $sheet->cols (); $col ++)
		{
			if (!isset ($sheet->cells [$row][$col])) continue;
			$cell = $sheet->cells [$row][$col];
			echo '<td style = "' . $cell->style->css () . '; border:1px solid #c0c0c0;" rowspan = "' . $cell->rowspan . '" colspan = "' . $cell->colspan . '">';
				echo "[$row,$col]";
				echo is_null($cell->value) ? '&nbsp;' : $cell->value;
			echo '</td>';
		}
		echo '</tr>';
	}
	echo '</table>';
}
?>