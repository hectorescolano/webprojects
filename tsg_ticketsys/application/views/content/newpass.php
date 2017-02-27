<div class="container">


    <div class="row">
        <!-- create / update user column -->
        <h3 class="text-center page-header text-primary">Your password was reset. Please change it now</h3>
        <div class="col-md-6 col-md-offset-3">
            <form method="post" action="updateUserPass">

                <input type="hidden" name="userid" value="<?php echo $id; ?>">

                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="user_newpassword[user_username]" value="<?php echo $user_username; ?>" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="password">New Password:</label>
                    <input type="password" id="password" name="user_newpassword[user_password]" class="form-control" required="">
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password:</label>
                    <input type="password" id="confirm_password" name="user_newpassword[confirm_user_password]" class="form-control" required="">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">UPDATE PASSWORD</button>
                    <a href="HomeController" class="btn btn-danger">NOT NOW</a>
                </div>
            </form>
        </div>
    </div>
</div>