<script type="text/javascript" src="<?=base_url('assets/js/newuser.js');?>"></script>
<style type="text/css">
	input.transparent{
		border:none;
		font-size: 16px;
	}
</style>
<div class="container-fluid well">
	<h1 class="text-center page-header text-primary">USER ACCOUNT SETTINGS</h1>
	<?=$errorMsg;?>

	<div class="row">
		<!-- create / update user column -->
		<div class="col-md-4">
			<form method="post" action="checkadduser">
				<div class="form-group">
					<label for="name">User's Full Name:</label>
					<input type="text" name="user[name]" class="form-control" placeholder="ex. John Cruz" required>
					<?php echo form_error('user[name]'); ?>
				</div>
				<div class="form-group">
					<label for="username">Login Username:</label>
					<input type="text" name="user[user_username]" class="form-control" required>
					<?php echo form_error('user[user_username]'); ?>
				</div>
				<div class="form-group">
					<label for="username">Login Password:</label>
					<input type="password" name="user[user_password]" class="form-control">
					<?php echo form_error('user[user_password]'); ?>
				</div>
				<div class="form-group">
					<label for="usertype">User Type:</label>
					<select name="user[user_type]" class="form-control">
						<option value="3">User</option>
						<option value="2">BAO Administrator</option>
						<option value="1">Super Administrator</option>
					</select>
				</div>
				<div class="form-group">
					<button class="btn btn-primary">ADD NEW USER</button>
					<a href='./' class="btn btn-default">BACK TO MENU</a>
				</div>
			</form>
		</div>
		<!-- user accounts view column -->
		<div class="col-md-8">
			<div class="table-responsive" style="border:1px solid #ccc;font-size: 70%;overflow-y: auto;height: 300px;">
					<table class="table table-striped table-hover table-condensed">
						<thead>
							<tr style="color:#fff;background-color: rgb(0,100,200);">
								<th>&nbsp;</th>
								<th>NAME</th>
								<th>USERNAME</th>
								<th>ROLE</th>
								<th>CREATED BY</th>
								<th>LAST LOGIN</th>
								<th>LAST LOGOUT</th>
								<th>LAST ACTION</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								if(!isset($users) || $users == ''){
									echo "<tr><td colspan='5'>No users found<td></tr>";
								} else {
									foreach ($users as $row) 
									{

										$name = $row->user_fname." ".$row->user_lname;

										if(isset($row->login)) 
											$login = date_format(date_create($row->login),'Y-m-d h:i A');
										else
											$login = "";

										if(isset($row->logout)) 
											$logout = date_format(date_create($row->logout),'Y-m-d h:i A');
										else
											$logout = "";

										echo "<tr>";
										echo "<td><a href='#update' 
										data-toggle='modal' 
										data-target='#myModal'
										data-userid='$row->id' 
										data-userfname='$row->user_fname' 
										data-userlname='$row->user_lname'>[Edit]</a>

										<a href='#reset' 
										 data-resetid='$row->id'
										 data-resetusername='$row->user_username'
										 data-toggle='modal'
										 data-target='#myModalreset'
										 data-resetname='$row->user_fname' 
										 >[Reset]</a>
										</td>";
										echo "<td>$name</td>";
										echo "<td>$row->user_username</td>";
										echo "<td>$row->user_type</td>";
										echo "<td>$row->created_by</td>";
										echo "<td>$login</td>";
										echo "<td>$logout</td>";
										echo "<td>$row->last_action</td>";
										echo "</tr>";
									}
								}
							?>
						</tbody>
					</table>
			</div>
		</div>
	</div>
</div>



<!-- Modal Update Account -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title text-center" id="myModalLabel" style="color:#fff;">Update User Account</h3>
      </div>
      <!-- form update -->
      <form id="updateForm" method="post" action="updateuser">
      	  <!-- modal body -->
	      <div class="modal-body">
		      	<div class="form-group">
		      		<label for="userid">ID:</label><input type="text" name="update[id]" id="userid" class="form-control" readonly>
		      	</div>
		      	<div class="form-group">
		      		<label for="userfname">First Name:</label><input type="text" name="update[user_fname]" id="userfname" class="form-control" required>
		      	</div>
		      	<div class="form-group">
		      		<label for="userlname">Last Name:</label><input type="text" name="update[user_lname]" id="userlname" class="form-control" required>
		      	</div>
		      	<div class="form-group">
		      		<label for="usernewpass">New Password:</label><input type="password" name="update[user_password]" id="usernewpass" class="form-control">
		      	</div>
	      </div>
	      <!-- modal footer -->
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button id="btnUpdate" type="submit" class="btn btn-primary">Save changes</button>
	      </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal Reset Password -->
<div class="modal fade" id="myModalreset" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: rgb(200,100,100);">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title text-center" id="myModalLabel2" style="color:#fff;">Reset Password</h3>
      </div>
      <!-- form update -->
      <form id="resetpass" method="post" action="resetpass">
      	  <!-- modal body -->
	      <div class="modal-body">
	      		<input type="hidden" name="reset[id]" id="resetid">
	      		<input type="hidden" name="reset[user_username]" id="resetusername">
		      	<div class="form-group">
		      		Are you sure you want to reset password of <input type="text" class="transparent text-right" name="reset[user_fname]" id="resetname" readonly>?
		      	</div>
	      </div>
	      <!-- modal footer -->
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	        <button id="btnReset" type="submit" class="btn btn-danger">Yes, reset password</button>
	      </div>
      </form>
    </div>
  </div>
</div>



