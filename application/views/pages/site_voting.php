<?php
/**
 * Created by PhpStorm.
 * User: Boris
 * Date: 9/5/14
 * Time: 8:44 PM
 */
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php if ($config_type == 'voting') echo $voting_config['page_title']; ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.0.2 -->

    <link href="<?php echo base_url();?>admin_panel/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>admin_panel/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href="<?php echo base_url();?>admin_panel/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="<?php echo base_url();?>admin_panel/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="<?php echo base_url();?>admin_panel/css/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="<?php echo base_url();?>admin_panel/css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- fullCalendar -->
    <link href="<?php echo base_url();?>admin_panel/css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="<?php echo base_url();?>admin_panel/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="<?php echo base_url();?>admin_panel/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
    <!-- Bootstrap time Picker -->
    <link href="<?php echo base_url();?>admin_panel/css/timepicker/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />

    <!-- jqplot chart -->
    <link href="<?php echo base_url();?>admin_panel/jqplot/jquery.jqplot.min.css" rel="stylesheet" type="text/css" />

    <!-- Theme style -->
    <link href="<?php echo base_url();?>admin_panel/css/AdminLTE.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="<?php echo base_url();?>admin_panel/js/ie9/html5shiv.js"></script>
    <script src="<?php echo base_url();?>admin_panel/js/ie9/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery 2.1.1 -->
    <script src="<?php echo base_url();?>admin_panel/js/jquery-2.1.1/jquery-2.1.1.min.js"></script>
    <!-- jQuery UI 1.10.3 -->
    <script src="<?php echo base_url();?>admin_panel/js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url();?>admin_panel/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- Morris.js charts -->
    <script src="<?php echo base_url();?>admin_panel/js/raphael-2.1.0/raphael-min.js"></script>
    <script src="<?php echo base_url();?>admin_panel/js/plugins/morris/morris.min.js" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="<?php echo base_url();?>admin_panel/js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="<?php echo base_url();?>admin_panel/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>admin_panel/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- fullCalendar -->
    <script src="<?php echo base_url();?>admin_panel/js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo base_url();?>admin_panel/js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
    <!-- daterangepicker -->
    <script src="<?php echo base_url();?>admin_panel/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="<?php echo base_url();?>admin_panel/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url();?>admin_panel/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

    <!-- bootstrap time picker -->
    <script src="<?php echo base_url();?>admin_panel/js/plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script>

    <!-- jqplot chart -->
    <script src="<?php echo base_url();?>admin_panel/jqplot/jquery.jqplot.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>admin_panel/jqplot/plugins/jqplot.barRenderer.min.js"></script>
    <script src="<?php echo base_url();?>admin_panel/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
    <script src="<?php echo base_url();?>admin_panel/jqplot/plugins/jqplot.pointLabels.min.js"></script>

    <!-- AdminLTE App -->
    <!--
    <script src="<?php echo base_url();?>admin_panel/js/AdminLTE/app.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>admin_panel/js/image-preview/image-preview.js"></script>
    <script src="<?php echo base_url();?>admin_panel/js/main.js"></script>
-->
    <style>
        html, body {
            background: -webkit-linear-gradient(#0066d0, #dceaf5) repeat center center fixed;
            background: -o-linear-gradient(#0066d0, #dceaf5) repeat center center fixed;
            background: -moz-linear-gradient(#0066d0, #dceaf5) repeat center center fixed;
            background: linear-gradient(#0066d0, #dceaf5) repeat center center fixed;

            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;

            height: 100%;
        }

        .big_title {
            color: #fff;
            text-shadow: 1px 3px 5px rgba(0, 0, 0, 0.5);
            font-weight: 600;
            -webkit-font-smoothing: antialiased !important;
            opacity: 0.8;
            margin: 10px 0 0px 0;
            font-size: 60px;
            line-height: 60px;

            text-align: center;
        }

        .small_title {
            color: #fff;
            text-shadow: 1px 3px 5px rgba(0, 0, 0, 0.5);
            font-weight: 600;
            -webkit-font-smoothing: antialiased !important;
            opacity: 0.8;
            margin: 0px 0 0px 0;
            font-size: 30px;

            text-align: center;
        }

        .chart {
            height: 400px;
        }

        .foot {
            width: 100%;
        }

        .demo_version {

            color: #000;
            font-weight: 600;
            -webkit-font-smoothing: antialiased !important;
            opacity: 0.9;
            margin: 10px 0 0px 0;
            font-size: 50px;
            line-height: 50px;

            text-align: center;
        }

        .footnote_title {

            color: #999;
            font-weight: 600;
            -webkit-font-smoothing: antialiased !important;
            opacity: 0.8;
            margin: 0px 0 0px 0;
            font-size: 18px;

            text-align: center;
        }

        .jqplot-axis {
            font-size: 20px;
            color: #fff;
        }

        .jqplot-point-label {
            font-size: 20px;
        }
    </style>
</head>

<body>

    <div class="big_title" id="big_title">
        <?php echo $voting_config['big_title']; ?>
    </div>

    <div class="small_title" id="small_title">
        <?php echo $voting_config['small_title']; ?>
    </div>

    <div id="chart"></div>

    <div class="demo_version" id="demo_version">
        <?php if ($voting_config['demo_version']) echo "DEMO VERSION"; ?>
    </div>

    <div class="foot">
        <div class="footnote_title" id="footnote_title">
            <?php if ($voting_config['show_footnote']) echo $voting_config['footnote_title']; ?>
        </div>
    </div>

    <script>
        var plot;
        var chart_data = [];
        var options = {
            seriesDefaults: {
                renderer:$.jqplot.BarRenderer,
                // Show point labels to the right ('e'ast) of each bar.
                // edgeTolerance of -15 allows labels flow outside the grid
                // up to 15 pixels.  If they flow out more than that, they
                // will be hidden.
                pointLabels: { show: true, location: 'e', edgeTolerance: -15 },
                // Rotate the bar shadow as if bar is lit from top right.
                shadowAngle: 135,
                // Here's where we tell the chart it is oriented horizontally.
                rendererOptions: {
                    barDirection: 'horizontal'
                }
            },
            axes: {
                yaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer
                },
                xaxis: {
                    tickOptions: {
                        formatString: '%d'
                    },
                    numberTicks: 10
                }
            }
        };

        function do_update() {
            $.ajax({
                async: false,
                url: "<?php echo site_url('site/get_chart_data') ?>",
                dataType:"json",
                success: function(json) {
                    chart_data = json;

                    render_graph();
                    setTimeout(do_update, 5000)
                }
            });
        }

        function render_graph() {
            if (plot)
            {
                plot.destroy();
            }

            plot.series[0].data = chart_data;
            plot = $.jqplot ('chart', [chart_data],options);
        }

        $(document).ready(function() {
            reposition();

            chart_data.push([0, '']);

            plot = $.jqplot ('chart', [chart_data], options);
            do_update();
        });

        $( window ).resize(function() {
            reposition();
        });

        function reposition()
        {
            var min_height = 300;
            var cal_height = $(window).height() - 300;

            if (cal_height > min_height)
                min_height = cal_height;

            $("#chart").css('height', min_height);
        }


    </script>

</body>
</html>