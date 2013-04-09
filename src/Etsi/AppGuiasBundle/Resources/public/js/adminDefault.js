$(function(){
	$('.temporal').delay(5000).fadeOut('slow');
	
	$('.column').equalHeight();

	$('.tablesorter').dataTable();

	$('.chosen-select').chosen();
});