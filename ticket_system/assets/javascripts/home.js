/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function ()
{
    
//    $("#frmWkUp").submit(function(e) {
//        e.preventDefault();
//    });

    $("#tbTickets").DataTable({'pageLength': 100});
    
    
    $('#vwTicketModal').on('show.bs.modal', function (event)
    {
        var button = $(event.relatedTarget); // Button that triggered the modal
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-body input#tkt_id').val(button.data('id'));
        modal.find('.modal-body select#tkt_status').val(button.data('status'));
        modal.find('.modal-body input#tkt_office').val(button.data('abbrev'));
        modal.find('.modal-body input#tkt_problem').val(button.data('probname'));
        modal.find('.modal-body input#tkt_request').val(button.data('reqdetls'));
        modal.find('.modal-body input#tkt_client').val(button.data('abbrev'));
        modal.find('.modal-body input#tkt_division').val(button.data('division'));
        var work_update_history = button.data('workhist').split(",");
//        console.log(work_update_history);
        modal.find('.modal-body tbody#wk-up-hist').empty();
//        var loop_ctr = work_update_history.length / 6;
//        console.log(Math.round(loop_ctr));
        for (var i = 0; i < work_update_history.length - 1; i+=6) {
//            console.log(i);
            modal.find('.modal-body tbody#wk-up-hist').append("<tr>");
            modal.find('.modal-body tbody#wk-up-hist').append("<td>" + work_update_history[i] + "</td>");
            modal.find('.modal-body tbody#wk-up-hist').append("<td>" + work_update_history[i + 1] + "</td>");
            modal.find('.modal-body tbody#wk-up-hist').append("<td>" + work_update_history[i + 2] + "</td>");
            modal.find('.modal-body tbody#wk-up-hist').append("<td>" + work_update_history[i + 3] + "</td>");
            modal.find('.modal-body tbody#wk-up-hist').append("<td>" + work_update_history[i + 4] + "</td>");
            modal.find('.modal-body tbody#wk-up-hist').append("<td>" + work_update_history[i + 5] + "</td>");
            modal.find('.modal-body tbody#wk-up-hist').append("</tr>");
        }
    });



});


