GUIA = {};

$(function(){
	$('#btn-pdfs').click(function(event) {
		event.preventDefault();
		var select = oTable._('tr', {"filter":"applied"});
		for(var i in select) {
			if(select[i][1] != 0) {
				var dir = $(select[i][0]).attr('href')+'/pdf';
				window.open(dir);
			}
		}
	});

	$('#btn-reset').click(function(event) {
		event.preventDefault();

		$('#filtro-curso input[type="checkbox"]').each(function(){ this.checked = true; });
		$('#filtro-estado input[type="checkbox"]').each(function(){ this.checked = true; });
		$('#filtro-datos input[type="checkbox"]').each(function(){ this.checked = true; });
		
		$('#filtro-grado').val(-1).trigger('liszt:updated');
		$('#filtro-depto').val(-1).trigger('liszt:updated');

		oTable.fnDraw();
	});

	$.fn.dataTableExt.afnFiltering.push(
		function(oSettings, aData, iDataIndex) {
			if($(oSettings.nTable).attr('id')!=='tabla-todo')
				return true;

			var cursos = [];
			var estados = [];
			var cuatrimestres = [];

			var grado = $('#filtro-grado :selected');
			var depto = $('#filtro-depto :selected');

			$('#filtro-curso input[type="checkbox"]').each(function(index) {
				if($(this).is(':checked')) cursos.push(index+1);
			});

			$('#filtro-estado input[type="checkbox"]').each(function(index) {
				if($(this).is(':checked')) estados.push(index);
			});

			$('#filtro-datos input[type="checkbox"]').each(function(index) {
				if($(this).is(':checked')) cuatrimestres.push(index+1);
			});

			var curso = parseInt(aData[4]);
			var estado = parseInt($(aData[1]).children('option:selected').val());
			var cuatrimestre = parseInt(aData[5]);

			if(cursos.indexOf(curso)===-1) return false;
			if(estados.indexOf(estado)===-1) return false;
			if(cuatrimestres.indexOf(cuatrimestre)===-1) return false;


			if(grado.val()>-1)
				if(aData[3].indexOf(grado.text())===-1)return false;

			if(depto.val()>-1)
				if(aData[7].indexOf(depto.text())===-1)return false;

			return true;
		}
	);

	$('.set-estado').change(function() {
		var estado = parseInt($(this).children('option:selected').val())-1;
		var id = $(this).attr('data-guia');

		if(estado>0 && estado<5) {
			$.ajax({
				type:'POST',
				url: GUIA.dashboard+'guia/'+id+'/update',
				data: JSON.stringify({ estado: estado }),
				contentType : 'application/json',
				cache: false,

				error: function(data) {
					alert('No se han podido guardar los cambios');
				},
				success: function(data) {
					//pendiente
				}
			})
		}
	});

	$('#filtro-curso input[type="checkbox"]').change(function() { oTable.fnDraw(); });
	$('#filtro-estado input[type="checkbox"]').change(function() { oTable.fnDraw(); });
	$('#filtro-datos input[type="checkbox"]').change(function() { oTable.fnDraw(); });
	$('#filtro-datos select').chosen().change(function() { oTable.fnDraw(); });

	$('select[name="asignatura"]').chosen();

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

	$('#errores').dataTable({ oLanguage: idioma });
	$('#guias').dataTable({
		aaSorting: [[ 2, "asc" ]],
		oLanguage: idioma
	});

	var oTable = $('#tabla-todo').dataTable({
		aaSorting: [[ 3, "desc" ],[ 2, "desc" ]],
		oLanguage: idioma
	});
});