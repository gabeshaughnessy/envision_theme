<?php if ( $wp_query->max_num_pages > 1 ) : ?>
	
	<div id="paginate" class="pagenavi">
		<?php
		$big     = 999999999;
		$base    = str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) );
		$total   = $wp_query->max_num_pages;
		$current = max( 1, hoon_get_paged_query_var() );

		$pagination_args = array(
		    'base'    => $base,
		    'format'  => '?paged=%#%&page_id=' . get_the_ID(),
		    'total' => $total,
		    'current' => $current,
		    'prev_text'    => '<i class="icon-chevron-left"></i>',
    		'next_text'    => '<i class="icon-chevron-right"></i>',
		);
		
		echo paginate_links( $pagination_args ); ?>
	</div>

<?php endif; // end page check ?>
