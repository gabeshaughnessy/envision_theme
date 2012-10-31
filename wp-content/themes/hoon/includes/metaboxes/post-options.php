<?php 
/**
 * WPAlchemy MediaAccess Class
 *
 * This class provides the functionality necessary
 * to upload media. This is used to upload a custom
 * background image for a post. This image is then 
 * used over a featured image in the hero slider
 * on the home page.
 *
 * @since 1.0
 */

global $wpalchemy_media_access;

// List template files
// Used to determine if certain options should show
$template_files = array(
	'template-audio.php',
	'template-blog.php',
	'template-galleries.php',
	'template-images.php',
	'template-images-galleries.php',
	'template-videos.php'
);

/* Get current page template file, if it exists */
$template_file = get_post_meta( get_the_ID(), '_wp_page_template', true );

/* Category Options Var */
$show_template_options = in_array( $template_file, $template_files ) ? true : false;

/* Show columns option */
$show_columns_option = 'template-blog.php' != $template_file ? true : false;

/* Set styles option to false if the Theme Options is using a image logo */
$show_styles_options = hoon_option( 'logo_url' ) ? false : true;
?>

<div id="hoon-post-options" class="hoon-metabox">

	<div class="metabox-tabs-div">
	  
		<ul class="metabox-tabs" id="metabox-tabs">
			<li class="active tab1"><a class="active" href="javascript:void(null);"><?php _e( 'Background', 'hoon' ); ?></a></li>
			
			<?php if( $show_styles_options ) : ?>
			<li class="tab2"><a href="javascript:void(null);"><?php _e( 'Styles', 'hoon' ); ?></a></li>
			<?php endif; ?>
			
			<?php if( $show_template_options ) : ?>
				<li class="tab3"><a href="javascript:void(null);"><?php _e( 'Content', 'hoon' ); ?></a></li>
			<?php endif; ?>
		</ul>
		
		<div class="tab1">
			<h4 class="heading"><?php _e( 'Background Options', 'hoon' ); ?></h4>
			<p>
				<?php $mb->the_field( 'background_image' ); ?>
				<?php $wpalchemy_media_access->setGroupName( 'n' . $mb->get_the_index() )->setInsertButtonLabel( 'Insert Background Image' ); ?>
				<?php echo $wpalchemy_media_access->getField( array( 'name' => $mb->get_the_name(), 'value' => $mb->get_the_value(), 'style' => 'width: 84%', 'placeholder' => __( 'Background Image', 'hoon' ) ) ); ?>
				<?php echo $wpalchemy_media_access->getButton( array( 'label' => '+', 'class' => 'media-access-button' ) ); ?>
			</p>
			
			<?php if( $mb->get_the_value( 'background_image' ) ) : ?>
				<h4><?php _e( 'Custom Background Image Preview', 'hoon' ); ?></h4>
				<p>
					<?php  
					printf(
						'<a href="%1$s" title="%2$s" target="_blank"><img src="%3$s" alt="%2$s" style="max-width: 238px; height: auto"/></a>',
						esc_url( $mb->get_the_value() ),
						esc_attr__( 'Background image preview', 'hoon' ),
						esc_url( $mb->get_the_value() )
					);
					?>
				</p>
			<?php endif; // end custom background image check ?>
			
 			<?php $mb->the_field( 'background_color' ); ?>
			<input class="colorpicker-color" type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" placeholder="Background Color" style="width: 84%"/>
			<span class="colorpicker-example"></span>
			<a class="colorpicker-button button-secondary" href="javascript:void(null);">+</a>
			<div class="colorpicker-palette" style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;"></div>

			<p>
	    		<?php $mb->the_field( 'background_responsive' ); ?>
	    		<label><input type="checkbox" name="<?php $mb->the_name(); ?>" value="1"<?php if ( $mb->get_the_value() ) echo ' checked="checked"'; ?>/> 
	    		<?php _e( 'Make background image responsive', 'hoon' ); ?></label>
			</p>
	    </div><!-- .tabs1 -->
	    
	    <?php if( $show_styles_options ) : ?>
		<div class="tab2">
			<h4 class="heading"><?php _e( 'Style Options', 'hoon' ); ?></h4>
 			
 			<?php $mb->the_field( 'site_title_color' ); ?>
			<input class="colorpicker-color" type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" placeholder="Logo Color" style="width: 84%"/>
			<span class="colorpicker-example"></span>
			<a class="colorpicker-button button-secondary" href="javascript:void(null);">+</a>
			<div class="colorpicker-palette" style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;"></div>
	    </div><!-- .tabs2 -->
	    <?php endif; ?>
	    
	    <?php if( $show_template_options ) : ?>
	    <div class="tab3">
			<h4 class="heading"><?php _e( 'Content Options', 'hoon' ); ?></h4>
			
			<?php if( $show_columns_option ) : ?>
			<p>
				<label style="font-weight: bold"><?php _e( 'Columns: ', 'hoon' ); ?></label>
				<?php $mb->the_field( 'columns' ); ?>
				<select name="<?php $mb->the_name(); ?>">
					<option value=""><?php _e( 'Select column count...', 'hoon' ); ?></option>
					<option value="1"<?php $mb->the_select_state( '1' ); ?>><?php _e( '1', 'hoon' ); ?></option>
					<option value="2"<?php $mb->the_select_state( '2' ); ?>><?php _e( '2', 'hoon' ); ?></option>
					<option value="3"<?php $mb->the_select_state( '3' ); ?>><?php _e( '3', 'hoon' ); ?></option>
					<option value="4"<?php $mb->the_select_state( '4' ); ?>><?php _e( '4', 'hoon' ); ?></option>
					<option value="6"<?php $mb->the_select_state( '6' ); ?>><?php _e( '6', 'hoon' ); ?></option>
				</select>
			</p>
			<?php endif; ?>
			
			<label style="font-weight: bold"><?php _e( 'Categories:', 'hoon' ); ?></label>
			
			<p><?php _e( 'The category option is only available for specific page templates. By default, all categories are displayed.', 'hoon' ); ?></p>
			
			<p style="max-height: 100px; overflow-y: scroll">
			<?php $items = get_terms( 'category' ); ?>
			
			<?php foreach ( $items as $i => $item ): ?>
			    <label style="width: 115px; display: inline-block; margin: .5em 0">
			        <?php $mb->the_field( 'post_categories' ); ?>
			        <input type="checkbox" name="<?php $mb->the_name(); ?>[]" value="<?php echo $item->term_id; ?>"<?php $mb->the_checkbox_state($item->term_id ); ?>/> <?php echo $item->name; ?><br/>
			    </label>
			<?php endforeach; ?>
			</p>	
			
			
	    </div><!-- .tabs3 -->
	    <?php endif; ?>
	  
	</div><!-- .metabox-tabs-div -->
</div> <!-- wpalchemy-metabox -->