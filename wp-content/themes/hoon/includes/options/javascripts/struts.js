jQuery(document).ready(function($) {

  	/**
  	 * Theme Style Options
  	 */
	jQuery("select#hoon_styles-color_palette").change(function () {
		var palette = $(this).val();
		
		if( 'custom' == palette ) {
			show_hide_custom_sections(true);
		} else {
			show_hide_custom_sections();
		}
		
		console.log( $(this).val() );
	}).change();
	
	function show_hide_custom_sections(shouldShow) {
  		var section_selector = '.appearance_page_hoon_styles .struts-section';
		var section_custom_ids = [ 1, 2 ]; // in terms of display position, with 0 being the first section
	
		jQuery.each(section_custom_ids, function() {
			if (shouldShow) {
				jQuery(section_selector + ':eq(' + this + ')').slideDown('fast');	
			} else {
				jQuery(section_selector + ':eq(' + this + ')').slideUp('fast')	
			}
		});
	}


  	/**
  	 * Image Upload Option
  	 */
	jQuery('.struts-image-upload').click(function() {
		formfield = jQuery(this).attr('data-field-id');
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		return false;
	});
	
	window.original_send_to_editor = window.send_to_editor;
	window.send_to_editor = function(html) {
		if(formfield) {
			source = jQuery(html).find('img').attr('src');
			jQuery('#'+formfield).val(source);
			tb_remove();
		}else{
			window.original_send_to_editor(html);
		}
	}
	
	
  	/**
  	 * Color Chooser Option
  	 */
	jQuery('.struts-color-chooser').each(function() {
		jQuery(this).farbtastic('#' + jQuery(this).attr('data-field-id'));
	});
	
	// hides as soon as the DOM is ready
	jQuery( 'div.struts-section-body' ).hide();
	// shows on clicking the noted link
	jQuery( 'div.struts-section h3' ).click(function() {
		jQuery(this).toggleClass("open");
		jQuery(this).next("div").slideToggle( 'fast' );
		return false;
	});
	
	jQuery('.struts-color-chooser').hide();
	jQuery( '.struts-color-chooser-toggle' ).click(function() {
		var colorchooser = jQuery(this).parent().next();
		
		colorchooser.toggle();
		
		if (colorchooser.is(':visible')) {
			jQuery(this).text('hide color picker');
		} else {
			jQuery(this).text('show color picker');
		}
		return false;
	});
  	
});