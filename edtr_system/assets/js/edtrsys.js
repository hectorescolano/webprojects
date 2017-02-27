/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {
    //alert('jquery loaded.'); 
    var rsTable = $('#rsTable');
    //console.log(rsTable[0]);

    rsTable.DataTable({"jQueryUI": true});




    $('#confirmDelModal').on('show.bs.modal', function (event)
    {
        var button = $(event.relatedTarget); // Button that triggered the modal

        var employeeid = button.data('employeeid');
        var employeename = button.data('employeename');

        var modal = $(this);

        modal.find('.modal-body input#employeeid').val(employeeid);
        modal.find('.modal-body input#employeename').val(employeename);
        modal.find('.modal-body span#employee').html("<strong>ID#:" + employeeid + " - " + employeename + "</strong>.");
    });
});