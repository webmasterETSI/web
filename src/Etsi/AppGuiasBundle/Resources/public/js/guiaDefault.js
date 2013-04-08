var GUIA = {};

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
});

CKEDITOR.on( 'instanceCreated', function( event ) {
	var editor = event.editor,
		element = editor.element;

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
	}
});