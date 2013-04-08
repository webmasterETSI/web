var GUIA = {};

GUIA.api = 'http://127.0.0.1/etsi/web/app_dev.php/guia/1/';
GUIA.onDataHandler = {};
GUIA.saveTimeout;


GUIA.cambios = function(elemento) {
	elemento.addClass('cambios-no-guardados').removeClass('cambios-guardados');


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
		url: GUIA.api+'get',
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
		url: GUIA.api+'update',
		data: JSON.stringify(data),
		contentType : 'application/json',
		cache: false
	});
}

GUIA.init = (function() {
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
				//console.log('Función '+campo+': '+data);
				$('#'+campo).html(data);
			};
		})(genericos[i]);

/*
		'asignatura'

		'profesores',
		'datosEspecificos_4_1',
		'datosEspecificos_4_2',
		'datosEspecificos_9_2',
*/
	GUIA.getData(genericos);
})();


$(function(){
	GUIA.setAutocomplete(
		'#asignatura',
		'http://127.0.0.1/etsi/web/app_dev.php/asignatura/search/',
		function(dato) { return { value: dato.codigo+':'+dato.nombre, data: dato.id }; }
	);

	GUIA.setAutocomplete(
		'#datosEspecificos_4_1',
		'http://127.0.0.1/etsi/web/app_dev.php/competencia/search/',
		function(dato) { return { value: dato.codigo+':'+dato.nombre, data: dato.id }; }
	);

	GUIA.setAutocomplete(
		'#datosEspecificos_4_2',
		'http://127.0.0.1/etsi/web/app_dev.php/competencia/search/',
		function(dato) { return { value: dato.codigo+':'+dato.nombre, data: dato.id }; }
	);

	GUIA.setAutocomplete(
		'#profesor',
		'http://127.0.0.1/etsi/web/app_dev.php/profesor/search/',
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
	var editor = e.editor,
		element = editor.element;

	var jElement = $(element.$);

	if ( element.is( 'h1', 'h2', 'h3' ) || element.getAttribute( 'id' ) == 'taglist' ) {
		editor.on( 'configLoaded', function() {
			editor.config.removePlugins = 'colorbutton,find,flash,font,' +
				'forms,iframe,image,newpage,removeformat,' +
				'smiley,specialchar,stylescombo,templates';

			editor.config.toolbarGroups = [
				{ name: 'editing',		groups: [ 'basicstyles', 'links' ] },
				{ name: 'undo' },
				{ name: 'clipboard',	groups: [ 'selection', 'clipboard' ] },
				{ name: 'about' }
			];
		});
	} else if( jElement.hasClass('editor-minimo') ) {
		editor.on( 'configLoaded', function() {
			editor.config.removePlugins = 'colorbutton,find,flash,font,' +
				'forms,iframe,image,newpage,removeformat,' +
				'smiley,specialchar,stylescombo,templates';

			editor.config.toolbarGroups = [{ name: 'undo' }];
		});
	}

	jElement.bind('keyup', function(){
		GUIA.cambios(jElement);
	});
/*
	editor.on('contentDom',function() {
			e.editor.document.on('keyup', function(event) {
				//console.log($(event.sender.$.activeElement).attr('id'));
				GUIA.cambios($(event.sender.$.activeElement));
			}
		);
	});
*/
});
