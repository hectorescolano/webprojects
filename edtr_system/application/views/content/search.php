<script type="text/javascript" src="<?= base_url('assets/js/search.js'); ?>"></script>
<div class="container-fluid well">
    <div class="text-center text-primary"><h5>SEARCH TRANSACTIONS</h5></div>
    <div class="text-right">
        <a class="btn btn-default btn-link" href='print'>
            <span class="glyphicon glyphicon-print" aria-hidden="true"></span> PRINT REPORTS
        </a>
    </div>
    <div class="row">
        <form method="post" action="findapp">
            <div class="form-group">
                <div class="col-md-6">
                    <label class="sr-only" for="name">Name:</label> <input id="name" type="text" name="searchname" class="form-control input-sm" placeholder="Enter claimant's / deceased name" autofocus required>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary btn-sm">FIND</button>
                    <a href="search" class="btn btn-default btn-sm">REFRESH</a>
                    <a href="./" class="btn btn-default btn-sm">BACK TO MENU</a>
                </div>

            </div>
        </form>
    </div>
    <div class="row">
        <?= $errorMsg; ?>
    </div>
    <br>
    <br>
    <div class="table-responsive" style="border:1px solid #ccc; font-size: 95%;overflow-y: auto;max-height: 600px;">
        <table class="table bg-warning">
            <thead>
                <tr style="color:#fff;background-color: rgb(40,100,200);">
                    <th width="5%">ACTION</th>
                    <th>SCR ID</th>
                    <th>VOC ID</th>
                    <th>DECEASED</th>
                    <th>CLAIMANT</th>
                    <th>LAST UPDATE</th>
                    <th>RELEASE STATUS</th>
                    <th>RELEASE DATE</th>
                    <!--<th>REMARKS</th>-->
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($results) && count($results) > 0) {
                    foreach ($results as $row) {
                        echo "<tr class=''>";
                        echo "<td class=''>
                                <a class='label label-primary' href='#" . $row->CONTROL_NO . "' 
                                data-toggle='modal' data-target='#myModal' 
                                data-id='" . $row->CONTROL_NO . "' 
                                data-remarks='" . $row->REMARKS . "'
                                data-scr_id = '".$row->SCR_ID."'
                                data-voc_id = '".$row->VOC_ID."'
                                data-deceasedfname='" . $row->DECEASED_FNAME . "'
                                data-deceasedmname='" . $row->DECEASED_MNAME . "'
                                data-deceasedlname='" . $row->DECEASED_LNAME . "' 
                                data-claimantfname='" . $row->CLAIMANT_FNAME . "'
                                data-claimantmname='" . $row->CLAIMANT_MNAME . "'    
                                data-claimantlname='" . $row->CLAIMANT_LNAME . "'
                                >EDIT</a>
                        </td>";

                        echo "<td><a class='btn-link' href='print_scr/$row->SCR_ID'>$row->SCR_ID</a></td>";
                        echo "<td><a class='btn-link' href='print_vor/$row->VOC_ID'>$row->VOC_ID</a></td>";
                        echo "<td>" . $row->DECEASED_FNAME . " " . substr($row->DECEASED_MNAME, 0, 1) . ". " . $row->DECEASED_LNAME . "</td>";
                        echo "<td>" . $row->CLAIMANT_FNAME . " " . substr($row->CLAIMANT_MNAME, 0, 1) . ". " . $row->CLAIMANT_LNAME . "</td>";
                        echo "<td>" . date_format(date_create($row->MODIFIED), 'm/d/Y h:i A') . "</td>";
                        echo "<td>" . $row->STATUS . "</td>";
//                        echo "<td>" . $row->REMARKS . "</td>";
                        if ($row->RELEASED_DATE != null)
                            echo "<td>" . date_format(date_create($row->RELEASED_DATE), 'm/d/Y') . "</td>";
                        else
                            echo "<td>---</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr class='warning'><td colspan='8'>No records found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-center" id="myModalLabel" style="color:#fff;">Update Status</h3>
            </div>
            <!-- form update -->
            <form id="updateForm" method="post" action="updateapp">
                
                <input id="scr_id" name="update[SCR_ID]" type="hidden">
                <input id="voc_id" name="update[VOC_ID]" type="hidden">
                
                <!-- modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="appid">Record #:</label><input type="text" name="update[ID]" id="appid" class="form-control" readonly>
                    </div>
                    <fieldset>
                        <div class="form-group">
                            <label for="deceased">Deceased Fname:</label><input type="text" name="update[DECEASED_FNAME]" id="deceasedfname" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label for="deceased">Deceased Mname:</label><input type="text" name="update[DECEASED_MNAME]" id="deceasedmname" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label for="deceased">Deceased Lname:</label><input type="text" name="update[DECEASED_LNAME]" id="deceasedlname" class="form-control" required="">
                        </div>
                    </fieldset>
                    <br>
                    <fieldset>
                        <div class="form-group">
                            <label for="deceased">Claimant Fname:</label><input type="text" name="update[CLAIMANT_FNAME]" id="claimantfname" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label for="deceased">Claimant Mname:</label><input type="text" name="update[CLAIMANT_MNAME]" id="claimantmname" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label for="deceased">Claimant Lname:</label><input type="text" name="update[CLAIMANT_LNAME]" id="claimantlname" class="form-control" required="">
                        </div>
                    </fieldset>
                    <div class="form-group">
                        <label for="released_status">Status:</label>
                        <select id="released_status" name="update[STATUS]" class="form-control">
                            <option value="">--Select here--</option>
                            <option value="PROCESS">PROCESS</option>
                            <option value="RELEASED">RELEASED</option>
                            <option value="TRANSMITTAL">TRANSMITTAL</option>
                        </select>    
                    </div>
                    <div class="form-group">
                        <label for="remarks">Remarks:</label><textarea name="update[REMARKS]" id="remarks" class="form-control" required></textarea>
                    </div>
                </div>
                <!-- modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button id="btnUpdate" type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>




































