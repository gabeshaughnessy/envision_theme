jQuery(document).ready(function($) {
	
	$('.type-post, .type-attachment, .type-page').each(function() {
		$this = $(this);
		
		id = $this.attr('id').replace('post-', '');
		
		get_post_rating($this, id);
		
		$this.find('.rate-up').click(function() {
			theObject = $(this);
			theID = $(this).data( 'post-id' );
						
			theObject.addClass( 'liked' );
			rate_up( theObject, theID );
			return false;
		});
	});
	
	function rate_up( post, id ) {
		$.post(like_it_up.ajaxurl,
			{
				'action' : 'rate_up',
				'post_id' : id
			}, function(response) {
				set_post_rating( post, response );
			}, 'text' );
	}
	
	function get_post_rating( post, id ) {
		$.post(like_it_up.ajaxurl,
		{
			'action' : 'get_post_rating',
			'post_id' : id
		}, function(response) {
			set_post_rating( post, response );
			post.find('.post-rating').text(response);
		}, 'text' );
	}
	
	function set_post_rating( post, rating ) {
		post.find('.post-rating').text(rating);
	}
});