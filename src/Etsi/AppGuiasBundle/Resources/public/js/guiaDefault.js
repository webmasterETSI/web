GUIA = {};
GUIA.saveTimeout;


GUIA.cambios = function(elemento) {
	if(GUIA.saveTimeout)
		window.clearTimeout(GUIA.saveTimeout);
	GUIA.saveTimeout = window.setTimeout(GUIA.saveCambios, 5000);
}


GUIA.saveCambios = function() {
	var data = {};
	$('.cambios-no-guardados').each(function() {
		var e = $(this);
		if(e.hasClass('editor-minimo')) {
			data[e.attr('id')] = $(this).val();
		} else if(e.hasClass('editor-texto')) {
			data[e.attr('id')] = $(this).html();
		} else if(e.is('select[multiple]')) {
			var result = [];
			e.children(':selected').each(function() {
				result.push($(this).val());
			});
			data[e.attr('name')] = result;
		} else if(e.hasClass('editor-check-mask')) {
			var result = 0;

			e.children('input[type=checkbox]').each(function(index) {
				if($(this).is(':checked'))
					result |= 1<<index;
			});
			data[e.attr('id')] = result;
		} else if(e.is('tr')) {
			var semana = {
				numeroSemana: parseInt(e.find('.numero-semana').text().replace('#', '')),
				horasGruposGrandes: parseFloat(e.find('input[name=horasGruposGrandes]').val().replace(',', '.')),
				horasGruposReducidosAula: parseFloat(e.find('input[name=horasGruposReducidosAula]').val().replace(',', '.')),
				horasGruposReducidosInformatica: parseFloat(e.find('input[name=horasGruposReducidosInformatica]').val().replace(',', '.')), 
				horasGruposReducidosLaboratorio: parseFloat(e.find('input[name=horasGruposReducidosLaboratorio]').val().replace(',', '.')),
				horasGruposReducidosCampo: parseFloat(e.find('input[name=horasGruposReducidosCampo]').val().replace(',', '.')),
				examen: e.find('input[name=examen]').val(),
				observaciones: e.find('input[name=observaciones]').val()
			};

			if( !data.semanas ) data.semanas = [];
			data.semanas.push(semana);
		} else {
			console.log(e);
		}

		$(this).removeClass('cambios-no-guardados')
			.addClass('cambios-guardados');
	});

	window.setTimeout(function() {
		$('.cambios-guardados').removeClass('cambios-guardados');
	}, 5000);

	GUIA.updateData(data);

	if(GUIA.saveTimeout)
		window.clearTimeout(GUIA.saveTimeout);
}

GUIA.updateData = function(data) {
	$.ajax({
		type:'POST',
		url: GUIA.updateGuia,
		data: JSON.stringify(data),
		contentType : 'application/json',
		cache: false
	});
}


$(function(){
	// Calculo de créditos correctos
	$('#contenedor-creditos > input').bind('keyup', function() {
		$(this).val($(this).val().replace(',', '.'));
		var total = parseFloat($(this).val());
		$(this).siblings('input').each(function() {
			total += parseFloat($(this).val());
		});

		if( total != parseFloat($('#creditos-totales').text()) )
			$('#creditos-totales').addClass('error');
		else
			$('#creditos-totales').removeClass('error');
	}).
	first().trigger('keyup');


	// Configuración de autosalvado y edición en los respectivos campos
	$('select').chosen({no_results_text: "No se han encontrado resultados"});

	$('.editor-minimo').bind('keyup', function() {
		$(this).addClass('cambios-no-guardados').removeClass('cambios-guardados');
		GUIA.cambios($(this));
	});

	$('.editor-semana').bind('keyup', function() {
		var fila = $(this).closest('tr'); 
		fila.addClass('cambios-no-guardados').removeClass('cambios-guardados');
		GUIA.cambios(fila);
	});

	var data = $('#datosEspecificos_6_1_1 > .hidden').text();
	$('#datosEspecificos_6_1_1 > .hidden').remove();
	$('#datosEspecificos_6_1_1')
		.children('input[type=checkbox]')
		.click(function() {
			var padre = $(this).parent();
			padre.addClass('cambios-no-guardados').removeClass('cambios-guardados');
			GUIA.cambios(padre);
		})
		.each(function(index) {
			if(data&(1<<index))
				$(this).attr('checked','checked');
			else
				$(this).removeAttr('checked');
		});

	data = $('#datosEspecificos_9_1_1 > .hidden').text();
	$('#datosEspecificos_9_1_1 > .hidden').remove();
	$('#datosEspecificos_9_1_1')
		.children('input[type=checkbox]')
		.click(function() {
			var padre = $(this).parent();
			padre.addClass('cambios-no-guardados').removeClass('cambios-guardados');
			GUIA.cambios(padre);
		})
		.each(function(index) {
			if(data&(1<<index))
				$(this).attr('checked','checked');
			else
				$(this).removeAttr('checked');
		});
});

CKEDITOR.on( 'instanceCreated', function( e ) {
	var jElement = $(e.editor.element.$);

	jElement.focusout(function(){
		GUIA.cambios($(this));
	});

	jElement.bind('keyup', function(){
		$(this).addClass('cambios-no-guardados').removeClass('cambios-guardados');
	});
});
