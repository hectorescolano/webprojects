<script type="text/javascript">
    $(function () {
        $("#claimant_dob").change(getAge);
//        $(".dr").daterangepicker({
//            singleDatePicker: true,
//            showDropdowns: true
//        });

        $('#select_deceased').change(function () {
            if ($(this).val().length > 0) {
                $('#form1').submit();
            } else {
                alert("Please select deceased_name to load data.");
            }

        });




        function getAge() {
//            alert("jquery loaded");
            //extract year
            var extracted_date = $('#claimant_dob').val().split("/");
                        var birth_year = extracted_date[2]; // year of birth
                        var current_date = new Date();
                        var current_year = current_date.getFullYear();
                        var current_age = current_year - birth_year;

                        $('#claimant_age').val(current_age);



        }
    });
</script>
<div class="container-fluid well">
    <h2 class="text-center">SOCIAL CASE SUMMARY REPORT (SCSR)</h2>
    <hr>
    <div class="text-right">
        <a class="btn btn-default btn-link" href='search'>
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span> SEARCH / UPDATE
        </a>
        <a class="btn btn-default btn-link" href='vr'>
            DV / OBR / CERT
        </a>
    </div>
    <?php
    if (isset($errorMsg)) {
        echo $errorMsg;
    }
    ?>

    <form id="form1" method="post" action="scsr_loadclaimant">
        <fieldset>
            <legend class="text-primary"><small>SELECT DECEASED</small></legend>

            <div class="row">
                <div class="form-group col-md-2">
                    <select class="form-control" id="select_deceased" name="select_deceased" autofocus="" required="">
                        <option value="">-- Select here --</option>
                        <?php
                        foreach ($deceaseds as $row) {
                            $deceased_name = $row->DECEASED_FNAME . " " . $row->DECEASED_MNAME . "," . $row->DECEASED_LNAME;
                            $deceased_fname = $row->DECEASED_FNAME;
                            $deceased_mname = $row->DECEASED_MNAME;
                            $deceased_lname = $row->DECEASED_LNAME;
                            $control_no = $row->CONTROL_NO;
//                            if (isset($scsr_selected_deceased_name)) {
//                                
//                                if ($deceased_fname == $scsr_sel_deceased_fname &&
//                                        $deceased_mname == $scsr_sel_deceased_mname &&
//                                        $deceased_lname == scsr_sel_deceased_lname) {
//                                    echo "<option value='$deceased_name' selected>$deceased_name</option>";
//                                } else {
//                                    echo "<option value='$deceased_name'>$deceased_name</option>";
//                                }
//                            } else {
//                                echo "<option value='$deceased_name'>$deceased_name</option>";
//                            }
                            if (isset($current_selected)) {
                                if ($control_no == $current_selected)
                                    echo "<option value='$control_no' selected>$deceased_name</option>";
                                else
                                    echo "<option value='$control_no'>$deceased_name</option>";
                            } else {
                                echo "<option value='$control_no'>$deceased_name</option>";
                            }
                        }
                        ?>					
                    </select>
                </div>
            </div>
        </fieldset>
    </form>
    <br>
    <form method="post" action="savescsr">
        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary btn-lg">Save</button>
            <button type="reset" class="btn btn-default btn-lg">Clear</button>
            <a href="./" class="btn btn-link btn-lg">Back</a>
        </div>
        <fieldset>
            <legend><small>INTERVIEWER NAME:</small></legend>
            <div class="row">
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="scsr_data[interviewer_name]" required="">
                </div>
            </div>
        </fieldset>


        <fieldset>
            <legend class="text-primary"><small>DECEASED INTERVIEW INFORMATION</small></legend>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="scsr_deceased_fname">Name:</label>
                    <input type="text" class="form-control" id="scsr_deceased_fname" name="scsr_data[deceased_fname]" readonly="" required="" value="<?php if (isset($scsr_sel_deceased_fname)) echo $scsr_sel_deceased_fname; ?>">
                </div>
                <div class="form-group col-md-1">
                    <label for="scsr_deceased_mname">Middlename:</label>
                    <input type="text" class="form-control" id="scsr_deceased_mname" name="scsr_data[deceased_mname]" readonly="" required="" value="<?php if (isset($scsr_sel_deceased_mname)) echo $scsr_sel_deceased_mname; ?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="scsr_deceased_lname">Lastname:</label>
                    <input type="text" class="form-control" id="scsr_deceased_lname" name="scsr_data[deceased_lname]" readonly="" required="" value="<?php if (isset($scsr_sel_deceased_lname)) echo $scsr_sel_deceased_lname; ?>">
                </div>
                <div class="form-group col-md-2">
                    <label for="deceased_brgy">Barangay:</label>
                    <select class="form-control" id="deceased_brgy" name="scsr_data[deceased_brgy]" required="">
                        <option value="">--Select here--</option>
                        <?php
                        foreach ($barangays as $row) {

                            echo "<option value='$row->Name'>$row->Name</option>";
                        }
                        ?>					
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="deceased_street_add">Street Address:</label>
                    <input type="text" class="form-control" id="deceased_street_add" name="scsr_data[deceased_street_add]">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="scsr_deceased_cs">Civil Status:</label>
                    <select class="form-control" id="scsr_deceased_cs" name="scsr_data[deceased_cs]">
                        <option value="SINGLE">SINGLE</option>
                        <option value="MARRIED">MARRIED</option>
                        <option value="WIDOWED">WIDOWED</option>
                        <option value="SEPARATED">SEPARATED</option>
                    </select>
                </div>
                <div class="form-group col-md-5">
                    <label for="deceased_spouse_fname">Name of Spouse: (if married):</label>
                    <input type="text" class="form-control" id="deceased_spouse_fname" name="scsr_data[deceased_spouse_fname]" placeholder="Firstname">
                </div>
                <div class="form-group col-md-5">
                    <label for="deceased_spouse_lname">&nbsp;</label>
                    <input type="text" class="form-control" id="deceased_spouse_lname" name="scsr_data[deceased_spouse_lname]"
                           placeholder="Lastname">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="scsr_deceased_dob">Date of Birth:</label>
                    <input type="text" class="form-control dr" id="scsr_deceased_dob" name="scsr_data[deceased_dob]" required="">
                </div>
                <div class="form-group col-md-4">
                    <label for="scsr_deceased_pob">Place of Birth:</label>
                    <input type="text" class="form-control" id="scsr_deceased_pob" name="scsr_data[deceased_pob]" required="">
                </div>
                <div class="form-group col-md-2">
                    <label for="scsr_deceased_dod">Date of Death:</label>
                    <input type="text" class="form-control dr" id="scsr_deceased_dod" name="scsr_data[deceased_dod]" required="">
                </div>
                <div class="form-group col-md-4">
                    <label for="scsr_deceased_pod">Place of Death:</label>
                    <!--<input type="text" class="form-control" id="scsr_deceased_pod" name="scsr_data[deceased_pod]" required="">-->
                    <select class="form-control" id="scsr_deceased_pod" name="scsr_data[deceased_pod]" required="">
                        <option value="HOSPITAL">HOSPITAL</option>
                        <option value="RESIDENCE">RESIDENCE</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="scsr_deceased_cod">Cause of Death:</label>
                    <input type="text" class="form-control" id="scsr_deceased_cod" name="scsr_data[deceased_cod]" required="">
                </div>
                <div class="form-group col-md-3">
                    <label for="">Lingering Ailment:</label>
                    <div class="radio">
                        <label for="deceased_la_yes"><input type="radio" id="deceased_la_yes" name="scsr_data[deceased_la]" value="YES">Yes</label>
                        <label for="deceased_la_no"><input type="radio" id="deceased_la_no" name="scsr_data[deceased_la]" value="NO">No</label>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="">Hospitalization:</label>
                    <div class="radio">
                        <label for="deceased_hos_yes"><input type="radio" id="deceased_hos_yes" name="scsr_data[deceased_hos]" value="YES">Yes</label>
                        <label for="deceased_hos_no"><input type="radio" id="deceased_hos_no" name="scsr_data[deceased_hos]" value="NO">No</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="scsr_deceased_paid_hos">Who paid hospital bills?</label>
<!--					<input type="text" class="form-control" id="scsr_deceased_paid_hos" name="scsr_data[deceased_paid_hos]">-->
                    <select class="form-control" id="scsr_deceased_paid_hos" name="scsr_data[deceased_paid_hos]">
                        <option value="FAMILY">FAMILY</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="scsr_deceased_paid_burial_exp">Who paid the burial expenses?</label>
                    <input type="text" class="form-control" id="scsr_deceased_paid_burial_exp" name="scsr_data[deceased_paid_burial_exp]">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="scsr_children">Children:</label>
                    <table class="table table-bordered table-condensed">
                        <thead>
                        <th>#</th>
                        <th>NAME</th>
                        <th>AGE</th>
                        <th>ADDRESS</th>
                        <th>RELATION</th>
                        <th>LEGITIMATE</th>
                        </thead>
                        <tbody>
                            <?php for ($i = 0; $i < 10; $i++) { ?>
                                <tr>
                                    <td><?php echo $i + 1; ?></td>
                                    <td><input type="text" class="form-control" name="scsr_deceased_children[<?php echo $i; ?>][name]"></td>
                                    <td><input type="text" class="form-control" name="scsr_deceased_children[<?php echo $i; ?>][age]"></td>
                                    <td><input type="text" class="form-control" name="scsr_deceased_children[<?php echo $i; ?>][address]"></td>
                                    <td><input type="text" class="form-control" name="scsr_deceased_children[<?php echo $i; ?>][rel]"></td>
                                    <td><select class="form-control" name="scsr_deceased_children[<?php echo $i; ?>][legit]"><option value="">--Select--</option><option value="YES">YES</option><option value="NO">NO</option></select></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </fieldset>

        <br>

        <fieldset>
            <legend class="text-primary"><small>CLAIMANT</small></legend>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="claimant_fname">Name:</label>
                    <!--<input type="text" class="form-control" id="scsr_claimant" name="scsr_data[claimant_name]" readonly="" required="" value="<?php if (isset($scsr_selected_claimant_name)) echo $scsr_selected_claimant_name; ?>">-->
                    <input type="text" class="form-control" id="claimant_fname" name="scsr_data[claimant_fname]" readonly="" required="" value="<?php if (isset($scsr_sel_claimant_fname)) echo $scsr_sel_claimant_fname; ?>">
                </div>
                <div class="form-group col-md-1">
                    <label for="claimant_mname">Middlename:</label>
                    <input type="text" class="form-control" id="claimant_mname" name="scsr_data[claimant_mname]" readonly="" required="" value="<?php if (isset($scsr_sel_claimant_mname)) echo $scsr_sel_claimant_mname; ?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="claimant_lname">Lastname:</label>
                    <input type="text" class="form-control" id="claimant_lname" name="scsr_data[claimant_lname]" readonly="" required="" value="<?php if (isset($scsr_sel_claimant_lname)) echo $scsr_sel_claimant_lname; ?>">
                </div>
                <div class="form-group col-md-2">
                    <label for="claimant_brgy">Barangay:</label>
                    <select class="form-control" id="claimant_brgy" name="scsr_data[claimant_brgy]" required="">
                        <option value="">--Select here--</option>
                        <?php
                        foreach ($barangays as $row) {

                            echo "<option value='$row->Name'>$row->Name</option>";
                        }
                        ?>					
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="claimant_street_add">Street Address:</label>
                    <input type="text" class="form-control" id="claimant_street_add" name="scsr_data[claimant_street_add]">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-1">
                    <label for="claimant_age">Age:</label>
                    <input type="text" class="form-control" id="claimant_age" name="scsr_data[claimant_age]" required="" readonly="">
                </div>
                <div class="form-group col-md-2">
                    <label for="claimant_dob">Date of Birth:</label>
                    <input type="text" class="form-control dr" id="claimant_dob" name="scsr_data[claimant_dob]" required="">
                </div>
                <div class="form-group col-md-3">
                    <label for="claimant_pob">Place of Birth:</label>
                    <input type="text" class="form-control" id="claimant_pob" name="scsr_data[claimant_pob]" required="">
                </div>
                <div class="form-group col-md-2">
                    <label for="claimant_cs">Civi Status:</label>
                    <select class="form-control" id="claimant_cs" name="scsr_data[claimant_cs]">
                        <option value="SINGLE">SINGLE</option>
                        <option value="MARRIED">MARRIED</option>
                        <option value="WIDOWED">WIDOWED</option>
                        <option value="SEPARATED">SEPARATED</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="claimant_contact_no">Contact No:</label>
                    <input type="text" class="form-control" id="claimant_contact_no" name="scsr_data[claimant_contact_no]" required="" maxlength="50">
                </div>
                <div class="form-group col-md-2">
                    <label for="claimant_rel">Relation to Deceased:</label>
                    <input type="text" class="form-control" id="claimant_rel" name="scsr_data[claimant_rel]" required="">
                </div>
            </div>

            <br>


            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary btn-lg">Save</button>
                <button type="reset" class="btn btn-default btn-lg">Clear</button>
                <a href="./" class="btn btn-link btn-lg">Back</a>
            </div>
        </fieldset>

    </form>
</div>
