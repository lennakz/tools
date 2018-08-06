$(window).on('load', function() {
	$('#loading-gif').fadeOut();
});

$(function() {
	
	// Loading gif
	$('#navigation a').on('click', function() {
		$('#loading-gif').fadeIn();
	});	
	$(document).on('pjax:send', function() { 
		$('#loading-gif').fadeIn();
	});
	$(document).on('pjax:complete', function() { 
		$('#loading-gif').fadeOut();
	});
});