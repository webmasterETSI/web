$(function(){
	var idioma = {
		"sProcessing": "Procesando...",
		"sLengthMenu": "Mostrar _MENU_ registros",
		"sZeroRecords": "No se encontraron resultados",
		"sInfo": "Mostrando desde _START_ hasta _END_ de _TOTAL_ registros",
		"sInfoEmpty":	"Mostrando desde 0 hasta 0 de 0 registros",
		"sInfoFiltered": "(filtrado de _MAX_ registros en total)",
		"sInfoPostFix":  "",
		"sSearch": "Buscar:",
		"sUrl": "",
		"oPaginate": {
			"sFirst": "Primero",
			"sPrevious": "Anterior",
			"sNext": "Siguiente",
			"sLast": "Último"
		}
	}

	$('.temporal').delay(5000).hide('slow');

	$('.tablesorter').dataTable({ oLanguage: idioma });
	$('.chosen-select').chosen();
	
	$('.column').equalHeight();

	$('.confirm').click(function(event) {
		if(confirm("¡Esta acción es permanente!, ¿seguro que quieres continuar?"))
			return true;

		return false;
	});
});