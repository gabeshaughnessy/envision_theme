<?php

/* Get theme options */
$enable = array(
	'twitter' => hoon_option( 'share_on_twitter' ),
	'google' => hoon_option( 'share_on_google' ),
	'facebook' => hoon_option( 'share_on_facebook' )
);

/**
 * Check to see if atleast 1 enable option is enabled.
 * If so, set var to enable visibility of sharing section.
 */
foreach ( $enable as $option ) : 
	if ( ! $option ) {
		continue;
	} else {
		$enable_sharing_section = true;
	}
endforeach;

?>

<?php if ( isset( $enable_sharing_section ) ) : ?>
	<ul class="entry-sharing">
		
		<?php
		    #echo 'The ID: ' . get_the_ID() . '<br />';  
		    #echo 'The Title: ' . get_the_title() . '<br />';  
		    #echo 'The Permalink: ' . get_permalink();  
		    
		$the_ID = get_the_ID();
		/* Setup common link structure for services */
		$link = '<a class="popup sharing-link" id="%4$s" href="%1$s" title="%2$s">%3$s</a>';
		?>
		
		<li class="sharing-trigger">
			<a href="#"><i class="icon-plus"></i></a>
		
			<ul>
			<?php if ( $enable['twitter'] ) : ?>
				<li class="twitter">
					<?php 
					printf( $link,
						esc_url( sprintf( 'http://twitter.com/intent/tweet?text=%1$s&url=%2$s', 
							urlencode( get_the_title() . ' - ' ),
							get_permalink()
						) ), 
						esc_attr__( 'Share on Twitter', 'hoon' ), 
						'<i class="icon-twitter"></i>',
						esc_attr( 'twitter-' . $the_ID )
					); ?>
				</li>
			<?php endif; ?>
			
			<?php if ( $enable['google'] ) : ?>
				<li class="google">
					<?php 
					printf( $link, 
						esc_url( sprintf( 'https://plusone.google.com/_/+1/confirm?hl=en&url=%s', get_permalink() ) ), 
						esc_attr__( 'Share on Google+', 'hoon' ), 
						'<i class="icon-google-plus"></i>',
						esc_attr( 'google-' . $the_ID  )
					); 
					?>
				</li>
			<?php endif; ?>
					
			<?php if ( $enable['facebook'] ) : ?>
				<li class="facebook">
					<?php 
					printf( $link, 
						esc_url( sprintf( 'http://www.facebook.com/share.php?u=%s', get_permalink() ) ), 
						esc_attr__( 'Share on Facebook', 'hoon' ), 
						'<i class="icon-facebook"></i>',
						esc_attr( 'facebook-' . $the_ID )
					); ?>
				</li>
			<?php endif; ?>
			
			</ul>
		</li>

	</ul>
<?php endif; // end $enable_sharing_section check ?>
