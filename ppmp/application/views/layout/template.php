<!DOCTYPE html>
<html lang="en">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <head>
        <title><?php echo $title_for_layout; ?></title>
        <link rel="stylesheet" type="text/css"  href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" />
        <link rel="stylesheet" type="text/css"  href="<?php echo base_url('assets/css/home.css'); ?>" />
        <link rel="stylesheet" type="text/css" media="print"  href="<?php echo base_url('assets/css/print.css'); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/daterangepicker.css'); ?>" />
    </head>
    <script type="text/javascript" src="<?php echo base_url('assets/js/moment.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-3.1.0.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script type="text/javascript">
        //<![CDATA[
        $(window).on('load', function () {
            // make sure the wholse site is loaded
            $('#status').fadeOut(); // will first fade out the loading animation
            $('#preloader').delay(350).fadeOut('slow');
            // will fade out the white DIV that covers the website.
            $('body').delay(350).css({'overflow': 'visible'});


            $(".dr").daterangepicker(
                    {
                        singleDatePicker: true,
                        showDropdowns: true,
                        autoUpdateInput: true
                    });
        });
        //]]>


    </script>
    <style type="text/css">
        /* Preloader */
        #preloader{
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #fff;
            z-index: 999;
        }
        #preloader_status{
            width: 200px;
            height: 200px;
            position: absolute;
            left: 50%;
            top: 50%;
            background-image: url("<?php echo base_url('assets/images/ajax-loader.gif'); ?>");
            background-repeat: no-repeat;
            background-position: center;
            margin: -100px 0 0 -100px;
        }
    </style>
    <script type="text/javascript" src="<?php echo base_url('assets/js/home.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/daterangepicker.js'); ?>"></script>

    <body>
        <div>
            <!-- <div id="loading">
                    <img id="loading-image" src="<?//=base_url('assets/images/ajax-loader.gif');?>" alt="Loading..." />
            </div> -->
            <div id="loading">
                <div id="preloader_status">&nbsp;</div>
            </div>

            <div class="container-fluid">
                <?php if (isset($this->session->userdata['ses_ppmp'])) { ?>
                    <div class="hidden-print text-right header">
                        <span id='datetime'></span> |
                        Logged user: <span class="glyphicon glyphicon-user
                                           " aria-hidden="true"></span> <?php echo strtoupper($this->session->userdata['ses_ppmp'][0]->user_name); ?> <a class="label label-default" style='font-size: 10px;' href="logout"><span class="glyphicon glyphicon-log-out"></span> LOGOUT</a></span>
                    </div>
                <?php } else { ?>
                    <p class="hidden-print text-right"><a class="label label-default" style='font-size: 10px;' href="LoginController"><span class="glyphicon glyphicon-log-in"></span> LOGIN</a></span></p>
                <?php } ?>

                <?php echo $content_for_layout; ?>

            </div>
            <!-- end of dynamic content -->
            <br>
            <br>
            <p class="hidden-print footer">Copyright © 2017 Procurement Plan System</p>

        </div>
    </body>
</html>
