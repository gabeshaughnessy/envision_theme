<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Hoon
 * @since 1.0
 */
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]><html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]><html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]><html <?php language_attributes(); ?> class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
<!--
**********************************************************************************************
	
Hoon (<?php echo VERSION ?>) - Designed and Built by Luke McDonald
	
**********************************************************************************************
-->
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1,<?php bloginfo( 'html_type' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	
	<title><?php wp_title(); ?></title>

	<?php wp_head() ?>
	
	<!--[if lt IE 9]>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/stylesheets/style-ie.css?ver=' . hoon_version_id(); ?>" />
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
</head>

<body id="top" <?php body_class(); ?> >
	
	<div id="branding" class="container clearfix">
		
		<header id="header" role="banner">
			<?php if ( 1 == hoon_option( 'top_search_form' ) ) :  ?>
			    <div id="top-search">
			    	<?php get_search_form(); ?>
			    </div>
			<?php endif; // end search form check ?>
		
			<?php  
			/**
			 * Primary Nav
			 *
			 */
			?>
			<nav id="primary-nav" role="navigation">
				<ul class="nav">
					<?php
		        	if ( has_nav_menu( 'primary-nav' ) ) :
		        		wp_nav_menu( array(
		        			'theme_location' => 'primary-nav',
		        			'container'      => '',
		        			'items_wrap'     => '%3$s'
		        		));
		        	else :
		        		printf( '<li><a href="%1$s" title="%2$s">%3$s</a></li>',
		        			esc_url( admin_url( 'nav-menus.php' ) ),
		        			esc_attr__( 'Click here to setup your custom menu.', 'hoon' ),
		        			esc_html__( 'Click here to setup your custom menu.', 'hoon' )
		        		);
		        	endif;
		        	?>
				</ul>
			</nav><!-- #primary-nav -->
			
		</header><!-- #header -->
	
	</div><!-- #branding -->
	
	<hgroup id="site-info" class="container" role="banner">
	    <?php
	    $blog_info = get_bloginfo( 'name' );
	    $logo_url = hoon_option( 'logo_url' );
	    $site_title_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>

	    <<?php echo $site_title_tag; ?> id="site-title" class="row">
	    	<a class="<?php echo ( $logo_url ) ? 'image-logo' : 'text-logo' ?> <?php echo esc_attr( hoon_main_column_width() ); ?>" href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_attr( $blog_info ); ?>" >
	    		<?php if ( $logo_url ) : ?>
	    			<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php esc_attr_e( 'Logo', 'hoon') ?>" />
	    		<?php else : ?>
	    			<?php echo esc_html( $blog_info ); ?>
	    		<?php endif; // end text logo check ?>
	    	</a>
	    </<?php echo $site_title_tag; ?>><!-- #site-title -->


	    <?php if( hoon_option( 'text_logo_desc' ) ) : ?>
	    	<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
	    <?php endif; ?>
	</hgroup><!-- .site-info -->
	
	<div id="main" class="container ">