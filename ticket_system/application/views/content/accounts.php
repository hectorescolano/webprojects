<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<script type="text/javascript" src="<?= base_url('assets/javascripts/accounts.js'); ?>"></script>
<div class="container-fluid" style="font-size: 70%; overflow: auto; height: 460px;">
    <fieldset id="container-search-user">
        <legend class="text-primary">SEARCH USER</legend>
        <form method="post" action="searchUser">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="search_userfname">First Name:</label>
                                <input type="text" class="form-control input-sm" name="search_user[user_fname]">
                            </div>
                            <div class="form-group">
                                <label for="search_userlname">Last Name:</label>
                                <input type="text" class="form-control input-sm" name="search_user[user_lname]">
                            </div>
                            <div class="form-group">
                                <label for="search_usertype">Account Type:</label>
                                <select class="form-control" name="search_user[user_type]">
                                    <option value="">--Select here--</option>
                                    <option value="1">Client User</option>
                                    <option value="2">Tech User</option>
                                    <option value="3">Tech Admin</option>
                                    <option value="4">Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="search_username">Username:</label>
                                <input type="text" class="form-control input-sm" name="search_user[user_username]">
                            </div>
                            <div class="form-group">   
                                <label for="search_useroffice">Office:</label>
                                <select class="form-control" name="search_user[user_office]">
                                    <option value="">--Select here--</option>
                                    <?php
                                    if (isset($offices)) {
                                        foreach ($offices as $row) {
                                            echo "<option value='$row->OfficeCode'>$row->Description</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="search_userdiv">Division:</label>
                                <input type="text" class="form-control input-sm" name="search_user[user_division]">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit"><span class='glyphicon glyphicon-search'></span> SEARCH</button>
                                <button class="btn btn-default" type="reset">CLEAR</button>
                                <a href="accounts" class="btn btn-link">RESET</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </fieldset>
    <hr>
    <fieldset id="container-create-user">
        <legend class="text-primary">CREATE USER ACCOUNT</legend>
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <form method="post" action="createUser">
                            <div class="form-group">
                                <label for="new_userfname">First Name:</label>
                                <input type="text" class="form-control" name="new_user[user_fname]" required="">
                            </div>
                            <div class="form-group">
                                <label for="new_userlname">Last Name:</label>
                                <input type="text" class="form-control" name="new_user[user_lname]" required="">
                            </div>
                            <div class="form-group">
                                <label for="new_useroffice">Office:</label>
                                <select class="form-control" name="new_user[user_office]" required="">
                                    <option value="">--Select here--</option>
                                    <?php
                                    if (isset($offices)) {
                                        foreach ($offices as $row) {
                                            echo "<option value='$row->OfficeCode'>$row->Description</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="new_userdiv">Division:</label>
                                <input type="text" class="form-control input-sm" name="new_user[user_division]" required="">
                            </div>
                            <div class="form-group">
                                <label for="new_userdivision">Contact #:</label>
                                <input type="text" class="form-control" name="new_user[user_contact]" required="">
                            </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="new_userlocation">Location:</label>
                            <input type="text" class="form-control" name="new_user[user_location]" required="">
                        </div>
                        <div class="form-group">
                            <label for="new_useremail">Email Address:</label>
                            <input type="text" class="form-control" name="new_user[user_email]">
                        </div>
                        <div class="form-group">
                            <label for="new_usertype">Account Type:</label>
                            <select class="form-control" name="new_user[user_type]" required="">
                                <option value="">--Select here--</option>
                                <option value="1">Office Admin</option>
                                <option value="2">TSG</option>
                                <option value="3">TSG Admin</option>
                                <option value="4">Admin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">SAVE</button>
                            <button class="btn btn-default" type="reset">CLEAR</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset id="container-user-list">
        <legend class="text-primary">USER ACCOUNT LIST</legend>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <?php
                    if (isset($active_user_list)) {
                        echo "<table class='table table-hover table-condensed' style='background-color:#FFF;'>";
                        echo "<thead class='bg-primary' style='color:#FFF;'>";
                        echo "<th>ACTION</th>";
                        echo "<th>USERNAME</th>";
                        echo "<th>FIRSTNAME</th>";
                        echo "<th>LASTNAME</th>";
                        echo "<th>OFFICE</th>";
                        echo "<th>DIVISION</th>";
                        echo "<th>EMAIL</th>";
                        echo "<th>CONTACT</th>";
                        echo "<th>LOCATION</th>";
                        echo "</thead>";
                        echo "<tbody>";
                        foreach ($active_user_list as $row) {
                            echo "<tr class=''>";
                            echo "<td><a href='#update' data-toggle='modal' data-target='#editUserModal' "
                            . " data-username='$row->user_username'"
                            . " data-fname='$row->user_fname'"
                            . " data-lname='$row->user_lname'"
                            . " data-office='$row->user_office'"
                            . " data-division = '$row->user_division'"
                            . " data-email = '$row->user_email'"
                            . " data-contact = '$row->user_contact'"
                            . " data-location = '$row->user_location'"
                            . " data-id = '$row->user_id'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span> Edit</a> | "
                            . "<a href='#reset' data-toggle='modal' data-target='#resetUserModal' data-id = '$row->user_id'><span class='glyphicon glyphicon-refresh' aria-hidden='true'></span> Reset</a> | "
                            . "<a href='#delete' data-toggle='modal' data-target='#deleteUserModal' data-id = '$row->user_id'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> Delete</a></td>";
                            echo "<td>$row->user_username</td>";
                            echo "<td>$row->user_fname</td>";
                            echo "<td>$row->user_lname</td>";
                            echo "<td>$row->Abreviation</td>";
                            echo "<td>$row->user_division</td>";
                            echo "<td>$row->user_email</td>";
                            echo "<td>$row->user_contact</td>";
                            echo "<td>$row->user_location</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </fieldset>
</div>
<div>
    <!-- Update User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="exampleModalLabel">Update User</h3>
                </div>
                <form method="post" action="UpdateUserAccount">
                    <div class="modal-body">

                        <input type="hidden" id='user_id' name="update_user[user_id]">
                        <div class="form-group">
                            <label for="user_username" class="control-label">Username:</label>
                            <input type="text" class="form-control" id="user_username" name="update_user[user_username]" required="">
                        </div>
                        <div class="form-group">
                            <label for="user_password" class="control-label">New password:</label>
                            <input type="password" class="form-control" id="user_password" name="update_user[user_password]">
                        </div>
                        <div class="form-group">
                            <label for="user_fname" class="control-label">First name:</label>
                            <input type="text" class="form-control" id="user_fname" name="update_user[user_fname]" required="">
                        </div>
                        <div class="form-group">
                            <label for="user_lname" class="control-label">Last name:</label>
                            <input type="text" class="form-control" id="user_lname" name="update_user[user_lname]" required="">
                        </div>
                        <div class="form-group">
                            <label for="user_email" class="control-label">Email:</label>
                            <input type="text" class="form-control" id="user_email" name="update_user[user_email]">
                        </div>
                        <div class="form-group">
                            <label for="user_office" class="control-label">Office:</label>
                            <select class="form-control" id="user_office" name="update_user[user_office]" required="">
                                <option value="">--Select here--</option>
                                <?php
                                if (isset($offices)) {
                                    foreach ($offices as $office) {
                                        echo "<option value = '$office->OfficeCode'>";
                                        echo $office->Description . "(" . $office->Abreviation . ")";
                                        echo "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="user_division" class="control-label">Division:</label>
                            <input type="text" class="form-control" id="user_division" name="update_user[user_division]" required="">
                        </div>
                        <div class="form-group">
                            <label for="user_contact" class="control-label">Contact:</label>
                            <input type="text" class="form-control" id="user_contact" name="update_user[user_contact]" required="">
                        </div>
                        <div class="form-group">
                            <label for="user_location" class="control-label">Location:</label>
                            <input type="text" class="form-control" id="user_location" name="update_user[user_location]" required="">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Update
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Reset User Modal -->
    <div class="modal fade" id="resetUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="exampleModalLabel">Reset User Password</h3>
                </div>
                <form method="post" action="ResetUserPassword">
                    <div class="modal-body">
                        <input type="hidden" id='reset_userpass' name="reset_userpass[user_id]">
                        <div class="form-group">
                            <p>Are you sure you want to reset the password?</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Confirm
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="exampleModalLabel">Delete User</h3>
                </div>
                <form method="post" action="DeleteUserAccount">
                    <div class="modal-body">
                        <input type="hidden" id='delete_user' name="delete_user[user_id]">
                        <div class="form-group">
                            <p>Are you sure you want to delete this user?</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Confirm
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>