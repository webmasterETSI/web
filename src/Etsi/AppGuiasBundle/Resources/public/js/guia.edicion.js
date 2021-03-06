GUIA = {};
GUIA.saveTimeout;

GUIA.cambios = function(elemento) {
	if(GUIA.saveTimeout)
		window.clearTimeout(GUIA.saveTimeout);
	GUIA.saveTimeout = window.setTimeout(GUIA.saveCambios, 5000);
};


GUIA.saveCambios = function() {
	var data = {};
	$('.cambios-no-guardados').each(function() {
		var e = $(this);
		if(e.hasClass('editor-minimo')) {
			data[e.attr('id')] = $(this).val();
		} else if(e.hasClass('editor-texto')) {
			data[e.attr('id')] = CKEDITOR.instances[e.attr('id')].getData();
		} else if(e.is('select[multiple]')) {
			var result = [];
			e.children(':selected').each(function() {
				result.push($(this).val());
			});
			data[e.attr('name')] = result;
		} else if(e.is('select')) {
			data[e.attr('name')] = e.children(':selected').val();
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
};

GUIA.updateData = function(data) {
	$.ajax({
		type:'POST',
		url: GUIA.updateGuia,
		data: JSON.stringify(data),
		contentType : 'application/json',
		cache: false,

		error: function(data) {
			$('<h4></h4>')
			.addClass('alert_error')
			.text(data.responseText)
			.appendTo('#alert-block')
			.delay(5000).hide('slow');
		},
		success: function(data) {
			$('<h4></h4>')
			.addClass('alert_success')
			.text('Cambios guardados correctamente')
			.appendTo('#alert-block')
			.delay(5000).hide('slow');
		}
	})
};

GUIA.testSemanas = function() {
	var totales = {
		t:  parseFloat($('#creditosTeoricos').val().replace(',', '.'))*10,
		pa: parseFloat($('#creditosPracticosAula').val().replace(',', '.'))*10,
		pc: parseFloat($('#creditosPracticosCampo').val().replace(',', '.'))*10,
		pi: parseFloat($('#creditosPracticosInformatica').val().replace(',', '.'))*10,
		pl: parseFloat($('#creditosPracticosLaboratorio').val().replace(',', '.'))*10
	};

	$('#total-aula').text(totales.pa.toFixed(2));
	$('#total-campo').text(totales.pc.toFixed(2));
	$('#total-clases').text(totales.t.toFixed(2));
	$('#total-informatica').text(totales.pi.toFixed(2));
	$('#total-laboratorio').text(totales.pl.toFixed(2));

	var registrados = [0, 0, 0, 0, 0];
	
	var ultimaFila = $('#tabla-semanas tbody tr:last-child');

	$('#tabla-semanas tbody tr').each(function() {
		$(this).children('td').children('.mini').each(function(index) {
			if(isNaN($(this).val().replace(',', '.'))) $(this).val(0);
			registrados[index] += parseFloat($(this).val().replace(',', '.')) || 0;
		});
	});

	var errores = false;
	function setError(index, er) {
		if(er) {
			errores = true;
			$('#tabla-semanas tfoot tr td').eq(index).addClass('error');
		} else 
			$('#tabla-semanas tfoot tr td').eq(index).removeClass('error');
	}

	setError(1, registrados[0].toFixed(2)!=totales.t.toFixed(2));
	setError(2, registrados[1].toFixed(2)!=totales.pa.toFixed(2));
	setError(3, registrados[2].toFixed(2)!=totales.pi.toFixed(2));
	setError(4, registrados[3].toFixed(2)!=totales.pl.toFixed(2));
	setError(5, registrados[4].toFixed(2)!=totales.pc.toFixed(2));

	var contenedor = $('#tabla-semanas').closest('.contenedor');
	if(errores) contenedor.addClass('empty');
	else contenedor.removeClass('empty');

	$('.navigation > ul').miniaturiza('refresh');
};

GUIA.testText = function(elemento) {
	var contenedor = $(elemento).closest('.contenedor');
	if(elemento.text() == "") contenedor.addClass('empty');
	else contenedor.removeClass('empty');
	
	$('.navigation > ul').miniaturiza('refresh')
};

GUIA.testInput = function(elemento) {
	var contenedor = $(elemento).closest('.contenedor');
	if(elemento.val() == "") contenedor.addClass('empty');
	else contenedor.removeClass('empty');
	
	$('.navigation > ul').miniaturiza('refresh')
};

GUIA.testSelect = function(elemento) {
	var contenedor = $(elemento).closest('.contenedor');
	if(elemento.children(':selected').length == 0) contenedor.addClass('empty');
	else contenedor.removeClass('empty');

	$('.navigation > ul').miniaturiza('refresh')
};

GUIA.testCheckbox = function(elemento) {
	var contenedor = $(elemento).closest('.contenedor');
	if(elemento.children('input[type=checkbox]:checked').length == 0) contenedor.addClass('empty');
	else contenedor.removeClass('empty');

	$('.navigation > ul').miniaturiza('refresh')
};

GUIA.testCreditos = function(elemento) {
	$(elemento).val($(elemento).val().replace(',', '.'));
	var total = parseFloat($(elemento).val());
	$(elemento).siblings('input').each(function() {
		total += parseFloat($(this).val());
	});
	total =Math.round(total*100)/100;

	var contenedor = $(elemento).closest('.contenedor');
	if( parseFloat(total).toFixed(2) != parseFloat($('#creditos-totales').text()).toFixed(2) ) {
		contenedor.addClass('empty');
		$('#creditos-totales').addClass('error');
	} else {
		contenedor.removeClass('empty');
		$('#creditos-totales').removeClass('error');
	}
	
	$('.navigation > ul').miniaturiza('refresh')
};

$(function(){
	// Calculo de créditos correctos
	$('#contenedor-creditos > input').bind('keyup', function() {
		GUIA.testCreditos($(this));
		GUIA.testSemanas();
	}).
	first().trigger('keyup');


	// Configuración de autosalvado y edición en los respectivos campos
	$('select').chosen({no_results_text: "No se han encontrado resultados"})
		.change(function() {
			$(this).addClass('cambios-no-guardados').removeClass('cambios-guardados');
			GUIA.cambios($(this));
			GUIA.testSelect($(this));

			if($(this).attr('name') == 'profesores') {
				var coordinadores = $('select[name="coordinador"]');
				var selectedId = coordinadores.children('option:selected').val();

				coordinadores.children('option[value!="-1"]').remove();

				$(this).children('option:selected').each(function() {
					var prof = $(this);
					var opc = $('<option></option>')
						.val(prof.val())
						.text(prof.text())
						.appendTo(coordinadores);

					if(selectedId==prof.val())
						opc.attr('selected','true');
				});
				coordinadores.trigger("liszt:updated");
			}
		}).each(function () {
			var resize = function () {
				var currentSelected = $('.navigation .selected').index();
				var shortHeight = $('#steps').find('.step').eq(currentSelected).height();
				var fullHeight = shortHeight+240;
				var newHeight = $('#steps').height()<fullHeight?fullHeight:shortHeight;

				$('#steps').css('height', newHeight);
			};

			$(this).on('liszt:showing_dropdown', resize);
			$(this).on('liszt:hiding_dropdown', resize);
		});

	$('.editor-minimo').bind('keyup', function() {
		$(this).addClass('cambios-no-guardados').removeClass('cambios-guardados');
		GUIA.cambios($(this));
	});

	$('#nombreI').bind('keyup', function() {
		GUIA.testInput($(this));
	});

	$('.editor-semana').bind('keyup', function() {
		var fila = $(this).closest('tr'); 
		fila.addClass('cambios-no-guardados').removeClass('cambios-guardados');
		GUIA.cambios(fila);
		GUIA.testSemanas();
	});

	var data = $('#datosEspecificos_6_1_1 > .hidden').text();
	$('#datosEspecificos_6_1_1 > .hidden').remove();
	$('#datosEspecificos_6_1_1')
		.children('input[type=checkbox]')
		.click(function() {
			var padre = $(this).parent();
			padre.addClass('cambios-no-guardados').removeClass('cambios-guardados');
			GUIA.cambios(padre);
			GUIA.testCheckbox(padre);
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
			GUIA.testCheckbox(padre);
		})
		.each(function(index) {
			if(data&(1<<index))
				$(this).attr('checked','checked');
			else
				$(this).removeAttr('checked');
		});


	// Configuración de miniaturas
	$('.navigation > ul').miniaturiza();

	$('form').submit(function() { return false; });

	$('#button-descargar-pdf').click(function() { window.open($(this).attr('ref'), '_blank'); });


	var guardarPaso = function(i) {
		var thisStep = $('#steps').find('.step').eq(i);

		thisStep.find('select').addClass('cambios-no-guardados').removeClass('cambios-guardados');
		thisStep.find('.editor-minimo').addClass('cambios-no-guardados').removeClass('cambios-guardados');
		thisStep.find('.editor-semana').addClass('cambios-no-guardados').removeClass('cambios-guardados');
		thisStep.find('.editor-texto').addClass('cambios-no-guardados').removeClass('cambios-guardados');
		thisStep.find('#datosEspecificos_6_1_1').addClass('cambios-no-guardados').removeClass('cambios-guardados');
		thisStep.find('#datosEspecificos_9_1_1').addClass('cambios-no-guardados').removeClass('cambios-guardados');


		if(i==0 && $('#creditos-totales').hasClass('error')) {
			$('<h4></h4>')
			.addClass('alert_warning')
			.text('Los créditos de la asignatura no coinciden con la suma total de los créditos indicados')
			.appendTo('#alert-block')
			.delay(4000).hide('slow');
		}
		GUIA.saveCambios();
	};

	$('.navigation').click(function() {
		var currentSelected = $('.navigation .selected').index();
		if(currentSelected==10){
			$('#siguiente').text('ENVIAR');
			$('#guardar').hide();
		}
		else {
			$('#siguiente').html('SIGUIENTE &raquo;');
			$('#guardar').show();
		}
	});

	$('#siguiente').click(function() {
		var currentSelected = $('.navigation .selected');
		if(currentSelected.index()==0 && $('#creditos-totales').hasClass('error')) {
			$('<h4></h4>')
			.addClass('alert_warning')
			.text('Los créditos de la asignatura no coinciden con la suma total de los créditos indicados')
			.appendTo('#alert-block')
			.delay(4000).hide('slow');
		}
		guardarPaso(currentSelected.index());

		if(currentSelected.index()==10) {
			alert('Guía guardada correctamente.\nPodrá realizar modificaciones y enviarlas hasta la fecha indicada por la Subdirección de Ordenación Académica.');
			document.location.href = GUIA.dashboard;
		}
		else {
			currentSelected.next('li').children('a').trigger('click');
		}
	});

	$('#anterior').click(function() {
		var currentSelected = $('.navigation .selected');
		guardarPaso(currentSelected.index());
		currentSelected.prev('li').children('a').trigger('click');
	});

	$('#guardar').click(function() {
		var currentSelected = $('.navigation .selected');
		guardarPaso(currentSelected.index());
	});

	// Configuración de eventos de teclado
	$('.editor-semana').keydown(function(event) {
		var elem = $(this);
		var td = elem.parent();
		var tr = td.parent();
		switch(event.which) {
			case 37: td.prev().children('.editor-semana').focus(); break; //iz
			case 38: tr.prev().find('.editor-semana').eq(td.index()-1).focus(); break; //ar
			case 39: td.next().children('.editor-semana').focus(); break; //de
			case 40: tr.next().find('.editor-semana').eq(td.index()-1).focus(); break; //ab
			case 13: event.preventDefault();
		}
	});

	$(document).keydown(function(event) {
		var focusSecuence = {
			'creditosPracticosInformatica': '#nombreI',
			'datosEspecificos_1_2': '#datosEspecificos_1_1',
			'datosEspecificos_2_2': '#datosEspecificos_2_1',
			'datosEspecificos_3':   '#datosEspecificos_3',
			'datosEspecificos_4_2': '#datosEspecificos_4_1',
			'datosEspecificos_6_2': '#datosEspecificos_6_1_2',
			'datosEspecificos_7':   '#datosEspecificos_7',
			'datosEspecificos_8_2': '#datosEspecificos_8_1',
			'datosEspecificos_9_2': '#datosEspecificos_9_1_2',
			'datosEspecificos_7':   '#datosEspecificos_7',
			'datosEspecificos_7':   '#datosEspecificos_7',
			'datosEspecificos_7':   '#datosEspecificos_7',
			'datosEspecificos_7':   '#datosEspecificos_7',
			'tabla-ultimo':         '#tabla-primero',
		}

		var id = $('*:focus').attr('id')||$('*:focus').closest('.chzn-container').prev().attr('name');

		if(event.which == 13 || (event.which == 9 && focusSecuence[id]) )
			event.preventDefault();
		
		if(event.which == 9 && focusSecuence[id]) 
			$(focusSecuence[id]).focus();
	});

	// Configuración de tutorial
	var timer;
	var tutorial = introJs().setOptions({
		'skipLabel': 'Salir del tutorial',
		'nextLabel': 'Siguiente &raquo;',
		'prevLabel': '&laquo; Anterior',
		'doneLabel': 'Terminar'
	});

	tutorial.onexit(function() {
		$('#tutorial').one('click', startTutorial);
		$('.navigation').find('li').eq(0).children('a').trigger('click');
	});

	function startTutorial() {$("input").blur();
		$('.navigation').find('li').first().children('a').trigger('click');
		tutorial.goToStep(4).start();

		if(timer) clearTimeout(timer);
	}
	$('#tutorial').one('click', startTutorial);

	tutorial.onchange(function(elemento) {
		var e = $(elemento);

		if(e.attr('id') === 'total-clases') {
			if($('.navigation .selected').index() != 9) {
				$('.navigation').find('li').eq(9).children('a').trigger('click');
				if(timer) clearTimeout(timer);
				timer = setTimeout(function() { tutorial.goToStep(9) }, 500);
			}
		} else if(e.attr('id') === 'contenedor-validacion') {
			if($('.navigation .selected').index() != 10) {
				$('.navigation').find('li').eq(10).children('a').trigger('click');
				if(timer) clearTimeout(timer);
				timer = setTimeout(function() { tutorial.goToStep(10) }, 500);
			}
		} else if(e.attr('id') === 'contenedor-creditos') {
			if($('.navigation .selected').index() != 0) {
				$('.navigation').find('li').eq(0).children('a').trigger('click');
				if(timer) clearTimeout(timer);
				timer = setTimeout(function() { tutorial.goToStep(8) }, 500);
			}
		}
	});
});

CKEDITOR.on( 'instanceCreated', function( e ) {
	var jElement = $(e.editor.element.$);

	jElement.focusout(function(){
		GUIA.cambios($(this));
	});

	jElement.bind('keyup', function(){
		$(this).addClass('cambios-no-guardados').removeClass('cambios-guardados');
		GUIA.testText($(this));
	});
});
