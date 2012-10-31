		<?php get_sidebar( 'footer' ); ?>
			
		<div class="row">
		    <footer id="footer" class="<?php echo esc_attr( hoon_main_column_width() ); ?>">
		    	
    	    	<div>
    	    	<?php if( ( $footer_text = hoon_option( 'footer_text' ) ) ) : ?>
    	    		<?php printf( __( '%s', 'hoon' ), strip_tags( $footer_text, '<b><strong><i><em><img><a><span>' ) ); ?>
    	    	<?php else : ?>
    	    		Theme: <a href="http://press75.com/theme-details/hoon/">Hoon</a><a href="http://wordpress.com/?ref=footer"><span class="sep"> | </span></a><a href="http://press75.com" rel="generator">by Press75.com</a>
    	    	<?php endif; ?>
    	    	</div>

		    </footer>
		</div>
		
	</div><!-- #Main -->	
	
	<?php wp_footer() ?>
	
   	<!-- <?php echo $wpdb->num_queries; ?> <?php _e( 'queries' ); ?>. <?php timer_stop( 1 ); ?> <?php _e( 'seconds' ); ?> -->
</body>
</html>