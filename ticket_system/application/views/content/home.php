<script type="text/javascript" src="<?php echo base_url('assets/javascripts/home.js'); ?>"></script>
<div class="table-responsive bg-success" style="font-size: 80%;overflow-y: auto;height: 460px;border: 1px solid #ddd;">
    <table class="table table-hover table-bordered" id="tbTickets">
        <thead>
        <th>ID</th>
        <th>STATUS</th>
        <th>OFFICE</th>
        <th>PROBLEM</th>
        <th>REQUEST</th>
        <th>AGE (days)</th>
        <th>CREATED</th>
        <th>MODIFIED</th>
        </thead>
        <tbody>
            <?php
             $modified = "";
            foreach ($rsUserTicketBucketList as $row) {
                echo "<tr>";
                  echo "<td>" . $row->TKT_NO . "</td>";
                    echo "<td>" . $row->STATUS . "</td>";
                    echo "<td>" . $row->Abreviation . "</td>";
                    echo "<td>" . $row->PROBLEM_NAME . "</td>";
                    echo "<td>" . $row->REQ_DETAILS . "</td>";
                    echo "<td></td>";
                    echo "<td>" . date_format(date_create($row->CREATED), 'm/d/Y h:i A') . "</td>";
                    echo "<td>" . $modified . "</td>";
               echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <table class="table table-hover table-bordered">
        <thead>
            <?php if ($userType == 4 || $userType == 3) { ?>
            <th>OPTIONS</th>
        <?php } ?>
        <th>ID</th>
        <th>STATUS</th>
        <th>OFFICE</th>
        <th>PROBLEM</th>
        <th>REQUEST</th>
        <th>AGE (days)</th>
        <th>CREATED</th>
        <th>MODIFIED</th>
        </thead>
        <tbody>
            <?php
            $modified = "";
            if (isset($rsUserTicketBucketList)) {

                foreach ($rsUserTicketBucketList as $row) {

                    $tkt_date_created = new DateTime($row->CREATED);
                    $current_date = new DateTime(date("Y-m-d"));
                    $age = $tkt_date_created->diff($current_date);
                    $age = $age->format('%R%a days');
                    if (isset($row->MODIFIED)) {
                        $modified = date_format(date_create($row->MODIFIED), 'm/d/Y h:i A');
                    }

                    echo "<tr>";
                    if ($userType == 4 || $userType == 3) {
                        $data_workhist = array();
                        $data_workhist['workhist'] = $this->DatabaseModel->getWorkUpdateHistory($row->TKT_NO);

                        echo "<td><a class='btn-success btn-sm' href='#" . $row->TKT_NO . "'data-toggle='modal' data-target='#vwTicketModal'"
                        . " data-id='" . $row->TKT_NO . "'"
                        . " data-status='" . $row->STATUS . "'"
                        . " data-abbrev='" . $row->Abreviation . "'"
                        . " data-probname='" . $row->PROBLEM_NAME . "'"
                        . " data-reqdetls='" . $row->REQ_DETAILS . "'"
                        . " data-office='" . $row->OFFICE_CODE . "'"
                        . " data-division='" . $row->DIVISION . "'"
                        . " data-problem='" . $row->PROBLEM . "' "
                        . " data-request='" . $row->REQ_DETAILS . "'";
                        echo " data-workhist='";
                        foreach ($data_workhist['workhist'] as $value) {
                            echo $value->RECORD_NO . "," . $value->TKT_NO . "," . $value->TECH_ID . "," . $value->UPDATE_DESCRIPTION . "," . date_format(date_create($value->CREATED), 'm/d/Y h:i A') . "," . $value->CREATED_BY . ",";
                        }
                        echo "'>Edit</a></td>";
                    }


                    echo "<td>" . $row->TKT_NO . "</td>";
                    echo "<td>" . $row->STATUS . "</td>";
                    echo "<td>" . $row->Abreviation . "</td>";
                    echo "<td>" . $row->PROBLEM_NAME . "</td>";
                    echo "<td>" . $row->REQ_DETAILS . "</td>";
                    echo "<td>" . $age . "</td>";
                    echo "<td>" . date_format(date_create($row->CREATED), 'm/d/Y h:i A') . "</td>";
                    echo "<td>" . $modified . "</td>";
                    echo "<tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Good job! ,you dont have tickets at the moment.</td></tr>";
            }
            ?>
        </tbody>
    </table>



    <?php
    if (isset($page_no) && $page_no == 0) {
        ?>
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
                            <li role="presentation"><a href="#work_update" aria-controls="work_update" role="tab" data-toggle="tab">WORK UPDATE</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="tkt_details">
                                <br>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="tkt_id">Ticket ID:</label>
                                            <input type="text" id="tkt_id" class="form-control" readonly="">
                                        </div>
                                        <div class="form-group">
                                            <label for="tkt_status">Ticket Status:</label>
                                            <select class="form-control" name="" id="tkt_status">
                                                <option value="">--</option>
                                                <option value="NEW">NEW</option>
                                                <option value="PENDING">PENDING</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tkt_office">Office:</label>
                                            <input type="text" id="tkt_office" class="form-control" readonly="">
                                        </div>
                                        <div class="form-group">
                                            <label for="tkt_division">Division:</label>
                                            <input type="text" id="tkt_division" class="form-control" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <label for="tkt_client">Customer:</label>
                                            <input class="form-control" type="text" name="" id="tkt_client" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="tkt_problem">Problem:</label>
                                            <input class="form-control" type="text" name="" id="tkt_problem" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="tkt_request">Request:</label>
                                            <input class="form-control" type="text" name="" id="tkt_request" readonly>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
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
                                                            echo "<option value='$tech->user_id'>" . strtoupper($tech->user_lname) . " ," . strtoupper($tech->user_fname) . "</option>";
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
                                                <button type="submit" class="btn btn-primary">Update</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="table-responsive bg-warning" style="overflow-y: auto;height: 300px;border: 1px solid #ddd;">
                                            <table class="table table-bordered table-condensed">
                                                <thead>
                                                <th>RECORD_NO</th>
                                                <th>TKT_NO</th>
                                                <th>TECH_ID</th>
                                                <th>UPDATE</th>
                                                <th>CREATED</th>
                                                <th>CREATED BY</th>
                                                </thead>
                                                <tbody id="wk-up-hist">

                                                </tbody>
                                            </table>
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
<?php } ?>








</div>