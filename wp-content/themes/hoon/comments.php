<?php if ( comments_open() || pings_open() ) : ?>
	<section id="comments">

		<?php 
		/**
		 * Password Protected
		 *
		 */
		if ( comments_open() && post_password_required() ) : ?>
			<p class="nocomments">
				<?php _e( 'This post is password protected. Enter the password to view comments.', 'hoon' ); ?>
			</p>
			</section><!-- #comments -->
			<?php return; ?>
		<?php endif; ?>
		
		
		<?php 
		/**
		 * Comment Form
		 *
		 */
		if ( comments_open() ) : ?>
			<?php if ( 0 != get_comments_number() ) : ?>
			<div class="comment-title-wrap ">
				<a class="leave-comment-link" href="#respond" title="<?php esc_attr_e( 'Leave A Comment &rarr;', 'hoon' ); ?>">
				    <?php _e( 'Leave A Comment &rarr;', 'hoon' ); ?>
				</a>
				
				<h4 class="comment-title"><?php esc_html_e( 'Comments', 'hoon' ) ?></h4>
			</div>
			<?php endif; ?>

			<?php if ( have_comments() ) : ?>
				<ol class="commentlist">
					<?php
					$comment_args = array(
						'type' => 'comment',
						'callback' => 'hoon_comment_callback'
					);
					wp_list_comments( $comment_args ); ?>
				</ol>
								
				<?php if ( get_option( 'page_comments' ) && get_comments_number() > get_option( 'comments_per_page' ) ) : ?>
					
					<div class="seperation-border"></div>
	    			<nav class="comment-pagination">
	    				<?php printf( __( '<p class="pages">Page <span class="current">%1s</span> <span class="of">of</span> <span class="total">%2s</span></p>', 'hoon' ), get_query_var( 'cpage' ), get_comment_pages_count() ); ?>
						<?php paginate_comments_links(); ?>
	    			</nav>
				<?php endif; ?>
			
			<?php endif; // end have_comments() ?>
		<?php endif; // end comments_open() ?>


		<?php 
		/**
		 * Comment Form
		 *
		 */
		if ( comments_open() ) : ?>
			<?php if ( 0 != get_comments_number() ) : ?>
			<div class="seperation-border"></div>
			<?php endif; ?>
			
			<?php comment_form(); ?>
		<?php endif; ?>


		<?php 
		/**
		 * Trackback & Pingbacks
		 *
		 */
		if ( pings_open()  ) : ?>
			<div class="pingback-title-wrap ">
				<h4 class="pingback-title"><?php _e( 'Trackbacks &amp; Pingbacks', 'hoon' ); ?></h4>
			</div>
			<?php $comments_by_type = &separate_comments( $comments ); ?>
			<?php if ( ! empty( $comments_by_type['pings'] ) ) : ?>
			    <ol class="pinglist">
			    	<?php 
			    	$comment_args = array(
			    		'type' => 'pings',
			    		'callback' => 'hoon_pings_callback'
			    	);
			    	wp_list_comments( $comment_args ); ?>
			    </ol>
			<?php else: ?>
			    <p class="pinglist">
			    	<span class="ping"><?php _e( 'No incoming links found yet.', 'hoon' ); ?></span>
			    </p>
			    <br />
			<?php endif; ?>
			<div class=""></div>
		<?php endif; ?>

	</section><!-- #comments -->
<?php endif; ?>