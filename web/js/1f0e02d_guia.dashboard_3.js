$(function(){
	var tutorial = introJs().setOptions({
		'skipLabel': 'Salir del tutorial',
		'nextLabel': 'Siguiente &raquo;',
		'prevLabel': '&laquo; Anterior',
		'doneLabel': 'Terminar'
	});

	$('#tutorial').click(function() {
		tutorial.start();
	});
	
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

	$('select').chosen();

	$('#errores').dataTable({ oLanguage: idioma });
	$('#guias').dataTable({
		aaSorting: [[ 2, "asc" ]],
		oLanguage: idioma
	});

	var oTable = $('#tabla-todo').dataTable({
		aaSorting: [[ 3, "desc" ],[ 2, "desc" ]],
		oLanguage: idioma
	});
	oTable.fnFilter( '2:', 1 );

	$('#filtro-enviar').click(    function() { oTable.fnFilter( '1:', 1 ); return false; });
	$('#filtro-fallos').click(    function() { oTable.fnFilter( '4:', 1 ); return false; });
	$('#filtro-aprobar').click(   function() { oTable.fnFilter( '2:', 1 ); return false; });
	$('#filtro-publicada').click( function() { oTable.fnFilter( '3:', 1 ); return false; });

	$('#filtro-todo').click( function() {
		var oSettings = oTable.fnSettings();
		for(iCol = 0; iCol < oSettings.aoPreSearchCols.length; iCol++)
			oSettings.aoPreSearchCols[ iCol ].sSearch = '';

		oTable.fnDraw();

		return false; 
	});
});