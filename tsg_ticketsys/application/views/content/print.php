<script type="text/javascript">
    $(function () {
        var brgy = $('#brgy');
        var brgy_dist = $('#brgy_dist');
        var report_status = $('#report_status');
        var datefrm = $('#datefrm');
        var dateto = $('#dateto');
        var d = new Date();
        var strDate = (d.getMonth() + 1) + "/01/" + d.getFullYear();
        var endDate = (d.getMonth() + 1) + "/" + d.getDate() + "/" + d.getFullYear();
        
        datefrm.val(strDate);
        dateto.val(endDate);
        
        $('#form1').on('submit', function (e) {
            e.preventDefault();
            var brgy_len = brgy.val().length;
            var brgy_dist_len = brgy_dist.val().length;
            var rep_stat_len = report_status.val().length;
            var date_from_len = datefrm.val().length;
            var date_to_len = dateto.val().length;

            if (date_from_len > 0 && date_to_len > 0)
            {
                this.submit();
            } else {
                alert("Please provide a filter for your report.");
            }

        });
    });
</script>



<div class="container-fluid well">

    <h1 class="text-center page-header" style="font-size:150%;">SUMMARY REPORT <?php
        if (isset($report_frm) && isset($report_to)) {
            echo date_format(date_create($report_frm), 'm/d/Y') . " - " . date_format(date_create($report_to), 'm/d/Y');
        }
        ?></h1>
    <!--    <div class="text-right">
            <a class="btn btn-default btn-link" href='home'>
                << RETURN TO MENU
            </a>
        </div>-->
    <?php if (isset($errorMsg)) echo $errorMsg; ?>
    <div class="row">
        <form id="form1" method="post" action="printReport">
            <div class="row hidden-print">
                <div class="col-md-2">
                    <label for="datefrm">Date from:</label>
                    <input id="datefrm" type="text" name="report[datefrm]" class="form-control input-lg dr">
                </div>
                <div class="col-md-2">
                    <label for="dateto">Date to:</label>
                    <input id="dateto" type="text" name="report[dateto]" class="form-control input-lg dr">
                </div>

                <div class="col-md-3">
                    <label for="brgy">Barangay:</label>
                    <select id="brgy" class="form-control input-lg" id="brgy" name="report[brgy]">
                        <option value="">--Select here--</option>
                        <?php
                        foreach ($barangays as $row) {

                            echo "<option value='$row->Name'>$row->Name</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="brgy_dist">Brgy. District:</label>
                    <select id="brgy_dist" name="report[brgy_dist]" class="form-control input-lg">
                        <option value="">--Select here--</option>
                        <option value="NORTH">NORTH</option>
                        <option value="SOUTH">SOUTH</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="report_status">Status:</label>
                    <select id="report_status" name="report[status]" class="form-control input-lg">
                        <option value="">--Select here--</option>
                        <option value="PENDING">PENDING</option>
                        <option value="RELEASED">RELEASED</option>
                    </select>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <?php
                    if (isset($report_res)) {
                        ?>
                        <div class="table-responsive" style="background-color: #fff;">
                            <table class="table table-bordered table-condensed" style="font-size:70%;">
                                <thead>
                                <th>CLAIMANT</th>
                                <th>DECEASED</th>
                                <th>BARANGAY</th>
                                <th>DISTRICT</th>
                                <th>STATUS</th>
                                <th>REL_DATE</th>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($report_res as $row) {
                                        $claimant = $row->CLAIMANT_LNAME . ", " . $row->CLAIMANT_FNAME;
                                        $deceased = $row->DECEASED_LNAME . ", " . $row->DECEASED_FNAME;
                                        $brgy = $row->CLAIMANT_BRGY;
                                        $dist = $row->District;
                                        $status = $row->STATUS;
                                        $rel = $row->RELEASED_DATE;
                                        
                                        if($rel != null){
                                            $rel = date_format(date_create($rel), 'm/d/Y');
                                        } else {
                                            $rel = "--";
                                        }
                                        
                                        echo "<tr>";
                                        echo "<td>" . $claimant . "</td>";
                                        echo "<td>" . $deceased . "</td>";
                                        echo "<td>" . $brgy . "</td>";
                                        echo "<td>" . $dist . "</td>";
                                        echo "<td>" . $status . "</td>";
                                        echo "<td>" . $rel . "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>



                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="row hidden-print">
                <div class="col-md-12">
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-lg">Generate</button>
                        <a id="print-btn" href="javascript:window.print();" class="btn btn-default btn-lg">
                            <span class="glyphicon glyphicon-print"></span> PRINT
                        </a>
                        <a href="./" class="btn btn-link btn-lg">Back</a>
                    </div>
                </div>
            </div>


        </form>


    </div>