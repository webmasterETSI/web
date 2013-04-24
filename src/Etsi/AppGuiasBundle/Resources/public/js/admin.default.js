$(function(){
	$('.temporal').delay(5000).hide('slow');

	$('.tablesorter').dataTable();
	$('.chosen-select').chosen();
	
	$('.column').equalHeight();

	$('.confirm').click(function(event) {
		if(confirm("¡Esta acción es permanente!, ¿seguro que quieres continuar?"))
			return true;

		return false;
	});
});