<?php
/**
 * Custom Theme Styles
 *
 * Apply custom styling set via Theme Options and print in head.
 * This is called via a wp_head() filter in admin.php. This file
 * is here to help keep this rather long function out of the way.
 *
 * @package Hoon
 * @since 1.0
 */
add_action( 'wp_head', 'hoon_custom_styles' );

function hoon_custom_styles() {
$color_palette = hoon_style( 'color_palette' );

if ( 'custom' == $color_palette ) : ?>
<!-- custom theme styles -->	
<style type="text/css">
 	<?php
    $logo_color = hoon_style( 'logo_color' );
    $accent_color = hoon_style( 'accent_color' );
    
    $nav_background         = hoon_style( 'nav_background' );
    $nav_background_hover   = hoon_style( 'nav_background_hover' );
    $nav_border_color       = hoon_style( 'nav_border_color' );
    $nav_link_color         = hoon_style( 'nav_link_color' );
    $nav_link_color_hover   = hoon_style( 'nav_link_color_hover' );
    ?>
    
    /* HEADER */
    #branding {
    	<?php if ( isset( $nav_link_color ) ) { print 'color:' . $nav_link_color . ';'; } ?>
    	<?php if ( isset( $nav_background ) ) { print 'background-color:' . $nav_background . ';'; } ?>
    	<?php if ( isset( $nav_border_color ) ) { print 'border-bottom-color:' . $nav_border_color . ';'; } ?>
    }
    
    /* NAVIGATION */
    #primary-nav li a {
    	<?php if ( isset( $nav_link_color ) ) { print 'color:' . $nav_link_color . ';'; } ?>
    }
    
    #primary-nav li a:hover {
    	<?php if ( isset( $nav_link_color_hover ) ) { print 'color:' . $nav_link_color_hover . ';'; } ?>
    }
        
    #primary-nav ul ul ul {
    	<?php if ( isset( $accent_color ) ) { print 'color:' . $accent_color . ';'; } ?>
    }
    
    #primary-nav li:hover, #primary-nav a:hover, #primary-nav ul ul, 
    #primary-nav li .current-menu-item, #primary-nav li .current-menu-ancestor {
    	<?php if ( isset( $nav_background_hover ) ) { print 'background-color:' . $nav_background_hover . ';'; } ?>
    }
    
    #primary-nav ul ul, .section-meta .tabs a.active {
    	<?php if ( isset( $accent_color ) ) { print 'border-top-color:' . $accent_color . ';'; } ?>
    }
    
    #primary-nav ul ul ul {
    	<?php if ( isset( $accent_color ) ) { print 'border-left-color:' . $accent_color . ';'; } ?>
    }
    
    #primary-nav li:hover,
    #primary-nav .current-menu-item, #primary-nav .current-menu-ancestor {
    	<?php if ( isset( $accent_color ) ) { print 'border-bottom-color:' . $accent_color . ';'; } ?>
    }
    
    #primary-nav li {
    	<?php if ( isset( $nav_border_color ) ) { print 'border-bottom-color:' . $nav_border_color . ';'; } ?>
    }
    
    #primary-nav li:hover {
    	<?php if ( isset( $accent_color ) ) { print 'border-bottom-color:' . $accent_color . ';'; } ?>
    }
        

    /* LOGO */
    #site-title a,
    #site-title a:hover,
    #site-title a:visited,
    #site-description {
    	<?php if ( isset( $logo_color ) ) { print 'color:' . $logo_color . ';'; } ?>
    }
    

    /* LINK COLORS */
    a, a:hover, a:focus { 
    	<?php if ( isset( $accent_color ) ) { print 'color:' . $accent_color . ';'; } ?>
    }
    
    .entry-content ul.tabs li a.active {
    	<?php if ( isset( $accent_color ) ) { print 'border-bottom-color:' . $accent_color . ';'; } ?>
    }
    
    .related-meta .format-type, .button, button, input[type="submit"], #submit, .label,
    .button:hover, button:hover, button:focus, input[type="submit"]:hover {
    	<?php if ( isset( $accent_color ) ) { print 'background-color:' . $accent_color . ';'; } ?>
    }
    
    
	/* GLOBALS */
    /* Background */
    .accent, .jp-play-bar {
    	<?php if ( isset( $accent_color ) ) { print 'background-color:' . $accent_color . ';'; } ?>
    }
    
</style>
<?php endif; // end custom theme styles
}


/**
 * HEX to RGB
 *
 * $rgb = hex2rgb( '#cc0' );
 * print_r( $rgb ); 
 *
 * @param $hex Hexidecimal string, 3 or 6 characters
 * @param $return format to return, string or array
 * @return string or array
 * @since 1.0
 */
function hex2rgb( $hex = '', $return = 'string' ) {
	$hex = str_replace( '#', '', $hex );
	
	if(strlen($hex) == 3) {
	   $r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
	   $g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
	   $b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
	} else {
	   $r = hexdec( substr( $hex, 0, 2 ) );
	   $g = hexdec( substr( $hex, 2, 2 ) );
	   $b = hexdec( substr( $hex, 4, 2 ) );
	}
	$rgb = array( $r, $g, $b );
   
	switch ( $return ) {
   		case 'array':
			return $rgb; // returns the rgb values separated by commas
			break;
   		default:
			return implode( ',', $rgb ); // returns the rgb values separated by commas
			break;
	}
}


/**
 * RGB to HEX
 *
 * $rgb = array( 255, 255, 255 );
 * $hex = rgb2hex( $rgb );
 * echo $hex;
 *
 * @param $rgb Array of rgb values between 0 and 255
 * @return array
 * @since 1.0
 */
function rgb2hex( $rgb = array() ) {
	$hex = '#';
	$hex .= str_pad( dechex( $rgb[0] ), 2, '0', STR_PAD_LEFT );
	$hex .= str_pad( dechex( $rgb[1] ), 2, '0', STR_PAD_LEFT );
	$hex .= str_pad( dechex( $rgb[2] ), 2, '0', STR_PAD_LEFT );
	
	return $hex; // returns the hex value including the number sign (#)
}
?>