<!DOCTYPE html>
<html lang="en">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <head>
        <title><?php echo $title_for_layout; ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
        <script type="text/javascript" src='<?php echo base_url('assets/javascripts/jquery.min.js'); ?>'></script>
        <script type="text/javascript" src="<?php echo base_url('assets/javascripts/datatables.min.js'); ?>"></script>
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
                /*height: 30%;*/
                /*width: 50%;*/
            }
            
            
        </style>
    </head>
    <body>
        <div id="preloader">
            <div id="status">&nbsp;</div>
        </div>
        <?php

        function pageIsSelected($code, $selected_page) {
            $isActive = "";
            if ($code == $selected_page) { 
                $isActive = "active";
            }
            return $isActive;
        }
        ?>
        <div class="container-fluid">
            <div class="row">
                <?php echo $logged_user_fname. " ".$logged_user_lname;?>
            </div>
            <div id="home_header" class="page-header text-center text-primary">
                <object data="<?php echo base_url('assets/img/header.svg'); ?>" type="image/svg+xml">
                </object>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <ul class="nav nav-pills nav-stacked well" style="height: 500px;">
                        <li role="presentation" class="<?php echo pageIsSelected(0, $page_no); ?>">
                            <a href="home">
                                <span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home
                            </a>
                        </li>
                        <li role="presentation" class="<?php echo pageIsSelected(1, $page_no); ?>">
                            <a href="#" data-toggle="modal" data-target="#newIncidentModal">
                                <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> New Incident
                            </a>
                        </li>
                        
                        <li role="presentation" class="<?php echo pageIsSelected(3, $page_no); ?>">
                            <a href="reports">
                                <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Reports
                            </a>
                        </li>
                        <?php
                        if (isset($userType) && ($userType == 4)) {
                            ?>
                            <li role="presentation" class="<?php echo pageIsSelected(4, $page_no); ?>">
                                <a href="accounts">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Accounts
                                </a>
                            </li>
                            <li role="presentation" class="<?php echo pageIsSelected(5, $page_no); ?>">
                                <a href="settings">
                                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Settings
                                </a>
                            </li>
                        <?php } ?>
                        <li role="presentation">
                            <a href="logout">
                                <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Logout
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-10 well">
                    <?php if (isset($error_msg)) { ?>
                        <div class="alert <?php echo $alert_type; ?> alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $error_msg; ?>
                        </div>
                    <?php } ?>
                    <?php echo $content_for_layout; ?>
                </div>
            </div>
            <!-- newIncidentModal -->
            <?php
            if (isset($page_no) && $page_no != 4) {
                ?>
                <div class="modal fade" id="newIncidentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="exampleModalLabel">New Incident / Request Ticket</h4>
                            </div>
                            <form method="post" action="SaveNewIncident">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="client-fname" class="control-label">First Name:</label>
                                        <input name="ticket[CLIENT_FNAME]" type="text" class="form-control" id="client-fname" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="client-lname" class="control-label">Last Name:</label>
                                        <input name="ticket[CLIENT_LNAME]" type="text" class="form-control" id="client-lname" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="client-dept" class="control-label">Office:</label>
                                        <select name="ticket[OFFICE_CODE]" class="form-control" id="client-dept" required="">
                                            <?php
                                            if (isset($rsActiveOffices)) {
                                                foreach ($rsActiveOffices as $office) {

                                                    if ($userOfficeId == $office->OfficeCode) {
                                                        echo "<option value='$office->OfficeCode' selected>";
                                                        echo "" . $office->Abreviation . "";
                                                        echo "</option>";
                                                    } 
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="client-div" class="control-label">Division:</label>
                                        <input name="ticket[DIVISION]" type="text" class="form-control" id="client-div" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="client-contact" class="control-label">Contact #:</label>
                                        <input name="ticket[CLIENT_CONTACT]" type="text" class="form-control" id="client-contact" required="" value="<?php echo set_value('ticket[CLIENT_CONTACT]'); ?>">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="client-urgency" class="control-label">Urgency:</label>
                                        <select name="ticket[URGENCY]" class="form-control" id="urgency" required>
                                            <option value="LOW">LOW</option>
                                            <option value="NORMAL" selected="">NORMAL</option>
                                            <option value="HIGH">HIGH</option>
                                        </select>
                                    </div>
                                    
                                    
                                    
                                    <div class="form-group">
                                        <label for="problem" class="control-label">Problem Type:</label>
                                        <select name="ticket[PROBLEM]" class="form-control" id="problem" required="" value="<?php echo set_value('ticket[PROBLEM]'); ?>">
                                            <option value="">--Select here--</option>
                                            <?php
                                            if (isset($rsTechProblems)) {
                                                foreach ($rsTechProblems as $row) {
                                                    echo "<option value='$row->PROB_ID'>$row->PROBLEM_NAME</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="prob_details" class="control-label">Problem Details: (Pls. specify here)</label>
                                        <textarea name="ticket[PROB_DETAILS]" class="form-control" id="prob_details" value="<?php echo set_value('ticket[PROB_DETAILS]'); ?>" required=""></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="req_details" class="control-label">Request Details: (Pls. specify here)</label>
                                        <textarea name="ticket[REQ_DETAILS]" class="form-control" id="req_details" value="<?php echo set_value('ticket[REQ_DETAILS]'); ?>"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">
                                        <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Save
                                    </button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <script type="text/javascript" src='<?php echo base_url('assets/javascripts/bootstrap.min.js'); ?>'></script>
    </body>
</html>
