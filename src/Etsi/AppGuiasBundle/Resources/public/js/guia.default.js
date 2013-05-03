$(function(){
	$('.temporal').delay(5000).hide('slow');


	$('#feedback').click(function() {
		$('#opinion').toggle();
	});

	$('#opinion').on('mouseleave', function() {
		$(this).hide();
	});

	$('#opinion').on('submit', function() {
		var form = $(this);
		var action = form.attr('action');
		var method = form.attr('method');

		var data = {};
		data.tipo = form.children('input[type="radio"]:checked').val();
		data.contenido = form.children('textarea').val();

		$(this).children('img').show();
		$.ajax({
			type: method,
			url: action,
			data: JSON.stringify(data),
			contentType : 'application/json',
			cache: false,

			error: function(data) {
				var error = $('<h4></h4>')
					.addClass('alert_error')
					.text('Algo va mal... intentalo nuevamente más tarde')
					.delay(5000).hide('slow');

				$('#wrapper').prepend(error);
			},
			success: function(data) {
				var info = $('<h4></h4>')
					.addClass('alert_info')
					.text('¡Gracias por tu opinión!')
					.delay(5000).hide('slow');

				$('#wrapper').prepend(info);
			},
			complete: function() {
				form.hide();
				form.children('img').hide();				
			}
		})

		return false;
	});
});