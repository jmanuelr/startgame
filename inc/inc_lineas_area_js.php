<?
//echo "<pre>";
//print_r($arr_result);
//echo "</pre>";
?>
$(function() {


    // Set paths
    // ------------------------------

    require.config({
        paths: {
            echarts: 'assets/js/plugins/visualization/echarts'
        }
    });


    // Configuration
    // ------------------------------

    require(
        [
            'echarts',
            'echarts/theme/limitless',
            'echarts/chart/bar',
            'echarts/chart/line'
        ],


        // Charts setup
        function (ec, limitless) {


            // Initialize charts
            // ------------------------------

            <?
            foreach($arr_result as $ant => $arr_dados){
                if(is_array($arr_result[$ant])&&count($arr_result[$ant])>0){
                    ?>
                    var basic_lines_<?=$ant?> = ec.init(document.getElementById('basic_lines_<?=$ant?>'), limitless);
                    basic_lines_options_<?=$ant?> = {
                        grid: {x: 40,x2: 40,y: 35,y2: 25},
                        tooltip: {trigger: 'axis'},
                        legend: {data: ['Evolução']},
                        color: ['#EF5350', '#66BB6A'],
                        calculable: true,
                        xAxis: [{type: 'category',boundaryGap: false,data: [<?
                                    $tmp_str = '';
                                    foreach($arr_dados as $data => $dado){
                                        if($dado!=''){
                                            if($tmp_str!=''){
                                                $tmp_str .= ',';
                                            }//if
                                            $tmp_str .= "'".$data."'";
                                        }//if
                                    }//foreach
                                    echo $tmp_str;
                                    ?>]  
                        }],
                        yAxis: [{type: 'value',axisLabel: {formatter: '{value}'}}],
                        series: [
                            {
                                name: 'Maximum',
                                type: 'line',
                                data: [<?
                                    $tmp_str = '';
                                    foreach($arr_dados as $data => $dado){
                                        if($dado!=''){
                                            if($tmp_str!=''){
                                                $tmp_str .= ',';
                                            }//if
                                            $tmp_str .= $dado;
                                        }//if
                                    }//foreach
                                    echo $tmp_str;
                                    ?>],
                                markLine: {
                                    data: [{
                                        type: 'average',
                                        name: 'Average'
                                    }]
                                }
                            }
                        ]
                    };

                    basic_lines_<?=$ant?>.setOption(basic_lines_options_<?=$ant?>);
                    <?
                }//if
                
            }//foreach
            ?>

            window.onresize = function () {
                setTimeout(function () {
                    <?
                    foreach($arr_result as $ant => $arr_dados){
                        if(is_array($arr_result[$ant])&&count($arr_result[$ant])>0){
                            ?>
                            basic_lines_<?=$ant?>.resize();
                            <?
                        }//if
                    }//foreach
                    ?>
                }, 200);
            }
        }
    );
});