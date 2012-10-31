<figure class="video-embed">
	<?php
	$custom_field_keys = get_post_custom_keys();

	foreach( $custom_field_keys as $key => $value ) {
		$prefix = trim( substr( $value, 1, 4 ) );
		
		if( 'oemb' == $prefix ) { // look if a oembed key exists
			$oembkey = $value; //now set the the key we found as oembkey
			$oembvalue = get_post_custom_values( $oembkey ); //get the value of oembkey as oembvalue
			
			if( isset( $oembvalue[0] ) ) {
				$embedhtml = $oembvalue[0];
				break;
			}
		}
	}
	?>
	
	<div class="player">
		<?php print $embedhtml; ?>
	</div>
</figure>


<hgroup class="details">
    <h5>
    	<a class="post-link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
    		<?php the_title(); ?>
    	</a>
    </h5>
</hgroup>