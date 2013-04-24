;(function ( $, window, document, undefined ) {
	var pluginName = 'miniaturiza',
		defaults = {
			ePasos: ".step",
			eLienzo: ".miniatura",
			eEsquema: ".contenedor"
		};

	function Plugin( element, options ) {
		this.element = element;
		this.options = $.extend( {}, defaults, options) ;
		
		this._defaults = defaults;
		this._name = pluginName;
		
		this.init();
	}

	Plugin.prototype = {
		init: function () {
			var o = this.options;

			$(this.element).children('li').each(function(index) {
				var contenedor = $(this).find(o.eLienzo);
				var w = contenedor.width();
				var h = contenedor.height();

				var canvas = $('<canvas>');
				var ctx = canvas[0].getContext('2d');

				canvas.attr('width', w);
				canvas.attr('height', h);

				var paso = $(o.ePasos).eq(index);
				var hAnterior = 0;
				var hTotal = 0

				paso.find(o.eEsquema).each(function(index) {
					hTotal += $(this).height();
				});

				paso.find(o.eEsquema).each(function(index) {
					var hPorcentual = $(this).height()/hTotal;
					var hNew = hPorcentual*h;

					ctx.beginPath();
					ctx.rect(2, hAnterior+2, w-4, hNew-4);
					ctx.fillStyle = $(this).hasClass('empty')?'rgba(255,0,0,.1)':'rgba(0,0,0,.1)';
					ctx.fill();
					ctx.closePath();

					hAnterior += hNew;
				});

				contenedor.append(canvas);
			});
		},

		refresh: function () {
			var o = this.options;

			$(this.element).children('li').each(function(index) {
				var contenedor = $(this).find(o.eLienzo);
				var w = contenedor.width();
				var h = contenedor.height();

				var canvas = contenedor.children('canvas');
				var ctx = canvas[0].getContext('2d');
				ctx.clearRect(0, 0, w, h);

				var paso = $(o.ePasos).eq(index);
				var hAnterior = 0;
				var hTotal = 0

				paso.find(o.eEsquema).each(function(index) {
					hTotal += $(this).height();
				});

				paso.find(o.eEsquema).each(function(index) {
					var hPorcentual = $(this).height()/hTotal;
					var hNew = hPorcentual*h;

					ctx.beginPath();
					ctx.rect(2, hAnterior+2, w-4, hNew-4);
					ctx.fillStyle = $(this).hasClass('empty')?'rgba(255,0,0,.1)':'rgba(0,0,0,.1)';
					ctx.fill();
					ctx.closePath();

					hAnterior += hNew;
				});
			});
		}
	};

	$.fn[pluginName] = function ( options ) {
		return this.each(function () {
			var plugin = $.data(this, 'plugin_' + pluginName);
			if (!plugin) {
				$.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
			} else {
				if(plugin[options]) return plugin[options]();
			}
		});
	}
})( jQuery, window, document );
