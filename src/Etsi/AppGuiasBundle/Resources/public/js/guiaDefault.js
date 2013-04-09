GUIA = {};
GUIA.onDataHandler = {};
GUIA.saveTimeout;


GUIA.cambios = function(elemento) {
	if(GUIA.saveTimeout)
		window.clearTimeout(GUIA.saveTimeout);
	GUIA.saveTimeout = window.setTimeout(GUIA.saveCambios, 5000);
}


GUIA.saveCambios = function() {
	var data = {};
	$('.cambios-no-guardados').each(function() {
		data[$(this).attr('id')] = $(this).hasClass('editor-minimo')?$(this).text():$(this).html();

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

GUIA.setAutocomplete = function(elemento, url, callback) {
	$(elemento).autocomplete({
		serviceUrl: url,
		paramName: null,
		autoSelectFirst: true,
		minChars: 3,
		transformResult: function(response) {
			//console.log(response);
			var data = JSON.parse(response);
			return {
				suggestions: ( function() {
					var ret = [];
					for(var d in data)
						ret.push(callback(data[d]));
					
					return ret;
				})()
			};
		}
	});
}

GUIA.onData = function(data) {
	//console.log(data);
	for(var i in data)
		if(GUIA.onDataHandler[i])
			GUIA.onDataHandler[i](data[i]);
}

GUIA.getData = function(campos) {
	$.ajax({
		type:'POST',
		url: GUIA.getGuia,
		data: JSON.stringify({'peticion': campos}),
		contentType : 'application/json',
		cache: false
	})
	.done(GUIA.onData)
	.fail(function() { alert("error"); });
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

GUIA.init = (function() {
	//HANDLERS PARA LA RECEPCIÓN DE DATOS

	//Datos a representar tal cual
	var genericos = [
		'creditosTeoricos', 
		'creditosPracticosAula',
		'creditosPracticosInformatica',
		'creditosPracticosLaboratorio',
		'creditosPracticosCampo',
		'estado',
		'fechaDeModificacion',
		'curso',
		'datosEspecificos_1_1',
		'datosEspecificos_1_2',
		'datosEspecificos_2_1',
		'datosEspecificos_2_2',
		'datosEspecificos_3',
		'datosEspecificos_6_1_2',
		'datosEspecificos_6_2',
		'datosEspecificos_7',
		'datosEspecificos_8_1',
		'datosEspecificos_8_2',
		'datosEspecificos_9_1_2',
		'datosEspecificos_10',
	];

	for(var i in genericos)
		GUIA.onDataHandler[genericos[i]] = (function(campo) {
			return function(data) {
				$('#'+campo).html(data);
			};
		})(genericos[i]);

	//id de asignatura -> datos de asignatura
	GUIA.onDataHandler['asignatura'] = function(id) {
		$.ajax({
			type:'GET',
			url: GUIA.getAsignatura+id,
			contentType : 'application/json',
			cache: false
		})
		.done(function(data) {
			console.log(data);
		});
	};

	//id de profesores -> datos de profesores
	GUIA.onDataHandler['profesores'] = function(data) {
		for(var i in data) {
			$.ajax({
				type:'GET',
				url: GUIA.getProfesor+data[i],
				contentType : 'application/json',
				cache: false
			})
			.done(function(data) {
				console.log(data);
			});
		}
	};

	//id de competencias -> datos de competencias
	GUIA.onDataHandler['datosEspecificos_4_1'] = function(data) {
		for(var i in data) {
			$.ajax({
				type:'GET',
				url: GUIA.getCompetencia+data[i],
				contentType : 'application/json',
				cache: false
			})
			.done(function(data) {
				console.log(data);
			});
		}
	};

	//id de competencias -> datos de competencias
	GUIA.onDataHandler['datosEspecificos_4_2'] = function(data) {
		for(var i in data) {
			$.ajax({
				type:'GET',
				url: GUIA.getCompetencia+data[i],
				contentType : 'application/json',
				cache: false
			})
			.done(function(data) {
				console.log(data);
			});
		}
	};

	//id de semanas -> datos de semanas
	GUIA.onDataHandler['datosEspecificos_9_2'] = function(data) {
		for(var i in data) {
			$.ajax({
				type:'GET',
				url: GUIA.getSemanas+data[i],
				contentType : 'application/json',
				cache: false
			})
			.done(function(data) {
				console.log(data);
			});
		}
	};

	//datos enmascarados numericamente
	GUIA.onDataHandler['datosEspecificos_6_1_1'] = function(data) {
		$('#datosEspecificos_6_1_1')
			.children('input[type=checkbox]')
			.each(function(index) {
				if(data&(index+1))
					$(this).attr('checked','checked');
				else
					$(this).removeAttr('checked');
			});
	};

	//datos enmascarados numericamente
	GUIA.onDataHandler['datosEspecificos_9_1_1'] = function(data) {
		$('#datosEspecificos_9_1_1')
			.children('input[type=checkbox]')
			.each(function(index) {
				if(data&(1<<index))
					$(this).attr('checked','checked');
				else
					$(this).removeAttr('checked');
			});
	};

	GUIA.getData(genericos);
	GUIA.getData([
		'asignatura',
		'profesores',
		'datosEspecificos_4_1',
		'datosEspecificos_4_2',
		'datosEspecificos_9_2',
		'datosEspecificos_6_1_1',
		'datosEspecificos_9_1_1'
	]);
});


$(function(){
	GUIA.setAutocomplete(
		'#asignatura',
		GUIA.asignaturaSearch,
		function(dato) { return { value: dato.codigo+':'+dato.nombre, data: dato.id }; }
	);

	GUIA.setAutocomplete(
		'#datosEspecificos_4_1',
		GUIA.competenciaSearch,
		function(dato) { return { value: dato.codigo+':'+dato.nombre, data: dato.id }; }
	);

	GUIA.setAutocomplete(
		'#datosEspecificos_4_2',
		GUIA.competenciaSearch,
		function(dato) { return { value: dato.codigo+':'+dato.nombre, data: dato.id }; }
	);

	GUIA.setAutocomplete(
		'#profesor',
		GUIA.profesorSearch,
		function(dato) { return { value: dato.nombre+', '+dato.email, data: dato.id }; }
	);


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
		if(paso.next().hasClass('pasos')) {
			paso.hide();
			paso.next().show();

			paso.next().children('.editor-texto, .editor-minimo')
				.not('div[contenteditable="true"]')
				.each(function() {
					$(this).attr('contenteditable', 'true');
					CKEDITOR.inline($(this).attr('id'));
				});
		}
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
