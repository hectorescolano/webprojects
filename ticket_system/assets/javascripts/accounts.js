/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function ()
{
    $('#editUserModal').on('show.bs.modal', function (event)
    {
        var button = $(event.relatedTarget); // Button that triggered the modal

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-body input#user_username').val(button.data('username'));
        modal.find('.modal-body input#user_fname').val(button.data('fname'));
        modal.find('.modal-body input#user_lname').val(button.data('lname'));
        modal.find('.modal-body input#user_division').val(button.data('division'));
        modal.find('.modal-body input#user_email').val(button.data('email'));
        modal.find('.modal-body input#user_contact').val(button.data('contact'));
        modal.find('.modal-body input#user_location').val(button.data('location'));
        modal.find('.modal-body input#user_id').val(button.data('id'));
        modal.find('.modal-body select#user_office').val(button.data('office'));
    });
    
    $('#resetUserModal').on('show.bs.modal', function (event)
    {
        var button = $(event.relatedTarget); // Button that triggered the modal

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-body input#reset_userpass').val(button.data('id'));

    });
    
    $('#deleteUserModal').on('show.bs.modal', function (event)
    {
        var button = $(event.relatedTarget); // Button that triggered the modal

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-body input#delete_user').val(button.data('id'));

    });


});


