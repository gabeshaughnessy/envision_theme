<?php
/*
Template Name: Events
*/
?>

<?php get_header(); ?>

<div class="row">
	
	<section id="content" class="<?php echo esc_attr( hoon_main_column_width() . ' events-page' ); ?>">
		
		<div class="row">
			
			<?php the_post(); ?>
			
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'twelve columns entry' ); ?>>			    
    			<div class="entry-header">
    				<?php get_template_part( 'partials/post', 'header' ); ?>
    			</div>
				
				<div class="entry-content">
					<?php get_template_part( 'partials/post', 'content' ); ?>
	    		</div>
				
	    		<div class="event-list clearfix">
				<?php
				/* Theme Options */
				$event_cat_id = hoon_option( 'events_category' );
				
				if ( $event_cat_id ) {
				    $event_cat = get_category( $event_cat_id );
				    $event_cat_name = $event_cat->name;
				} else {
				    $event_cat_name = esc_html__( 'Events', 'hoon' );
				}
				
				$past_events_option = hoon_option( 'past_events_number' );
				
				/**
				 * If the page template is in use, this file gets called. However,
				 * the page template is not that useful unless the user defines
				 * a category to use as events. We will do a check for this option,
				 * and if it's not set, we will notify the user of what they need
				 * to do and then exit the page to avoid the rest of the script
				 * from being ran.
				 */
				if ( $event_cat_id ) : ?>
				
				    <?php
				    /* Set vars for month and year display */
				    $prev_month = '';
				    $prev_year = '';
				    
				    /* Create new event query */
				    $future_posts = new WP_Query( array(
				    	'post_status' => 'future',
				        'order' => 'ASC',
				        'cat' => $event_cat_id,
				        'posts_per_page' => -1
				    ) );
				    ?>
				    
				    <?php if ( ! $future_posts->have_posts() ) : ?>
				    	
				    	<?php 
				    	printf( '<p class="no post-event">%s</p>',
				    	    sprintf( esc_html__( 'There are not any %s scheduled at this time.', 'hoon' ), $event_cat_name  )
				    	);
				    	?>
				    	
				    <?php else : ?>
				    
				    	<dl id="filter-list" class="dropdown">
				    	    <dt><a href="#"><span><?php esc_html_e( 'Filter&hellip;', 'hoon' ); ?></span></a></dt>
				    	    <dd id="filter">
				    	        <ul>
				    		    	<li>
				    		    		<a class="active" href="#" data-event-slug="<?php echo esc_attr( $event_cat->slug ) ?>"><?php echo esc_html( $event_cat_name ); ?></a>
				    		    	</li>
				    		    	
				    		    	<?php
				    		    	$filter_list = get_categories( array(
				    		    		'child_of'     => $event_cat_id,
				    		    		'hierarchical' => false,
				    		    		'hide_empty'   => 0
				    		    	) );
				    		    	?>
				
				    		    	<?php foreach ( $filter_list as $item => $cat ) : ?>
				    				<li>
				    				    <a href="#" data-event-slug="<?php echo esc_attr( $cat->slug ) ?>"><?php echo $cat->name; ?></a>
				    				</li>
				    		    	<?php endforeach; ?>
				    	        </ul>
				    	    </dd>
				    	</dl>
				
				    	<ul class="date-list ">
				    	<?php while ( $future_posts->have_posts() ) : $future_posts->the_post(); ?>
				    	    	
				    	    <?php 
				    	    /**
				    	     * Show month/year heading if the previous month/year 
				    	     * is not equal to the curren post month/year
				    	     */
				    	    if ( get_the_time( 'M' ) != $prev_month || get_the_time( 'Y' ) != $prev_year ) :	?>
				    		<li class="month-year" id="<?php echo get_the_time( 'M' ); echo get_the_time( 'y' ); ?>">
				    		    
				    		    <h2 class="heading">
				    		    	<?php echo get_the_time( 'F' ); ?> <span class="sep">/</span> <span class="year"><?php echo get_the_time( 'Y' ); ?></span>
				    		    </h2>
				    		
				    		</li>
				    	    <?php endif; // end parent month year check ?>
				    	    
				    	    <?php
				    	    /** 
				    	     * Get Category nice names to be set as class values.
				    	     * We are doing this so we can use a JS Filter
				    	     */
				    	    $category_names = array(); // clear names from previous post
				    	    
				    	    foreach ( ( get_the_category() ) as $category ) { 
				    	        $category_names[] = sprintf( ' %s', $category->category_nicename ); 
				    	    }
				    	    
				    	    /* Create markup for post item */
				    	    $post_event_html = '<li class="post-event %1$s"><a class="%7$s" href="%2$s" title="%3$s">%4$s</a><div class="event-details"><a class="event-title" href="%2$s" title="%3$s">%5$s</a><span class="event-time">%6$s</span></div></li>';
				    	    
				    	    /* Print post event info */
				    	    printf( $post_event_html,
				    	    	esc_attr( implode( ' ', $category_names ) ),
				    	    	esc_url( get_permalink() ),
				    	    	esc_attr( the_title_attribute( array( 'echo' => 0 ) ) ),
				    	    	esc_html( get_the_time( 'd' ) ),
				    	    	esc_html( get_the_title() ),
				    	    	esc_html( get_the_time( 'l @ g:i a' ) ),
				    	    	esc_attr( 'event-day' )
				    	    );
				    	
				    	    /* Set month year for post. This is compared above for the next post */
				    	    $prev_month = get_the_time( 'M' );
				    	    $prev_year = get_the_time( 'Y' );	
				    	    ?>
				    	    	
				    	<?php endwhile; // end while have_posts() ?>
				    	
				    	<?php wp_reset_postdata(); ?>
				    	</ul>
				    	
				    <?php endif; // end if have_posts() ?>
				
				<?php else : // Event cat not set, so display a notice ?>
				    
				    <div class="alert-box error">
				    	<?php 
				    	printf( __( 'A category for %1$s has not been set in the %2$s.', 'hoon' ),
				    		esc_html( strtolower( $event_cat_name ) ),
				    		sprintf( '<a href="%1$s" title="%2$s">%3$s</a>',
				    			esc_url( admin_url( 'themes.php?page=hoon_options' ) ),
				    			esc_attr__( 'Theme Options', 'hoon' ),
				    			esc_html__( 'Theme Options', 'hoon' )
				    		) 
				    	); 
				    	?>
				    </div>
				    
				<?php endif; // end events_cat check ?>
	    		</div><!-- .event-list -->
			</article>
		</div>
	</section><!-- #content-->
</div>
<?php get_footer(); ?>