<?php 
/**
 * The template-audio page does not want the post id, but rather the letter N.
 * Javascript is used to then load the selected album for that page into this
 * N id. In other words, don't change this, it's important.
 */
$jplayer_id = ( is_page_template( 'template-audio.php' ) ) ? 'N' : get_the_ID(); ?>


<div id="jquery_jplayer_<?php echo esc_attr( $jplayer_id ); ?>" class="jp-jplayer"></div>

<aside id="jp_container_<?php echo esc_attr( $jplayer_id ); ?>" class="jp-audio entry-media">
    
    <div class="jp-now-playing row">
    	
    	<figure class="jp-current-artwork three columns">
    		<img src="<?php echo get_template_directory_uri() . '/images/default-artwork.png'; ?>" class="artwork preloading" alt="<?php esc_attr_e( 'Artwork', 'hoon' ); ?>" />
    	</figure><!-- .jp-current-artwork -->
    	
    	<ul class="jp-current-info nine columns">
    		<li class="jp-current-track">&nbsp;</li>
    		<li class="jp-current-artist">&nbsp;</li>
    		<li class="jp-current-album">&nbsp;</li>
    		<li>
    			<?php  
    			/**
    			 * Progress Bar
    			 *
    			 */		
    			?>
    			<div class="jp-progress-wrap">
    			    <div class="jp-progress">
    			    	<div class="jp-seek-bar">
    			    		<div class="jp-play-bar">
    			    			<div class="jp-current-time-wrap">
    			    				<div class="jp-current-time"></div>
    			    			</div>
    			    		</div>
    			    	</div>
    			    </div>
    			</div><!-- .jp-progress-wrap -->
    		</li>
    	</ul><!-- .jp-current-info -->
    	
    </div><!-- .jp-now-playing -->
    
    <?php  
    /**
     * Playlist
     *
     */		
    ?>
    <div class="jp-playlist row">
        <ul class="tracks twelve columns">
        	<li></li>
        </ul>
    </div><!-- .jp-playlist -->
    
    <?php  
    /**
     * Interface / GUI
     *
     */		
    ?>
    <div class="jp-interface jp-gui row">

        <nav class="jp-controls">
        
            <?php  
            $link = '<a href="javascript:;" id="%2$s-%1$d-%5$d" class="jp-%2$s" title="%3$s" tabindex="%5$d">%4$s</a>';
            ?>
            
            <?php  
            printf( $link,
                get_the_ID(),
                esc_attr( 'previous' ),
                esc_attr__( 'Previous', 'hoon' ),
                '<i class="icon-chevron-left"></i>',
                1
            );
            ?>
        
            <?php  
            printf( $link,
                get_the_ID(),
                esc_attr( 'play' ),
                esc_attr__( 'Play', 'hoon' ),
                '<i class="icon-play"></i>',
                2
            );
            ?>
            
            <?php
            printf( $link,
                get_the_ID(),
                esc_attr( 'pause' ),
                esc_attr__( 'Pause', 'hoon' ),
                '<i class="icon-pause"></i>',
                3
            );
            ?>
        
            <?php  
            printf( $link,
                get_the_ID(),
                esc_attr( 'next' ),
                esc_attr__( 'Next', 'hoon' ),
                '<i class="icon-chevron-right"></i>',
                4
            );
            ?>
        
            <?php  
            printf( $link,
                get_the_ID(),
                esc_attr( 'playlist-view' ),
                esc_attr__( 'Playlist', 'hoon' ),
                '<i class="icon-list"></i>',
                5
            );
            ?>
            
        </nav><!-- .jp-controls -->
    	
    </div><!-- .jp-interface -->


    <?php  
    /**
     * Notifications
     *
     */		
    ?>
    <div id="jp-notifications" class="row">
    	<div id="jp-loading" class="jp-notification twelve columns">
    	    <h4 class="jp-notification-title"><?php esc_html_e( 'Loading audio...', 'hoon' ); ?></h4>
    	    <span class="jp-notification-description"><?php esc_html_e( 'Please wait while the audio tracks are being loaded.', 'hoon' ); ?></a></span>
    	</div><!-- .jp-loading -->
    	
    	<div id="jp-no-tracks" class="jp-notification twelve columns">
    	    <h4 class="jp-notification-title"><?php esc_html_e( 'No Audio Available', 'hoon' ); ?></h4>
    	    <span class="jp-notification-description"><?php esc_html_e( 'It appears there are not any audio playlists available to play.', 'hoon' ); ?></a></span>
    	</div><!-- .jp-no-tracks -->
    	
    	<div id="jp-e_url" class="jp-notification twelve columns">
    	    <h4 class="jp-notification-title"><?php esc_html_e( 'Bad URL', 'hoon' ); ?></h4>
    	    <span class="jp-notification-description"><?php esc_html_e( 'The track url currently being played either does not exist or is not linked correctly.', 'hoon' ); ?>.</span>
    	</div><!-- .jp-no-solution -->
    	  		
    	<div id="jp-e_no_solution" class="jp-notification twelve columns">
    	    <h4 class="jp-notification-title"><?php esc_html_e( 'Update Required To Play Media', 'hoon' ); ?></h4>
    	    <span class="jp-notification-description"><?php esc_html_e( 'Update your browser to a recent version or update your ', 'hoon') ?> <a href="http://get.adobe.com/flashplayer/" target="_blank"><?php esc_html_e( 'Flash plugin', 'hoon' ); ?></a>.</span>
    	</div><!-- .jp-no-solution -->
    </div>
      		
</aside><!-- #jp_container_N -->

