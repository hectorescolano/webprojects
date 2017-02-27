<script type="text/javascript">
    $(function(){
        var comboBoxDept = $("#dept");
        var comboBoxOff = $("#off");
        var inputBoxYear = $("#year");

        var inputFundAdmin = $("#fundamdmin");
        var inputFundAdminPos = $("#fa_designation");

        var inputRequestedBy = $("#requestedby");
        var inputRequestedByPos = $("#rb_designation");




        inputBoxYear.keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                 // Allow: Ctrl+A, Command+A
                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
                 // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                     // let it happen, don't do anything
                     return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });


        comboBoxDept.change(function(){
            // alert($(this).val());

            /* Ajax get offices */
            $.ajax({
                type:"post",
                url:"<?php echo base_url();?>" + "/AjaxPostController/user_data_submit",
                dataType: 'json',
                data: {deptcode: $(this).val(),offcode: $("#offcode").val()},
                success: function(res){

                    if(res){
                        // console.log(res);
                        comboBoxOff.empty();
                        // comboBoxOff.append("<option value=''>[Select here]</option>");
                        for(var i = 0; i < res.length; i++){
                            comboBoxOff.append("<option value='"+res[i].sys_suboffice_code+"'>"+res[i].description+"</option>");
                        }
                    }
                }
            });
            /* Ajax get fund admin */
            $.ajax({
                type:"post",
                url:"<?php echo base_url();?>" + "/AjaxPostController/get_user_fund_admin",
                dataType: 'json',
                data: {deptcode: $(this).val(),offcode: $("#offcode").val()},
                success: function(res){

                    if(res){
                        // console.log(res);
                        inputFundAdmin.val(res[0].signatory_name);
                        inputFundAdminPos.val(res[0].position);
                    }
                }
            });

            /* Ajax get dept head */
            // alert($("#offcode").val());
            $.ajax({
                type:"post",
                url:"<?php echo base_url();?>" + "/AjaxPostController/get_user_dept_head",
                dataType: 'json',
                data: {deptcode: $(this).val(),offcode: $("#offcode").val()},
                success: function(res){

                    if(res){
                        console.log(res);
                        inputRequestedBy.val(res[0].head);
                        inputRequestedByPos.val(res[0].post);
                    }
                }
            });



        });
    });
</script>

<div class="container well">
   
    <input type="hidden" id='offcode' value='<?php echo $userlogged_data->sys_suboffice_code;?>'>
    <div class="text-center"><h3>GENERATE PROCUREMENT PLAN</h3></div>
    <div class="col-md-offset-3 col-md-6">
        <form method="post" action="GeneratePPMP">
            <div class="form-group">
                <label for="year">Year:</label>
                <input name='ppmp[year]' type="text" class="form-control" id="year" value="<?php echo date('Y');?>" maxlength="4" required>
            </div>
            <div class="form-group">
                <label for="acctcode">Account Code:</label>
                <select name="ppmp[acctcode]" id="acctcode" class="form-control" required="">
                    <option value="">[Select here]</option>
                    <?php 
                        if(isset($userlogged_acctcd)){
                            foreach ($userlogged_acctcd as $row) {
                               echo "<option value='$row->account_code'>$row->account_code</option>";
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="user">Prepared By:</label>
                <input name="ppmp[preparedby]" type="text" class="form-control" id="user" value="<?php echo $userlogged_data->usersname;?>" required>
            </div>
            <div class="form-group">
                <label for="post">Position:</label>
                <input name="ppmp[position]" type="text" class="form-control" id="post" value="<?php echo $userlogged_data->remarks;?>" required>
            </div>

            <div class="form-group">
                <div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Project Procurement Management Plan (PPMP)</a></li>
                        <!-- <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Consolidated Annual</a></li> -->
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">
                            <br>
                            <div class="form-group">
                                <label for="dept">Department:</label>
                                <select name="ppmp[dept]" id="dept" class="form-control" required="">
                                    <option value="">[Select here]</option>
                                    <?php 
                                        if(isset($userlogged_dept)){
                                            foreach ($userlogged_dept as $row) {
                                               echo "<option value='$row->department_code'>$row->description</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="off">Office:</label>
                                <select name="ppmp[off]" id="off" class="form-control">
                                    <option value="">[Select here]</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="fundadmin">Fund Administrator:</label>
                                <input id="fundamdmin" class="form-control" type="text" name="ppmp[fundadmin]" required="">
                            </div>
                            <div class="form-group">
                                <label for="fa_designation">Designation:</label>
                                <input id="fa_designation" class="form-control" type="text" name="ppmp[fa_designation]" required="">
                            </div>
                            <div class="form-group">
                                <label for="requestedby">Requested by:</label>
                                <input id="requestedby" class="form-control" type="text" name="ppmp[requestedby]" required="">
                            </div>
                            <div class="form-group">
                                <label for="rb_designation">Designation:</label>
                                <input id="rb_designation" class="form-control" type="text" name="ppmp[rb_designation]" required="">
                            </div>




                        </div>
                        <!-- <div role="tabpanel" class="tab-pane" id="profile">
                        </div> -->
                    </div>
                </div>
            </div>




            <button type="submit" class="btn btn-primary">Generate</button>
            <a href="ReportController" class="btn btn-default">Clear</a>
        </form>
    </div>

</div>
