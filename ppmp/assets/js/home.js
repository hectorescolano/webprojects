
$(function(){
	$("#loading").delay(500).fadeOut("slow");
	setInterval(function(){$('span#datetime').text(moment().format("LL LTS"))});
});
