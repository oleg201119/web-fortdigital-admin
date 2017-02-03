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
    <title><?php if ($config_type == 'ticker') echo $ticker_config['page_title']; ?></title>
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
            font-size: 70px;
            line-height: 70px;

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

        .sms_message {

            color: #000;
            text-shadow: 0px 0px 5px rgba(255, 255, 255, 1.0);
            font-weight: 600;
            -webkit-font-smoothing: antialiased !important;
            opacity: 1.0;
            margin: 100px 0 0px 0;
            font-size: 70px;
            line-height: 70px;

            text-align: center;

            word-wrap: break-word;
            margin-bottom: 50px;
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
    </style>
</head>

<body>

    <div class="big_title" id="big_title">
        <?php echo $ticker_config['big_title']; ?>
    </div>

    <div class="small_title" id="small_title">
        <?php echo $ticker_config['small_title']; ?>
    </div>

    <div class="sms_message" id="sms_message">
        <?php echo $message_text; ?>
    </div>

    <div class="foot" id="foot">
        <div class="demo_version" id="demo_version">
            <?php if ($ticker_config['demo_version']) echo "DEMO VERSION"; ?>
        </div>
        <div class="footnote_title" id="footnote_title">
            <?php if ($ticker_config['show_footnote']) echo $ticker_config['footnote_title']; ?>
        </div>
    </div>

    <script language="javascript">

        var refresh_time = <?php echo $ticker_config['rotating_inteval']; ?>;
        var timer_id;

        function do_refresh() {

            $.ajax({
                async: true,
                url: "<?php echo site_url('site/get_ticker_content') ?>",
                dataType: "json",
                type: "POST",
                data: {

                },
                success: function(json) {

                    $('#sms_message').html(json['message_text']);

                    if ($('#foot').position().top < ($(window).height() - 100))
                    {
                        var top = ($(window).height() - 100 - $('#foot').position().top) + 'px';

                        $("#foot").css({ 'margin-top': top });
                    }
                    else if ($('#foot').position().top < ($(window).height() - 100))
                    {
                        $("#foot").css({ 'margin-top': '0px' });
                    }

                },
                error: function(xhr, errStr) {
                //    alert(errStr);
                }
            });
        }

        $(document).ready(function() {
            reposition();

            timer_id = setInterval(function () {
                do_refresh()
            }, refresh_time * 1000);
        });

        $( window ).resize(function() {
            reposition();
        });

        function reposition()
        {
            if ($('#foot').position().top < ($(window).height() - 100) )
            {
                var top = ($(window).height() - 100 - $('#foot').position().top) + 'px';

                $("#foot").css({ 'margin-top': top });
            }
            else if ($('#foot').position().top < ($(window).height() - 100))
            {
                $("#foot").css({ 'margin-top': '0px' });
            }
        }

    </script>
</body>
</html>