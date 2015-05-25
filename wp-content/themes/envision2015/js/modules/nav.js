jQuery(document).ready(function($){
	$('.menu-icon-wrapper').on('click',  function(e){
		$('#primary.nav .menu-items').addClass('active');
		$('.menu-bg').addClass('active');
		$('#content').addClass('blur');
	});
	$('#primary.nav .menu-items').on('click',  function(e){
		$('#primary.nav .menu-items').removeClass('active');
		$('.menu-bg').removeClass('active');
		$('#content').removeClass('blur');
	});
	
	$('.menu-bg').on('click',  function(e){

		$('#primary.nav .menu-items').removeClass('active');
		$('.menu-bg').removeClass('active');
		$('#content').removeClass('blur');
	});
});