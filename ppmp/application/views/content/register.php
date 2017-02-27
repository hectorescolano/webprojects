<div class="container well">
    <div class="row">
        <div class="col-md-12">
            <div class="text-right">
                <a class="btn btn-default btn-link" href='search'>
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span> <small>SEARCH / UPDATE</small>
                </a>
                <a class="btn btn-default btn-link" href='scsr'><small>SCS REPORT</small></a>
            </div>
            <?= $errorMsg; ?>
            <form method="post" action="vrfyForm">
                <fieldset>
                    <legend class="text-primary text-center"><h4>REGISTRATION</h4></legend>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Claimant First name:</label><input class="form-control" type="text" name="appdata[CLAIMANT_FNAME]" autofocus="" 
                                                                                 value="">
                                                                                 <?php echo form_error('appdata[CLAIMANT_FNAME]'); ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Claimant Middle name:</label><input class="form-control" type="text" name="appdata[CLAIMANT_MNAME]" 
                                                                                  value="">
                                                                                  <?php echo form_error('appdata[CLAIMANT_MNAME]'); ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Claimant Last name:</label><input class="form-control" type="text" name="appdata[CLAIMANT_LNAME]" 
                                                                                value="">
                                                                                <?php echo form_error('appdata[CLAIMANT_LNAME]'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Deceased First name:</label><input class="form-control" type="text" name="appdata[DECEASED_FNAME]">
                                        <?php echo form_error('appdata[DECEASED_FNAME]'); ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Deceased Middle name:</label><input class="form-control" type="text" name="appdata[DECEASED_MNAME]">
                                        <?php echo form_error('appdata[DECEASED_MNAME]'); ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Deceased Last name:</label><input class="form-control" type="text" name="appdata[DECEASED_LNAME]" 
                                                                                value="">
                                                                                <?php echo form_error('appdata[DECEASED_LNAME]'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary btn-lg">Save</button>
                    <button type="reset" class="btn btn-default btn-lg">Clear</button>
                    <a href="./" class="btn btn-link btn-lg">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>