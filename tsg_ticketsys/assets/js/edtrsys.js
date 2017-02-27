/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {
//    alert('jquery loaded.'); 
    var rsTable = $('#rsTable');
    var rsUserList = $("#rsUserList");
    var tkt_status = $("#tkt_status");
    var tkt_technician = $('#tkt_technician');
    var btnUpdateWrkHist = $('#btnUpdateWrkHist');
    var techWrkHistTb = $("#techWrkHistTb");
    var updateTicketForm = $("#updateTicketForm");
    var newRequestTicketForm = $("#newRequestTicketForm");
    var newUserAccountForm = $("#newUserAccountForm");
    var btnUpdateTicket = $("#btnUpdateTicket");
    var tkt_service_done_fg = $("#tkt_service_done_fg");

    var new_report_input = $('input[name*=new_report]');
    var new_report_select = $('select[name*=new_report]');
    var new_report = [new_report_input, new_report_select];
    var btnViewReport = $("#btnViewReport");
    var report_result = $("#report_result");

    var viewTicketDetailBtn = $("#viewTicketDetailBtn");
    var ticket_details_no = $("#ticket_details_no");
    var ticketDetailsResult = $("#ticketDetailsResult");

    viewTicketDetailBtn.click(function () {
        //lert(ticket_details_no.val());

        if (ticket_details_no.val().length > 0) {
            $.ajax({
                type: "post",
                url: $("#burls").val() + "/AjaxPOstController/get_ticket_details",
                dataType: 'json',
                data: {ticket_id: ticket_details_no.val()},
                success: function (res) {
//                    console.log(res[0]);
                    var content = '';
                    if (res || res.length > 0) {
                        content += "<br><div class='row well'><h2>TICKET ID: " + res[0].TKT_NO + "</h2><hr>";
                        content += "<div class='col-md-12'>";
                        content += "<p>DATE LOGGED: " + res[0].CREATED + "<p>";
                        content += "<p>LOGGED BY: " + res[0].CREATED_BY + "<p>";


                        switch (res[0].PROBLEM) {
                            case 1:
                                content += "<p>SUMMARY: HARDWARE<p>";
                                break;
                            case 2:
                                content += "<p>SUMMARY: SOFTWARE<p>";
                                break;
                            case 3:
                                content += "<p>SUMMARY: NETWORK<p>";
                                break;
                            case 4:
                                content += "<p>SUMMARY: COMMUNICATION<p>";
                                break;
                        }

                        content += "<p>DETAILS: " + res[0].PROB_DETAILS + "<p>";

                        if (res[0].SERVICE_DONE == null) {
                            content += "<p>RESOLUTION: (ticket was not yet resolved)<p>";
                            content += "<p>RESOLVED BY: (ticket was not yet resolved)<p>";
                            content += "<p>DATE RESOLVED: (ticket was not yet resolved)<p>";
                        } else {
                            content += "<p>RESOLUTION: " + res[0].SERVICE_DONE + "<p>";
                            content += "<p>RESOLVED BY: " + res[0].RESOLVED_BY + "<p>";
                            content += "<p>DATE RESOLVED: " + res[0].DATERESOLVED + "<p>";
                        }

                        if (res[0].CLOSED_BY == null) {
                            content += "<p>CLOSED BY: (ticket was not yet closed)<p>";
                            content += "<p>DATE CLOSED: (ticket was not yet closed)<p>";
                        } else {
                            content += "<p>CLOSED BY: " + res[0].CLOSED_BY + "<p>";
                            content += "<p>DATE CLOSED: " + res[0].DATECLOSED + "<p>";
                        }

                        content += "</div>";
                        content += "</div>";
                        ticketDetailsResult.html(content);
                    } else {
                        content += "<br><h5>Ticket ID is incorrect / does not exist. Please try again and follow this format 'TKTXXXXXXXX'</h5>";
                        ticketDetailsResult.html(content);
                    }
                }
            });

        } else {
            alert("Please enter ticket id and try again.");
        }


    });


    btnViewReport.click(function () {

        new_report_input = $('input[name*=new_report]');
        new_report_select = $('select[name*=new_report]');
        new_report = [new_report_input, new_report_select];

        var datefrom = new_report[0][0].value;
        var dateto = new_report[0][1].value;
        var tktStatus = new_report[1][0].value;
        var tktProbCat = new_report[1][1].value;

        $.ajax({
            type: "post",
            url: $("#burls").val() + "/AjaxPostController/get_ticket_reports",
            dataType: 'json',
            data: {datefrom: datefrom, dateto: dateto, tktStatus: tktStatus, tktProbCat: tktProbCat},
            success: function (res) {
                report_result.html("");
                if (res) {
                    console.log(res);
                    //report_result.html(res);

                    var content = "";
//                    content += "<div class='form-group'>";
//                    content += "<strong>Date:</strong> " + datefrom + " to 0" + dateto;
//                    content += "</div>";
                    content += "<table id='tktSumProbRep' class='table table-bordered table-condensed table-striped table-hover'>";
                    content += "<thead><th>Category Problem</th><th>No. of Encounter</th></thead>";

                    $.each(res.sum_ticket_problems, function (index, value) {
                        content += "<tr>";
                        $.each(value, function (prop, propVal) {
                            //console.log(prop+ ":" + propVal);
                            content += "<td>" + propVal + "</td>";
                        });
                        content += "</tr>";
                    });

                    content += "</table>";
                    content += "<hr>";
                    content += "<table id='tktSumRep' class='table table-bordered table-condensed table-striped table-hover'>";
                    content += "<thead><th colspan='2'><strong>Ticket Summary Report</strong></th></thead>";
                    content += "<tr><td width='17%'>Total No. of Ticket(s) Created: </td><td>" + res.total_tickets_created + "</td></tr>";
                    content += "<tr><td>Total No. of Ticket(s) Resolved: </td><td>" + res.total_tickets_resolved + "</td></tr>";
                    content += "<tr><td>Total No. of Ticket(s) Closed: </td><td>" + res.total_tickets_closed + "</td></tr>";
                    content += "<tr><td>Total No. of Ticket(s) Opened: </td><td>" + res.total_tickets_open + "</td></tr>";
                    content += "<tr><td>Total No. of Ticket(s) Assigned: </td><td>" + res.total_tickets_assigned + "</td></tr>";
                    content += "<tr><td>Total No. of Ticket(s) Canceled: </td><td>" + res.total_tickets_canceled + "</td></tr>";
                    content += "</table>";
                    report_result.html(content);



                }
            }
        });



    });




    tkt_service_done_fg.hide();


    newUserAccountForm.on('submit', function (e) {
        if (confirm('Are you sure to add this user account?')) {
            this.submit();
            alert('User account was added!');
        } else {
            e.preventDefault();
        }
    });




    newRequestTicketForm.on('submit', function (e) {
        if (confirm('Are you sure to add this request ticket?')) {
            this.submit();
            alert('Request ticket was added!');
        } else {
            e.preventDefault();
        }
    });



//    alert(updateTicketForm);



    updateTicketForm.on('submit', function (e) {
//        alert(tkt_status.val());
        if (tkt_status.val() != 'CLOSED') {
            if (confirm('Are you sure to update this ticket?')) {
                this.submit();
                alert('Ticket was updated!');
            } else {
                e.preventDefault();
            }
        } else {
            alert('You are not allowed to close this ticket.');
            e.preventDefault();
        }




    });




    tkt_status.change(function () {
        if ($(this).val() == "NEW") {
            tkt_technician.removeAttr("required");
            tkt_technician.val("");
        } else {
            tkt_technician.prop("required", true);
            if ($(this).val() == "RESOLVED") {
                tkt_service_done_fg.show();
            } else {
                tkt_service_done_fg.hide();
            }
        }


    });

    tkt_technician.change(function () {

        if ($(this).val().length > 0) {
            tkt_status.val("ASSIGNED");
        } else {
            tkt_status.val("NEW");
        }
    });
    //console.log(rsTable[0]);

    $("#tabs").tabs();

    rsTable.DataTable({"jQueryUI": true});
    rsUserList.DataTable({"jQueryUI": true});
    techWrkHistTb.DataTable({"jQueryUI": true});


    $('#userAccountDtlModal').on('show.bs.modal', function (event)
    {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var user_id = button.data('user_id');
        var user_fname = button.data('user_fname');
        var user_lname = button.data('user_lname');
        var user_username = button.data('user_username');
        var user_office = button.data('user_office');
        var user_division = button.data('user_division');
        var user_contact = button.data('user_contact');
        var user_location = button.data('user_location');
        var user_type = button.data('user_type');

        var modal = $(this);
        modal.find('.modal-body input#user_id').val(user_id);
        modal.find('.modal-body input#update_username').val(user_username);
        modal.find('.modal-body input#update_userfname').val(user_fname);
        modal.find('.modal-body input#update_userlname').val(user_lname);
        modal.find('.modal-body select#update_userofficecode').val(user_office);
        modal.find('.modal-body input#update_userdivision').val(user_division);
        modal.find('.modal-body input#update_usercontact').val(user_contact);
        modal.find('.modal-body input#update_userlocation').val(user_location);
        modal.find('.modal-body select#update_usertype').val(user_type);

    });


    $('#resetConfirmModal').on('show.bs.modal', function (event)
    {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var user_id = button.data('user_id');
        var modal = $(this);
        modal.find('.modal-body input#reset_confirm_userid').val(user_id);
    });



    $('#confirmDelModal').on('show.bs.modal', function (event)
    {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var ticketid = button.data('ticketid');
//        alert(ticketid);
        var modal = $(this);
        modal.find('.modal-body input#ticketid').val(ticketid);
        modal.find('.modal-body span#tktid').html("<strong>ID#:" + ticketid + "</strong>");
    });

    $("#closeTicketModal").on('show.bs.modal', function (event)
    {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var ticketid = button.data('ticketid');
        var modal = $(this);

        modal.find('.modal-body input#close_tktid').val(ticketid);
    });


    $('#vwTicketModal').on('show.bs.modal', function (event)
    {
//        alert('hey');
        var button = $(event.relatedTarget); // Button that triggered the modal
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.


        var modal = $(this);
        modal.find('.modal-body input#tkt_id').val(button.data('id'));
        modal.find('.modal-body select#tkt_status').val(button.data('status'));
        modal.find('.modal-body input#tkt_office').val(button.data('abbrev'));
        modal.find('.modal-body select#tkt_prob_cat').val(button.data('problem'));
        modal.find('.modal-body select#tkt_urgency').val(button.data('urgency'));
        modal.find('.modal-body textarea#tkt_prob_dtl').val(button.data('probdetails'));
        modal.find('.modal-body textarea#tkt_request_dtl').val(button.data('reqdetls'));
        modal.find('.modal-body input#tkt_client').val(button.data('abbrev'));
        modal.find('.modal-body input#tkt_division').val(button.data('division'));
        modal.find('.modal-body select#tkt_technician').val(button.data('techid'));
        modal.find('.modal-body select#tkt_techid').val(button.data('techid'));
        modal.find('.modal-body textarea#tkt_service_done').val(button.data('servicedone'));
        modal.find('.modal-body select#tkt_urgency').val(button.data('urgency'));

        if (tkt_status.val() == 'CLOSED') {
            tkt_status.prop("disabled", true);
            btnUpdateTicket.prop("disabled", true);
            tkt_technician.prop("disabled", true);
        } else {
            btnUpdateTicket.prop("disabled", false);
            tkt_status.prop("disabled", false);
            tkt_technician.prop("disabled", false);
        }
        if (tkt_status.val() == 'RESOLVED') {
            tkt_service_done_fg.show();
        } else {
            tkt_service_done_fg.hide();
        }

        if (tkt_status.val() == "NEW") {
            tkt_technician.removeAttr("required");
            tkt_technician.val("");
        } else {
            tkt_technician.prop("required", true);
        }

        $.ajax({
            type: "post",
            url: $("#burls").val() + "/AjaxPostController/get_ticket_workhistory",
            dataType: 'json',
            data: {tkt_id: button.data('id')},
            success: function (res) {

                if (res) {
                    var content = "";

                    content += "<table id='techWrkHistTb' class='table table-bordered table-condensed table-striped table-hover' style='font-size:80%;'>";
                    content += "<thead><th class='text-center'>TECH ASSIGNED</th>";
                    content += "<th class='text-center'>WORK UPDATE DESCRIPTION</th><th class='text-center'>CREATED</th><th class='text-center'>CREATED BY</th>";
                    content += "</thead>";
                    content += "<tbody>";

                    for (var i = 0; i < res.length; i++) {
                        var recno = res[i]['RECORD_NO'];
                        var tktid = res[i]['TKT_NO'];
                        var techid = res[i]['TECH_ID'];
                        var desc = res[i]['UPDATE_DESCRIPTION'];
                        var created = res[i]['CREATED'];
                        var created_by = res[i]['CREATED_BY'];
                        var user_fname = res[i]['user_fname'];

                        content += "<tr>";
//                        content += "<td width='3%'>" + recno + "</td>";
//                        content += "<td>" + tktid + "</td>";
                        content += "<td>" + user_fname + "</td>";
                        content += "<td>" + desc + "</td>";
                        content += "<td>" + created + "</td>";
                        content += "<td>" + created_by + "</td>";
                        content += "</tr>";
                    }
                    content += "</tbody></table>";
                    modal.find('.modal-body div#tbTicketHistory').html(content);

                }
            }
        });

    });






    btnUpdateWrkHist.click(function ()
    {

        if ($("#tkt_id").val().length > 0 && $("#tkt_techid").val().length > 0 && $("#work_update_desc").val().length > 0)
        {
            if (confirm("Are you sure you want to add work update on this ticket?"))
            {
                $.ajax
                        ({
                            type: "post",
                            url: $("#burls").val() + "/AjaxPostController/update_ticket_workhist",
                            dataType: 'json',
                            data: {
                                tkt_id: $("#tkt_id").val(),
                                tkt_techid: $("#tkt_techid").val(),
                                tkt_update: $("#work_update_desc").val()
                            },
                            success: function (res)
                            {
//                        $('#tbTicketHistory').html("");
                                if (res == 1 || res == "1") {
                                    $.ajax
                                            ({
                                                type: "post",
                                                url: $("#burls").val() + "/AjaxPostController/get_ticket_workhistory",
                                                dataType: 'json',
                                                data: {tkt_id: $("#tkt_id").val()},
                                                success: function (res2)
                                                {

                                                    if (res2)
                                                    {
                                                        var content = "";

                                                        content += "<table id='techWrkHistTb' class='table table-bordered table-condensed table-striped table-hover' style='font-size:80%;'>";
                                                        content += "<thead><th class='text-center'>TECH ASSIGNED</th>";
                                                        content += "<th class='text-center'>WORK UPDATE DESCRIPTION</th><th class='text-center'>CREATED</th><th class='text-center'>CREATED BY</th>";
                                                        content += "</thead>";
                                                        content += "<tbody>";

                                                        for (var i = 0; i < res.length; i++)
                                                        {
                                                            var recno = res[i]['RECORD_NO'];
                                                            var tktid = res[i]['TKT_NO'];
                                                            var techid = res[i]['TECH_ID'];
                                                            var desc = res[i]['UPDATE_DESCRIPTION'];
                                                            var created = res[i]['CREATED'];
                                                            var created_by = res[i]['CREATED_BY'];
                                                            var user_fname = res[i]['user_fname'];
                                                            content += "<tr>";
                                                            content += "<td>" + user_fname + "</td>";
                                                            content += "<td>" + desc + "</td>";
                                                            content += "<td>" + created + "</td>";
                                                            content += "<td>" + created_by + "</td>";
                                                            content += "</tr>";
                                                        }



                                                        content += "</tbody></table>";
                                                        $('#tbTicketHistory').html(content);
                                                        $("#tkt_techid").val('');
                                                        $("#work_update_desc").val('');
                                                        alert('Ticket Work Update added!');
                                                    }
                                                }
                                            });
                                }
                            }

                        });

            } else {

            }


        } else {
            alert('Please fill up all input fields.');
        }




    });














});