GUIA = {};
GUIA.saveTimeout;

GUIA.cambios = function(elemento) {
	if(GUIA.saveTimeout)
		window.clearTimeout(GUIA.saveTimeout);
	GUIA.saveTimeout = window.setTimeout(GUIA.saveCambios, 5000);
};


GUIA.saveCambios = function(estado) {
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

	if(typeof estado === 'number') {
		data['estado'] = estado;
		var callback = function() {
			document.location.href = GUIA.dashboard;
		}
	}

	window.setTimeout(function() {
		$('.cambios-guardados').removeClass('cambios-guardados');
	}, 5000);

	GUIA.updateData(data,callback);

	if(GUIA.saveTimeout)
		window.clearTimeout(GUIA.saveTimeout);
};

GUIA.updateData = function(data, callback) {
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
		},
		complete: callback
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

	$('#total-aula').text(totales.pa);
	$('#total-campo').text(totales.pc);
	$('#total-clases').text(totales.t);
	$('#total-informatica').text(totales.pi);
	$('#total-laboratorio').text(totales.pl);

	var registrados = [0, 0, 0, 0, 0];
	$('#tabla-semanas tbody tr').each(function() {
		$(this).children('td').children('.mini').each(function(index) {
			registrados[index] += parseFloat($(this).val().replace(',', '.'));
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

	setError(1, registrados[0]!=totales.t);
	setError(2, registrados[1]!=totales.pa);
	setError(3, registrados[2]!=totales.pi);
	setError(4, registrados[3]!=totales.pl);
	setError(5, registrados[4]!=totales.pc);

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

	var contenedor = $(elemento).closest('.contenedor');
	if( total != parseFloat($('#creditos-totales').text()) ) {
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

	$('#button-enviar').click(    function() { GUIA.saveCambios(1); });
	$('#button-aprobar').click(   function() { GUIA.saveCambios(2); });
	$('#button-rechazar').click(  function() { GUIA.saveCambios(0); });
	$('#button-fallos').click(    function() { GUIA.saveCambios(3); });
	$('#button-corregida').click( function() { GUIA.saveCambios(2); });


	var guardarPaso = function(i) {
		var thisStep = $('#steps').find('.step').eq(i);

		thisStep.find('select').addClass('cambios-no-guardados').removeClass('cambios-guardados');
		thisStep.find('.editor-minimo').addClass('cambios-no-guardados').removeClass('cambios-guardados');
		thisStep.find('.editor-semana').addClass('cambios-no-guardados').removeClass('cambios-guardados');
		thisStep.find('.editor-texto').addClass('cambios-no-guardados').removeClass('cambios-guardados');
		thisStep.find('#datosEspecificos_6_1_1').addClass('cambios-no-guardados').removeClass('cambios-guardados');
		thisStep.find('#datosEspecificos_9_1_1').addClass('cambios-no-guardados').removeClass('cambios-guardados');

		GUIA.saveCambios();
	};


	$('#siguiente').click(function() {
		var currentSelected = $('.navigation .selected');
		guardarPaso(currentSelected.index());
		currentSelected.next('li').children('a').trigger('click');
	});

	$('#anterior').click(function() {
		var currentSelected = $('.navigation .selected');
		guardarPaso(currentSelected.index());
		currentSelected.prev('li').children('a').trigger('click');
	});


	// Configuración de eventos de teclado
	$('.editor-semana').keydown(function(e) {
		var elem = $(this);
		var td = elem.parent();
		var tr = td.parent();
		switch(event.which) {
			case 37: td.prev().children('.editor-semana').focus(); break; //iz
			case 38: tr.prev().find('.editor-semana').eq(td.index()-1).focus(); break; //ar
			case 39: td.next().children('.editor-semana').focus(); break; //de
			case 13: e.preventDefault();
			case 40: tr.next().find('.editor-semana').eq(td.index()-1).focus(); break; //ab
		}
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
