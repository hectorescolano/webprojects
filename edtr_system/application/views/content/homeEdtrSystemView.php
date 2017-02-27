
<script type="text/javascript" src="<?php echo base_url('assets/js/edtrsys.js'); ?>"></script>
<div class="container-fluid">
    <h4>Delete Employees from Certification List:</h4>
    <hr>
    <div class="table-responsive">
        <table id="rsTable" class="table-hover">
            <thead>
            <th>ACTIONS</th>
            <th>EMPLOYEE ID</th>
            <th>EMPLOYEE NAME</th>
            <th>DEPTCODE</th>
            </thead>
            <tbody>
                <?php
                if (isset($certification_list) || !empty($certification_list)) {
                    foreach ($certification_list as $row) {
                        $employeeid = trim($row->EMPLOYEEID);
                        $employeename = trim($row->EMPLOYEENAME);
                        $deptcode = trim($row->DEPTCODE);
                        echo "<tr>";
                        echo "<td class='text-center'><a href='#del_$employeeid' class='btn btn-link' data-toggle='modal' data-target='#confirmDelModal'"
                                . " data-employeeid='$employeeid'"
                                . " data-employeename='$employeename'>[Remove]</a></td>";
                        echo "<td>$employeeid</td>";
                        echo "<td>$employeename</td>";
                        echo "<td>$deptcode</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>



<!-- Delete Confirmation Modal -->
<div class="modal fade" id="confirmDelModal" tabindex="-1" role="dialog" aria-labelledby="confirmDelModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-center" id="confirmDelModal" style="color:#fff;">Confirm Delete</h3>
            </div>
            <form method="post" action="confirmDel">
                <div class="modal-body">
                    <div class="container-fluid" style="font-size:85%;">
                        <div class="form-group">
                            <input type="hidden" id="employeeid" name="employeeid">
                            <input type="hidden" id="employeename" name="employeename">
                            <p>Are you sure you want to remove this employee: <span id="employee"></span></p>
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