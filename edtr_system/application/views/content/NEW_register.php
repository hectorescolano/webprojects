<div class="container well">
    
    <div class="row">
        <div class="col-md-12">
            <div class="text-right">
                <a class="label label-default" href='search' style="margin-right:5px;">
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span> <small>SEARCH</small>
                </a>
                <a class="label label-default" href='scsr'><small>SCS REPORT</small></a>
            </div>
        </div>
    </div>
    <br>
    <form method="post" action="vrfyForm">
        <?= $errorMsg; ?>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12 bg-danger">
                        <div class="page-header text-danger"><label>DECEASED</label></div>
                        <div class="form-group">
                            <label>First Name:</label><input class="form-control" type="text" name="appdata[DECEASED_FNAME]">
                            <?php echo form_error('appdata[DECEASED_FNAME]'); ?>
                        </div>
                        <div class="form-group">
                            <label>Middle Name:</label><input class="form-control" type="text" name="appdata[DECEASED_MNAME]">
                            <?php echo form_error('appdata[DECEASED_MNAME]'); ?>
                        </div>
                        <div class="form-group">
                            <label>Last Name:</label>
                            <input class="form-control" type="text" name="appdata[DECEASED_LNAME]">
                            <?php echo form_error('appdata[DECEASED_LNAME]'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12 bg-primary">
                        <div class="page-header text-default"><label>CLAIMANT</label></div>
                        <div class="form-group">
                            <label>First Name:</label><input class="form-control" type="text" name="appdata[CLAIMANT_FNAME]" >
                            <?php echo form_error('appdata[CLAIMANT_FNAME]'); ?>
                        </div>
                        <div class="form-group">
                            <label>Middle Name:</label><input class="form-control" type="text" name="appdata[CLAIMANT_MNAME]">
                            <?php echo form_error('appdata[CLAIMANT_MNAME]'); ?>
                        </div>
                        <div class="form-group">
                            <label>Last Name:</label><input class="form-control" type="text" name="appdata[CLAIMANT_LNAME]">
                            <?php echo form_error('appdata[CLAIMANT_LNAME]'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <!--<legend class="text-primary text-center"><h4>REGISTRATION V2</h4></legend>-->
            <!--                    <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>-->







        </div>
        <br>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary btn-lg">Submit</button>
            <button type="reset" class="btn btn-default btn-lg">Clear</button>
            <a href="./" class="btn btn-link btn-lg">Back</a>
        </div>
    </form>

</div>