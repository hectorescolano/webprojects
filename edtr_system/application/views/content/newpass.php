<div class="container">
	

	<div class="row">
			<!-- create / update user column -->
			<h3 class="text-center page-header text-primary">Your password has been reset, please update it below.</h3>
			<div class="col-md-6 col-md-offset-3">
				<form method="post" action="updatepass">

					<input type="hidden" name="user[id]" value="<?=$userid;?>">
					
					<div class="form-group">
						<label for="username">Username:</label>
						<input type="text" name="user[user_username]" value="<?=$username;?>" class="form-control" readonly>
					</div>
					<div class="form-group">
						<label for="username">New Password:</label>
						<input type="password" name="user[user_password]" class="form-control" value="<?php echo set_value('user[user_password]'); ?>">
						 <?php echo form_error('user[user_password]'); ?>
					</div>
					<div class="form-group">
						<label for="username">Confirm New Password:</label>
						<input type="password" name="user[confirm_user_password]" class="form-control">
						 <?php echo form_error('user[confirm_user_password]'); ?>
					</div>
					<div class="form-group">
						<button class="btn btn-primary">UPDATE PASSWORD</button>
					</div>
				</form>
			</div>
	</div>
</div>