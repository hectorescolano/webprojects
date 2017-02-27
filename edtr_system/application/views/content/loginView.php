<div class="container">
    <h3 class="text-center text-primary page-header">eDTR System</h3>
    <div class="col-md-offset-4 col-md-4 well">
        <form name="form" role="form" method="post" action="loginUser">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="login[username]" value="<?php echo set_value('login[username]'); ?>" class="form-control" autofocus="" required/>
                <?php echo form_error('login[username]'); ?>
            </div>
            
            <div class="form-group">
                <label for="username">Password:</label>
                <input type="password" name="login[password]" value="<?php echo set_value('login[password]'); ?>" class="form-control" required/>
                <?php echo form_error('login[password]'); ?>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg">Login</button>
            </div>
        </form>
    </div>
</div>
