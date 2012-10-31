<?php if ( ! dynamic_sidebar( 'sidebar-widgets' ) ) : ?>
	<div class="section">
		<h2><?php _e( 'You Need to Configure Your Widgets:', 'hoon' ); ?></h2>
		
		<div class="content">
			<p><?php _e( 'Head over to your your ', 'hoon' ); ?><a href="<?php echo admin_url( '/widgets.php' ); ?>" title="WordPress admin"><?php _e( 'WordPress Admin', 'hoon' ); ?></a> <?php _e( 'and then click "Appearance" followed by "Widgets".', 'hoon' ); ?></p>
		</div>
	</div>
<?php endif; ?>
