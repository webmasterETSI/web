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
			data[e.attr('id')] = $(this).text()
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

			e.children('input[type=checkbox]:checked').each(function() {
				result |= 1<<$(this).index();
			});
			data[e.attr('id')] = result;
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
	var pasos = $('.pasos');
	pasos.hide();
	pasos.first().show();

	$('#anterior').click(function() {
		var paso = $('.pasos:visible');
		if(paso.prev().hasClass('pasos')) {
			paso.hide();
			paso.prev().show();
		}
	});

	$('#siguiente').click(function() {
		var paso = $('.pasos:visible');
		var siguiente = paso.next();
		if(siguiente.hasClass('pasos')) {
			paso.hide();
			siguiente.show();

			siguiente.children('select')
				.chosen({no_results_text: "No se han encontrado resultados"})
				.change(function() {
					$(this).addClass('cambios-no-guardados')
						.removeClass('cambios-guardados');
				})
				.focusout(function(){
					GUIA.cambios($(this));
				});
			
			siguiente.children('.editor-texto, .editor-minimo')
				.not('div[contenteditable="true"]')
				.each(function() {
					$(this).attr('contenteditable', 'true');
					CKEDITOR.inline($(this).attr('id'));
				});
		}
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
	var editor = e.editor;
	var jElement = $(editor.element.$);

	if( jElement.hasClass('editor-minimo') ) {
		editor.on( 'configLoaded', function() {
			editor.config.removePlugins = 'colorbutton,find,flash,font,' +
				'forms,iframe,image,newpage,removeformat,' +
				'smiley,specialchar,stylescombo,templates';

			editor.config.toolbarGroups = [{ name: 'undo' }];
		});
	}

	jElement.focusout(function(){
		GUIA.cambios($(this));
	});

	jElement.bind('keyup', function(){
		$(this).addClass('cambios-no-guardados').removeClass('cambios-guardados');
	});
});
