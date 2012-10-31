<?php
/* The footer widget area is triggered if any of the areas
 * have widgets. So let's check that first.
 *
 * If none of the sidebars have widgets, then let's bail early.
 */
if (   ! is_active_sidebar( 'sidebar-footer-1' )
    && ! is_active_sidebar( 'sidebar-footer-2' )
)
    return;
// If we get this far, we have widgets. Let do this.
?>

<div class="row">
    
    <section id="supplementary" class="<?php echo hoon_main_column_width(); ?>" role="complementary">
		
		<div class="row">
		
			<?php if ( is_active_sidebar( 'sidebar-footer-1' ) ) : ?>
			<div class="<?php echo esc_attr( hoon_footer_widget_area_class() ); ?> widget-area" role="complementary">
				<?php dynamic_sidebar( 'sidebar-footer-1' ); ?>
			</div><!-- #first .widget-area -->
			<?php endif; ?>
			
			<?php if ( is_active_sidebar( 'sidebar-footer-2' ) ) : ?>
			<div class="<?php echo esc_attr( hoon_footer_widget_area_class() ); ?> widget-area" role="complementary">
				<?php dynamic_sidebar( 'sidebar-footer-2' ); ?>
			</div><!-- #first .widget-area -->
			<?php endif; ?>
	
		</div>
    
    </section><!-- #supplementary -->

</div><!-- .row -->
