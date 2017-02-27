$(function ()
{




    $('#myModal').on('show.bs.modal', function (event)
    {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id'); // Extract info from data-* attributes
        var remarks = button.data('remarks');
        var deceasedfname = button.data('deceasedfname');
        var deceasedmname = button.data('deceasedmname');
        var deceasedlname = button.data('deceasedlname');
        var claimantfname = button.data('claimantfname');
        var claimantmname = button.data('claimantmname');
        var claimantlname = button.data('claimantlname');
        var scr_id = button.data('scr_id');
        var voc_id = button.data('voc_id');
        
//        console.log(scr_id);
//        console.log(voc_id);
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);

        modal.find('.modal-body input#appid').val(id);
        modal.find('.modal-body textarea#remarks').val(remarks);
        modal.find('.modal-body input#deceasedfname').val(deceasedfname);
        modal.find('.modal-body input#deceasedmname').val(deceasedmname);
        modal.find('.modal-body input#deceasedlname').val(deceasedlname);
        modal.find('.modal-body input#claimantfname').val(claimantfname);
        modal.find('.modal-body input#claimantmname').val(claimantmname);
        modal.find('.modal-body input#claimantlname').val(claimantlname);
        
        modal.find('input#scr_id').val(scr_id);
        modal.find('input#voc_id').val(voc_id);
    });


});