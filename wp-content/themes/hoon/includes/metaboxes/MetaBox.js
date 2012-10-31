jQuery(document).ready(function() {
/*-----------------------------------------------------------------------------------*/
/*	Tabbed Metabox's
/*-----------------------------------------------------------------------------------*/
	jQuery('.metabox-tabs li a').each(function(i) {
		var thisTab = jQuery(this).parent().attr('class').replace(/active /, '');

		if ( 'active' != jQuery(this).attr('class') )
			jQuery('div.' + thisTab).hide();
		
		jQuery('div.' + thisTab).addClass('tab-content');
 
		jQuery(this).click(function(){
			// hide all child content
			jQuery(this).parent().parent().parent().children('div').hide();
 
			// remove all active tabs
			jQuery(this).parent().parent('ul').find('li.active').removeClass('active');
 
			// show selected content
			jQuery(this).parent().parent().parent().find('div.'+thisTab).show();
			jQuery(this).parent().parent().parent().find('li.'+thisTab).addClass('active');
		});
	});

	jQuery('.heading').hide();
	jQuery('.metabox-tabs').show();
	
	
	
/*-----------------------------------------------------------------------------------*/
/*	Color Picker
/*-----------------------------------------------------------------------------------*/
	jQuery('.colorpicker-button').click( function(e) {
	    colorPicker = jQuery(this).next('div');
	    input = jQuery(this).prev().prev('input');
	    
	    if( '' == input.val() ) {
	    	input.val('#');
	    }
	    
	    jQuery(colorPicker).farbtastic(input);
	    colorPicker.show();
	    e.preventDefault();
	    jQuery(document).mousedown( function() {
	        jQuery(colorPicker).hide();
	    });
	});
	
	jQuery(document).mousedown( function() {
	    if( '#' == jQuery(this).prev().prev('input').val() ) {
	    	input.val('');
	    }
	});
	
	
	jQuery('.colorpicker-example').each( function() {
	    input = jQuery(this).prev('input');
		
		if( '' != input.val() && '#' != input.val() ) {
			inputColor = input.val()
			jQuery(this).css('background-color', inputColor );
		}
		
		jQuery(document).mousedown( function() {
	    	if( '#' == input.val() ) {
	    		input.val('');
	    	}
		});
		
		if( '#' == input.val() ) {
	        input.val('');
	    }
	});
    
    
});
