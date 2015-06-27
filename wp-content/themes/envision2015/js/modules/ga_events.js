//Google Analytics Custom Events
//ga('send', 'event', 'category', 'action', 'label', value);  // value is a number.

jQuery(document).ready(function($){
	$('.contact-submit').on('click', 'input[type="submit"]', function(e){
		ga('send', 'event', 'form submit', 'contact form', window.location, 0);
	});
	$('.profile-card').on('click', 'a', function(e){	
		ga('send', 'event', 'social profile visit', jQuery(this).attr('href'));
	});
});