<!DOCTYPE html>
<html lang="en">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <head>
        <title><?php echo $title_for_layout; ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
        <script type="text/javascript" src='<?php echo base_url('assets/javascripts/jquery.min.js'); ?>'></script>
        <script type="text/javascript">
            //<![CDATA[
            $(window).on('load', function () {
                // make sure the wholse site is loaded
                $('#status').fadeOut(); // will first fade out the loading animation
                $('#preloader').delay(350).fadeOut('slow');
                // will fade out the white DIV that covers the website.
                $('body').delay(350).css({'overflow': 'visible'});
            });
            //]]>
        </script>
        <style type="text/css">
            body{
                overflow: hidden;
            }
            /* Preloader */
            #preloader{
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 999;
            }
            #status{
                width: 200px;
                height: 200px;
                position: absolute;
                left: 50%;
                top: 50%;
                background-image: url("<?php echo base_url('assets/img/status.gif'); ?>");
                background-repeat: no-repeat;
                background-position: center;
                margin: -100px 0 0 -100px;
            }
            #home_header{
                /*background-image: url("<?php echo base_url('assets/img/header.svg'); ?>");*/
                /*background-repeat: no-repeat;*/
                /*background-position: center;*/
            }
        </style>
    </head>
    <body>
        <div id="preloader">
            <div id="status">&nbsp;</div>
        </div>
        <div class="container-fluid">
            <?php echo $content_for_layout; ?>
        </div>
        <script type="text/javascript" src='<?php echo base_url('assets/javascripts/bootstrap.min.js'); ?>'></script>
    </body>
</html>
