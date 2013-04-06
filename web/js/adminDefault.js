$(function(){
	$('.temporal').delay(5000).fadeOut('slow');


	$('.tablesorter').tablesorter(); 

	$('.tab_content').hide();
	$('ul.tabs li:first').addClass('active').show();
	$('.tab_content:first').show();

	$('ul.tabs li').click(function() {
		$('ul.tabs li').removeClass('active');
		$(this).addClass('active');
		$('.tab_content').hide();

		var activeTab = $(this).find('a').attr('href');
		$(activeTab).fadeIn();
		return false;
	});

	$('.column').equalHeight();
});