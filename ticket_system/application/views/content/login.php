<div class="jumbotron">
    <div class="row">
        <div class="col-md-5 col-md-offset-3">
            <span class="page-header text-center text-primary"><h1>MICS - TSG</h1></span>
            <span class="text-center"><h4>Ticketing System | Login Page</h4></span>
            <?php if (isset($login_error_msg)) { ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    <?php echo $login_error_msg; ?>
                </div>
            <?php } ?>
            <form method="post" action="UserAuth">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input class="form-control" type="text" name="user_data[username]" value="<?php echo set_value('user_data[username]'); ?>" placeholder="Username" autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input class="form-control" type="password" name="user_data[password]" value="<?php echo set_value('user_data[password]'); ?>" placeholder="Password">
                </div>

                <div class="form-group">
                    <button class="btn btn-primary btn-md" type="submit">LOGIN</button>
                    <a class="btn btn-default btn-md" href="login">CLEAR</a>
                </div>
            </form>
        </div>
    </div>
</div>




