
<script type="text/javascript" src="<?php echo base_url('assets/js/edtrsys.js'); ?>"></script>
<div class="container-fluid" id="tabs">
    <input type="hidden" value="<?php echo base_url(); ?>" id="burls">
    <?php //var_dump($loggedUserDetails); ?>
    <ul>
        <li><a href="#tabs-1">Home</a></li>
        <?php
        if ($loggedUserDetails['role'] == 1) {
            ?>
            <li><a href="#tabs-2">Request</a></li>
        <?php } ?>
        <?php
        if ($loggedUserDetails['role'] != 1) {
            ?>
            <li><a href="#tabs-3">Ticket Summary Report</a></li>
            <li><a href="#tabs-6">Accomplishment Report</a></li>
        <?php } ?>
        <?php
        if ($loggedUserDetails['role'] == 4) {
            ?>
            <li><a href="#tabs-5">Ticket Details</a></li>

            <li><a href="#tabs-4">Accounts</a></li>
        <?php } ?>

    </ul>
    <div id="tabs-1" class="table-responsive">
        <p><h2>Request Ticket List</h2></p>
        <hr>
        <blockquote>
            <p class='text-info'><strong>List of Active Tickets</strong></p>
        </blockquote>
        <p>
        <table id="rsTable" class="table table-condensed table-hover table-bordered" style='font-size:80%;'>
            <thead>
                <?php // if ($userType == 4 || $userType == 3) { ?>
            <th class="text-center">OPTIONS</th>
            <?php // } ?>
            <th class="text-center">TICKET ID</th>
            <th class="text-center">STATUS</th>
            <th class="text-center">TECHNICIAN ASSIGNED</th>
            <th class="text-center">OFFICE</th>
            <th class="text-center">CLIENT</th>
            </thead>
            <tbody>
                <?php
                $rowColor = '';
                if (!empty($rsUserTicketBucketList)) {
                    foreach ($rsUserTicketBucketList as $row) {

                        switch ($row->STATUS) {
                            case 'NEW': $rowColor = 'warning';
                                break;
                            case 'RESOLVED': $rowColor = 'success';
                                break;
                            case 'ASSIGNED': $rowColor = 'info';
                                break;
                            case 'CLOSED': $rowColor = 'active';
                                break;
                            case 'CANCELED': $rowColor = 'danger';
                                break;
                            default : $rowColor = '';
                                break;
                        }

                        echo "<tr class='$rowColor'>";
                        if ($userType == 4 || $userType == 3 || $userType == 2) {
                            $data_workhist = array();
                            $data_workhist['workhist'] = $this->DatabaseModel->getWorkUpdateHistory($row->TKT_NO);

                            echo "<td class='text-center' width='10%'><a class='' href='#" . $row->TKT_NO . "' data-toggle='modal' data-target='#vwTicketModal'"
                            . " data-id='" . $row->TKT_NO . "' "
                            . " data-techid='" . $row->ASSIGNED_TECH_ID . "'"
                            . " data-status='" . $row->STATUS . "'"
                            . " data-abbrev='" . $row->Abreviation . "'"
                            . " data-probname='" . $row->PROBLEM_NAME . "'"
                            . " data-urgency='" . $row->URGENCY . "'"
                            . " data-reqdetls='" . $row->REQ_DETAILS . "' "
                            . " data-servicedone='" . $row->SERVICE_DONE . "'"
                            . " data-office='" . $row->OFFICE_CODE . "'"
                            . " data-division='" . $row->DIVISION . "'"
                            . " data-problem='" . $row->PROBLEM . "' "
                            . " data-probdetails='" . $row->PROB_DETAILS . "'"
                            . " data-request='" . $row->REQ_DETAILS . "'";
                            echo " data-workhist='";
                            foreach ($data_workhist['workhist'] as $value) {
                                echo $value->RECORD_NO . "," . $value->TKT_NO . "," . $value->TECH_ID . "," . $value->UPDATE_DESCRIPTION . "," . date_format(date_create($value->CREATED), 'm/d/Y h:i A') . "," . $value->CREATED_BY . "," . $value->user_fname;
                            }
                            echo "'><span class='glyphicon glyphicon-edit'></span> Edit</a> ";
                            if ($userType == 4 || $userType == 3) {
                                echo "<a class='' href='#' data-toggle='modal' data-target='#confirmDelModal'"
                                . " data-ticketid='" . $row->TKT_NO . "'>"
                                . "<span class='glyphicon glyphicon-remove'></span> Delete</a></td>";
                            } else {
                                
                            }
                        } else {
                            if ($userType == 1 && $row->STATUS == 'RESOLVED') {
                                echo "<td class='text-center'><a class='' href='#' data-toggle='modal' data-target='#closeTicketModal'"
                                . " data-ticketid='" . $row->TKT_NO . "'>"
                                . "<span class=''></span> [CLOSE TICKET]</a></td>";
                            } else {
                                echo "<td></td>";
                            }
                        }
                        $client = $row->CLIENT_FNAME . " " . $row->CLIENT_LNAME;
                        echo "<td class='text-left'>$row->TKT_NO</td>";
                        echo "<td class='text-center' width='10%'>$row->STATUS</td>";
                        echo "<td class='text-right'>$row->user_fname</td>";
                        echo "<td class='text-right'>$row->Abreviation</td>";
                        echo "<td class='text-right'>" . $client . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
        </p>
    </div>
    <?php
    if ($loggedUserDetails['role'] == 1) {
        ?>
        <div id="tabs-2" class="table-responsive">
            <p><h2>New Request Ticket</h2></p>
            <hr>
            <blockquote>
                <p class='text-danger'><strong>Note: All input fields are required.</strong></p>
            </blockquote>
            <p>
            <div id="regForm">
                <form id='newRequestTicketForm' class="form-horizontal" method="post" action="regTicket">
                    <div class='form-group'>
                        <label for='client_fname' class='col-sm-2 control-label'>Client First name:</label>
                        <div class='col-sm-3'>
                            <input name='new_ticket[CLIENT_FNAME]' type='text' class='form-control' id='client_fname' autofocus="" required="" placeholder="First name">
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='client_mname' class='col-sm-2 control-label'>Client Middle name:</label>
                        <div class='col-sm-3'>
                            <input name='new_ticket[CLIENT_MNAME]' type='text' class='form-control' id='client_mname' placeholder="Middle name">
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='client_lname' class='col-sm-2 control-label'>Client Last name:</label>
                        <div class='col-sm-3'>
                            <input name='new_ticket[CLIENT_LNAME]' type='text' class='form-control' id='client_lname' required="" placeholder="Last name">
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='client_contact' class='col-sm-2 control-label'>Contact number:</label>
                        <div class='col-sm-3'>
                            <input name='new_ticket[CLIENT_CONTACT]' type='text' class='form-control' id='client_contact' required="" placeholder="Landline / Local no. / Mobile no.">
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='client_location' class='col-sm-2 control-label'>Office Location / Area name:</label>
                        <div class='col-sm-3'>
                            <input name='new_ticket[CLIENT_LOCATION]' type='text' class='form-control' id='client_location' required="" placeholder="Location / Area / Place name.">
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='client_office' class='col-sm-2 control-label'>Office / Department:</label>
                        <div class='col-sm-3'>
                            <select name='new_ticket[OFFICE_CODE]' class="form-control" id='client_office' required="">
                                <option value="">Select Office</option>
                                <?php
                                $user_role = $this->session->userdata['ses_ticketsys']['role'];
                                $office_code = $this->session->userdata['ses_ticketsys']['office'];
                                if (isset($rsOffices)) {
                                    if ($user_role == 1) {
                                        foreach ($rsOffices as $office) {
                                            if ($office_code == $office->OfficeCode) {
                                                echo "<option value='$office->OfficeCode' selected>$office->Abreviation</option>";
                                                break;
                                            }
                                        }
                                    } else {
                                        foreach ($rsOffices as $office) {
                                            echo "<option value='$office->OfficeCode'>$office->Abreviation</option>";
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='client_division' class='col-sm-2 control-label'>Division name:</label>
                        <div class='col-sm-3'>
                            <input name='new_ticket[DIVISION]' type='text' class='form-control' id='client_division' required="" placeholder="Division / group name">
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='client_problem' class='col-sm-2 control-label'>Problem Category:</label>
                        <div class='col-sm-3'>
                            <select name='new_ticket[PROBLEM]' class="form-control" id='client_problem' required="">
                                <option value="">Select Category</option>
                                <?php
                                if (isset($rsProblemCats)) {
                                    foreach ($rsProblemCats as $category) {
                                        echo "<option value='$category->PROB_ID'>$category->PROBLEM_NAME</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='client_problem_dtl' class='col-sm-2 control-label'>Problem Details:</label>
                        <div class='col-sm-3'>
                            <textarea name='new_ticket[PROB_DETAILS]' class="form-control" id='client_problem_dtl' required=""></textarea>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='client_request_dtl' class='col-sm-2 control-label'>Request Details:</label>
                        <div class='col-sm-3'>
                            <textarea name='new_ticket[REQ_DETAILS]' class="form-control" id='client_request_dtl' required=""></textarea>
                        </div>
                    </div>
                    <!--                <div class='form-group'>
                                        <label for='client_urgency' class='col-sm-2 control-label'>Urgency:</label>
                                        <div class='col-sm-3'>
                                            <select name='new_ticket[URGENCY]' class="form-control" id='client_urgency' required="">
                                                <option value="">Select Level</option>
                                                <option value="1">HIGH</option>
                                                <option value="2">NORMAL</option>
                                                <option value="3">LOW</option>
                                            </select>
                                        </div>
                                    </div>-->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary btn-lg">Add Request Ticket</button>
                            <button type="reset" class="btn btn-default btn-lg">Clear</button>
                        </div>
                    </div>
                </form>
            </div>
            </p>
        </div>

    <?php } ?>
    <?php
    if ($loggedUserDetails['role'] != 1) {
        ?>

        <!-- REPORTS  -->
        <div id="tabs-3" class="table-responsive" style="font-size: 90%;">
            <p><h2>Ticket Summary Report</h2></p>
            <hr>
            <blockquote>
                <p class='text-danger'><strong>Note: Only Date input fields are required.</strong></p>
            </blockquote>
            <p>
            <div id="reportForm">
                <form id='newReportForm' class="form-inline" method="post" action="newReport">
                    <div class="form-group">
                        <label for="datefrom">Date From:</label>
                        <input name="new_report[DATE_FROM]" type="text" class="form-control dr" id="datefrom" required="">
                    </div>
                    <div class="form-group">
                        <label for="dateto">Date To:</label>
                        <input name="new_report[DATE_TO]" type="text" class="form-control dr" id="dateto" required="">
                    </div>
                    <div class="form-group">
                        <label for="tktstatus">Status:</label>
                        <select name="new_report[TKTSTATUS]" class="form-control" id="tktstatus">
                            <option value="">Select status</option>
                            <option value="NEW">NEW</option>
                            <option value="ASSIGNED">ASSIGNED</option>
                            <option value="RESOLVED">RESOLVED</option>
                            <option value="CLOSED">CLOSED</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tktproblemtype">Problem:</label>
                        <select name='new_report[PROBLEM]' class="form-control" id='tktproblemtype'>
                            <option value="">Select category</option>
                            <?php
                            if (isset($rsProblemCats)) {
                                foreach ($rsProblemCats as $category) {
                                    echo "<option value='$category->PROB_ID'>$category->PROBLEM_NAME</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tkttechnicians">Tech:</label>
                        <select name='new_report[tech]' class="form-control" id="tkttechnicians">
                            <option value="">Select tech</option>
                            <?php
                            if (isset($available_techs)) {
                                foreach ($available_techs as $tech) {
                                    echo "<option value='$tech->user_id'>" . $tech->user_lname . ", " . $tech->user_fname . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <button id="btnViewReport" type="button" class="btn btn-primary">View Report</button>
                    <button type="reset" class="btn btn-default">Clear</button>
                    <!--<button id="btnPrintReport" type="button" class="btn btn-default">Print Report</button>-->
                </form>
            </div>
            <hr>
            <br>
            <div id="report_result">

            </div>
            </p>
        </div>
        <!-- ACCOMPLISHMENT REPORT -->
        <div id="tabs-6" class="table-responsive" style="font-size: 90%;">
            <p><h2>Accomplishment Report</h2></p>
            <hr>
            <blockquote>
                <p class='text-danger'><strong>Note: All input fields are required.</strong></p>
            </blockquote>
            <p>
            <form id='newACReportForm' class="form-inline" method="post">
                <div class="form-group">
                    <label for="ac_datefrom">Date From:</label>
                    <input name="ac_report[DATE_FROM]" type="text" class="form-control dr" id="ac_datefrom" required="">
                </div>
                <div class="form-group">
                    <label for="ac_dateto">Date To:</label>
                    <input name="ac_report[DATE_TO]" type="text" class="form-control dr" id="ac_dateto" required="">
                </div>
                <div class="form-group">
                    <label for="ac_technicians">Tech:</label>
                    <select name='ac_report[tech]' class="form-control" id="ac_technicians" required="">
                        <option value="">Select tech</option>
                        <?php
                        if (isset($available_techs)) {
                            foreach ($available_techs as $tech) {
                                echo "<option value='$tech->user_id'>" . $tech->user_lname . ", " . $tech->user_fname . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <button id="btnViewAcReport" type="button" class="btn btn-primary">View Report</button>
                <button type="reset" class="btn btn-default">Clear</button>
            </form>

            <div id="acrFormResult">

            </div>
        </div>
    <?php } ?>
    <?php
    if ($loggedUserDetails['role'] == 4) {
        ?>
        <div id="tabs-4" class="table-responsive" >
            <p><h2>User Accounts / Create New User</h2></p>
            <hr>
            <blockquote>
                <p class='text-danger'><strong>Note: All input fields are required.</strong></p>
            </blockquote>
            <p>
            <div id="newUserForm">
                <form id='newUserAccountForm' class="form-horizontal" method="post" action="regNewUser">
                    <div class='form-group'>
                        <label for='newuser_fname' class='col-sm-2 control-label'>First name:</label>
                        <div class='col-sm-3'>
                            <input name='new_user[user_fname]' type='text' class='form-control' id='newuser_fname' autofocus="" required="" placeholder="Your first name">
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='newuser_mname' class='col-sm-2 control-label'>Middle name:</label>
                        <div class='col-sm-3'>
                            <input name='new_user[user_mname]' type='text' class='form-control' id='newuser_mname' placeholder="Your middle name">
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='newuser_lname' class='col-sm-2 control-label'>Last name:</label>
                        <div class='col-sm-3'>
                            <input name='new_user[user_lname]' type='text' class='form-control' id='newuser_lname' required="" placeholder="Your last name">
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='newuser_officecode' class='col-sm-2 control-label'>Dept / Office:</label>
                        <div class='col-sm-3'>
                            <select name='new_user[user_office]' class="form-control" id='newuser_officecode' required="">
                                <option value="">Select Office</option>
                                <?php
                                if (isset($rsOffices)) {
                                    foreach ($rsOffices as $office) {
                                        echo "<option value='$office->OfficeCode'>$office->Abreviation</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='newuser_division' class='col-sm-2 control-label'>Division / Group:</label>
                        <div class='col-sm-3'>
                            <input name='new_user[user_division]' type='text' class='form-control' id='newuser_division' required="" placeholder="Your division / group">
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='newuser_contact' class='col-sm-2 control-label'>Contact Number:</label>
                        <div class='col-sm-3'>
                            <input name='new_user[user_contact]' type='text' class='form-control' id='newuser_contact' placeholder="Telephone / local number">
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='newuser_location' class='col-sm-2 control-label'>Office Location:</label>
                        <div class='col-sm-3'>
                            <input name='new_user[user_location]' type='text' class='form-control' id='newuser_location' required="" placeholder="Your office location / building / floor / area">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="newuser_usertype" class='col-sm-2 control-label'>User Role / Type:</label>
                        <div class='col-sm-3'>
                            <select name="new_user[user_type]" class="form-control" id="newuser_usertype" required="">
                                <option value="">Select role</option>
                                <?php
                                if (isset($rsUserTypeRoles)) {
                                    foreach ($rsUserTypeRoles as $role) {
                                        echo "<option value='$role->user_type_id'>$role->user_type_name</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary btn-lg">Register New User</button>
                            <button type="reset" class="btn btn-default btn-lg">Clear</button>
                        </div>
                    </div>

                </form>
            </div>

            <blockquote>
                <p class='text-info'><strong>List of Active Users</strong></p>
            </blockquote>
            <table id="rsUserList" class="table table-condensed table-hover table-striped" style="font-size: 80%">
                <thead>
                <th class="text-center">OPTIONS</th>
                <th class="text-center">USERNAME</th>
                <th class="text-center">FIRST NAME</th>
                <th class="text-center">MIDDLE NAME</th>
                <th class="text-center">LAST NAME</th>
                <th class="text-center">DEPT/OFFICE</th>
                <th class="text-center">DIVISION</th>
                <th class="text-center">USER TYPE</th>
    <!--                <th class='text-center'>LAST ACTION</th>-->
                </thead>
                <tbody>
                    <?php
                    if (isset($rsActiveUsers)) {
//                        var_dump($rsActiveUsers);
                        foreach ($rsActiveUsers as $user) {

                            $role = $user->user_type;

                            switch ($role) {
                                case 1: $role = "OFFICE ADMIN";
                                    break;
                                case 2: $role = "TSG TECHNICIAN";
                                    break;
                                case 3: $role = "TSG COORDINATOR";
                                    break;
                                case 4: $role = "TSG ADMIN";
                                    break;
                                default:break;
                            }

                            echo "<tr>";
                            echo "<td class='text-left'>"
                            . "<a href='#edit' data-toggle='modal' data-target='#userAccountDtlModal' "
                            . "data-user_id='$user->user_id' "
                            . "data-user_fname='$user->user_fname' "
                            . "data-user_mname='$user->user_mname'"
                            . "data-user_lname='$user->user_lname'"
                            . "data-user_username='$user->user_username' "
                            . "data-user_office='$user->user_office' "
                            . "data-user_division='$user->user_division' "
                            . "data-user_contact='$user->user_contact' "
                            . "data-user_location='$user->user_location' "
                            . "data-user_type='$user->user_type'><span class='glyphicon glyphicon-edit'></span> EDIT</a> "
                            . "<a href='#reset' data-toggle='modal' data-target='#resetConfirmModal' data-user_id='$user->user_id'><span class='glyphicon glyphicon-refresh'></span> RESET</a> "
                            . "";
                            echo "<td>$user->user_username</td>";
                            echo "<td>$user->user_fname</td>";
                            echo "<td>$user->user_mname</td>";
                            echo "<td>$user->user_lname</td>";
                            echo "<td class='text-center'>$user->Abreviation</td>";
                            echo "<td class='text-right'>$user->user_division</td>";
                            echo "<td class='text-right'>$role</td>";
//                            echo "<td class='text-right'>$user->last_action</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
            </p>
        </div>


        <!-- TICKET DETAILS -->
        <div id="tabs-5" class="table-responsive">
            <p><h2>Ticket Details</h2></p>
            <hr>
            <div id="ticketDetailsForm" class="form-inline">
                <div class="form-group">
                    <label for="ticket_ids">Ticket ID:</label>
    <!--                    <select class="form-control" id="ticket_details_no">
                        <option value="">Select here</option>
                    <?php
//                        if (isset($ticket_details_list)) {
//                            foreach ($ticket_details_list as $ticket) {
//                                echo "<option value='$ticket->TKT_NO'>$ticket->TKT_NO</option>";
//                            }
//                        }
                    ?>
                    </select>-->
                    <input class="form-control" type="text" id="ticket_details_no" placeholder="Enter ticket id">
                    <div class="form-group">
                        <button id="viewTicketDetailBtn" type="button" class="btn btn-primary">View</button>
                    </div>
                </div>
            </div>
            <div id="ticketDetailsResult">

            </div>
        </div>
    <?php } ?>

</div>

<!-- Close Ticket Modal -->
<div class="modal fade" id="closeTicketModal" tabindex="-1" role="dialog" aria-labelledby="closeTicketModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" style="color:#fff;">Close this ticket</h4>
            </div>
            <form id='closeTicketForm' method="post" action="closeTicket">
                <div class="modal-body">
                    <div class="container-fluid" style="font-size:90%;">
                        <div class="form-group">
                            <input type="hidden" id="close_tktid" name="close_tktid">
                            <p>Are you sure you want to close this ticket?</p>
                        </div>
                        <div class="form-group">
                            <label for='tkt_close_rating'>Service Rating:</label>
                            <select class="form-control" id="tkt_close_rating" name='ticket_close[SERVICE_RATING]' required="">
                                <option value="">Select rating</option>
                                <option value="1">1 - Poor</option>
                                <option value="2">2 - Satisfactory</option>
                                <option value="3">3 - Very Satisfactory</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for='tkt_close_remarks'>Remarks/Comments:</label>
                            <textarea class="form-control" id='tkt_close_remarks' name='ticket_close[ADD_COMMENTS]' required=""></textarea>
                        </div>
                        <div class="modal-footer">
                            <button id="btnUpdate" type="submit" class="btn btn-danger">YES</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reset Password Confirmation Modal -->
<div class="modal fade" id="resetConfirmModal" tabindex="-1" role="dialog" aria-labelledby="resetConfirmModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" style="color:#fff;">Reset Password</h4>
            </div>
            <form method="post" action="confirmResetPass">
                <div class="modal-body">
                    <div class="container-fluid" style="font-size:85%;">
                        <div class="form-group">
                            <input type="hidden" id="reset_confirm_userid" name="reset_confirm_userid">
                            <p>Are you sure you want to reset the password?</p>
                        </div>

                        <div class="modal-footer">
                            <button id="btnUpdate" type="submit" class="btn btn-danger">YES</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- User Account Details Modal -->
<div class="modal fade" id="userAccountDtlModal" tabindex="-1" role="dialog" aria-labelledby="userAccountDtlModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-center" style="color:#fff;">Update User Account Information</h3>
            </div>
            <form id='updateUserAccountForm' class="form-horizontal" method="post" action="updateUserAccountDtl">
                <div class="modal-body">
                    <input type="hidden" id="user_id" name="user_id">
                    <div class="container-fluid" style="font-size:90%;">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class='form-group'>
                                    <label for='update_username' class='col-sm-3 control-label'>Username:</label>
                                    <div class='col-sm-7'>
                                        <input name='update_user[user_username]' type='text' class='form-control' id='update_username' required="" placeholder="Update username">
                                    </div>
                                </div>
                                <div class='form-group'>
                                    <label for='update_userfname' class='col-sm-3 control-label'>First name:</label>
                                    <div class='col-sm-7'>
                                        <input name='update_user[user_fname]' type='text' class='form-control' id='update_userfname' required="" placeholder="Update first name">
                                    </div>
                                </div>
                                <div class='form-group'>
                                    <label for='update_userlname' class='col-sm-3 control-label'>Last name:</label>
                                    <div class='col-sm-7'>
                                        <input name='update_user[user_lname]' type='text' class='form-control' id='update_userlname' required="" placeholder="Update last name">
                                    </div>
                                </div>
                                <div class='form-group'>
                                    <label for='update_userofficecode' class='col-sm-3 control-label'>Office:</label>
                                    <div class='col-sm-7'>
                                        <select name='update_user[user_office]' class="form-control" id='update_userofficecode' required="">
                                            <option value="">Select Office</option>
                                            <?php
                                            if (isset($rsOffices)) {
                                                foreach ($rsOffices as $office) {
                                                    echo "<option value='$office->OfficeCode'>$office->Abreviation</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class='form-group'>
                                    <label for='update_userdivision' class='col-sm-4 control-label'>Division / Group:</label>
                                    <div class='col-sm-7'>
                                        <input name='update_user[user_division]' type='text' class='form-control' id='update_userdivision' required="" placeholder="Update division / group">
                                    </div>
                                </div>
                                <div class='form-group'>
                                    <label for='update_usercontact' class='col-sm-4 control-label'>Contact Number:</label>
                                    <div class='col-sm-7'>
                                        <input name='update_user[user_contact]' type='text' class='form-control' id='update_usercontact' required="" placeholder="Telephone / local number">
                                    </div>
                                </div>
                                <div class='form-group'>
                                    <label for='update_userlocation' class='col-sm-4 control-label'>Office Location:</label>
                                    <div class='col-sm-7'>
                                        <input name='update_user[user_location]' type='text' class='form-control' id='update_userlocation' required="" placeholder="Update office location / building / floor / area">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="update_usertype" class='col-sm-4 control-label'>Role:</label>
                                    <div class='col-sm-7'>
                                        <select name="update_user[user_type]" class="form-control" id="update_usertype" required="">
                                            <option value="">Select role</option>
                                            <?php
                                            if (isset($rsUserTypeRoles)) {
                                                foreach ($rsUserTypeRoles as $role) {
                                                    echo "<option value='$role->user_type_id'>$role->user_type_name</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="btnUpdate" type="submit" class="btn btn-danger">UPDATE</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- TICKET DETAILS MODAL  -->
<div class="modal fade" id="vwTicketModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Update Ticket Incident / Request</h4>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#tkt_details" aria-controls="tkt_details" role="tab" data-toggle="tab">DETAILS</a></li>
                    <?php
                    if ($loggedUserDetails['role'] == 2) {
                        ?>
                        <li role="presentation"><a href="#work_update" aria-controls="work_update" role="tab" data-toggle="tab">WORK UPDATE</a></li>
                    <?php } ?>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tkt_details">
                        <br>
                        <form id='updateTicketForm' method="post" action="updateTicket">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="tkt_id">Ticket ID:</label>
                                        <input name="update_ticket[TKT_ID]" type="text" id="tkt_id" class="form-control" readonly="">
                                    </div>
                                    <div class="form-group">
                                        <label for="tkt_prob_cat">Problem:</label>
                                        <select class="form-control" name="update_ticket[PROBLEM]" id="tkt_prob_cat" required="">
                                            <option value="">Select category</option>
                                            <?php
                                            if (isset($rsProblemCats)) {
                                                foreach ($rsProblemCats as $cat) {
                                                    echo "<option value='$cat->PROB_ID'>$cat->PROBLEM_NAME</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="tkt_urgency">Urgency:</label>
                                        <select class="form-control" name="update_ticket[URGENCY]" id="tkt_urgency" required="">
                                            <option value="">Select level</option>
                                            <?php
                                            if (isset($rsUrgency)) {
                                                foreach ($rsUrgency as $level) {
                                                    echo "<option value='$level->id'>$level->name</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="tkt_prob_dtl">Problem Details:</label>
                                        <textarea name="update_ticket[PROB_DETAILS]" class="form-control" id="tkt_prob_dtl"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="tkt_status">Ticket Status:</label>
                                        <select class="form-control" name="update_ticket[TKT_STATUS]" id="tkt_status" required="">
                                            <option value="">Select status</option>
                                            <?php
                                            if (isset($rsTicketStatus)) {
                                                foreach ($rsTicketStatus as $status) {

//                                                    if ($loggedUserDetails['role'] == 2) {
//                                                        if ($status->name == 'CANCELED' || $status->name == 'RESOLVED' || $status->name == 'ASSIGNED' || $status->name == 'CLOSED') {
//                                                            echo "<option value='$status->name'>$status->description</option>";
//                                                        }
//                                                    }
//
//                                                    if ($loggedUserDetails['role'] == 4) {
//                                                        echo "<option value='$status->name'>$status->description</option>";
//                                                    }
//
//                                                    if($loggedUserDetails['role'] == 3){
//                                                       if ($status->name == 'ASSIGNED' || $status->name == 'CANCELED') {
//                                                            echo "<option value='$status->name'>$status->description</option>";
//                                                       }
//                                                    }
                                                    echo "<option value='$status->name'>$status->description</option>";
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="tkt_client">Office / Department:</label>
                                        <input class="form-control" type="text" name="update_ticket[OFFICE_CODE]" id="tkt_client" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="tkt_division">Division:</label>
                                        <input type="text" id="tkt_division" class="form-control" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="tkt_technician">Technician:</label>
                                        <select name="update_ticket[TECH_ID]" id="tkt_technician" class="form-control" required="" name="work_update[TECH_ID]">
                                            <option value="">Select technician</option>
                                            <?php
                                            if (isset($available_techs)) {
                                                foreach ($available_techs as $tech) {
                                                    echo "<option value='$tech->user_id'>" . strtoupper($tech->user_lname) . ", " . strtoupper($tech->user_fname) . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="tkt_request_dtl">Request Details:</label>
                                        <textarea name="update_ticket[REQ_DETAILS]" class="form-control" id="tkt_request_dtl"></textarea>
                                    </div>

                                    <!--                                    <div class='form-group'>
                                                                            <label for='tkt_urgency' class='col-sm-2 control-label'>Urgency:</label>
                                                                            <select name='update_ticket[URGENCY]' class="form-control" id='tkt_urgency' required="">
                                                                                <option value="">Select Level</option>
                                                                                <option value="1">HIGH</option>
                                                                                <option value="2">NORMAL</option>
                                                                                <option value="3">LOW</option>
                                                                            </select>
                                                                        </div>-->

                                    <div class="form-group" id='tkt_service_done_fg'>
                                        <label for="tkt_service_done">Service Done:</label>
                                        <textarea name="update_ticket[SERVICE_DONE]" class="form-control" id="tkt_service_done"></textarea>
                                    </div>



                                </div>

                            </div>
                            <div class="form-group">
                                <button id='btnUpdateTicket' type="submit" class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="work_update">
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <form id="frmWkUp" name="workupdate_form" method="post" action="submitWorkUp">
                                    <div class="form-group">
                                        <label for="tkt_id">Ticket ID:</label>
                                        <input type="text" id="tkt_id" class="form-control" readonly="" name="work_update[TKT_NO]">
                                    </div>
                                    <div class="form-group">
                                        <label for="tkt_techid">Assign Technician:</label>
                                        <select id="tkt_techid" class="form-control" required="" name="work_update[TECH_ID]">
                                            <option value="">--Select here--</option>
                                            <?php
                                            if (isset($available_techs)) {
                                                foreach ($available_techs as $tech) {
                                                    echo "<option value='$tech->user_id'>" . strtoupper($tech->user_lname) . ", " . strtoupper($tech->user_fname) . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="work_update_desc">Work Update:</label>
                                        <textarea id="work_update_desc" name="work_update[UPDATE_DESCRIPTION]" class="form-control" required=""></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button id="btnUpdateWrkHist" type="button" class="btn btn-primary">Update</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-9">
                                <div id="tbTicketHistory" class="table-responsive" style="overflow-y: auto;height: 300px;">

                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
</div>
