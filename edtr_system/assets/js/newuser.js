$(function()
{

	


	$('#myModal').on('show.bs.modal', function (event) 
	{
  		var button = $(event.relatedTarget); // Button that triggered the modal

  		var userid = button.data('userid'); 
  		var userfname = button.data('userfname'); 
  		var userlname = button.data('userlname'); 


  		// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  		// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  		var modal = $(this);

  		modal.find('.modal-body input#userid').val(userid);
  		modal.find('.modal-body input#userfname').val(userfname);
  		modal.find('.modal-body input#userlname').val(userlname);
	});

  $('#myModalreset').on('show.bs.modal', function (event)
  {
      var button = $(event.relatedTarget); // Button that triggered the modal

      var resetid = button.data('resetid'); 
      var resetusername = button.data('resetusername'); 
      var resetname = button.data('resetname'); 


      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this);

      modal.find('.modal-body input#resetid').val(resetid);
      modal.find('.modal-body input#resetusername').val(resetusername);
      modal.find('.modal-body input#resetname').val(resetname);
    });





});