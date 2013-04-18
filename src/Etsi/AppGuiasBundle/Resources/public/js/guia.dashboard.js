$(function(){
	$('select').chosen({no_results_text: "No se han encontrado resultados"});
	$('.tablesorter').dataTable();

	var oTable = $('#tabla-todo').dataTable({ "aaSorting": [[ 3, "desc" ],[ 2, "desc" ]] });
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