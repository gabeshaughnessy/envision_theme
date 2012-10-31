jQuery( document ).ready( function( $ ) {
    
/** JPLAYER SETUP */
var templateDirectoryUri = jplayer_params.get_template_directory_uri;
var audioJson            = jplayer_params.format_audio.replace( /&quot;/g, '"' );
var audio                = $.parseJSON( audioJson );

// Options (localized in functions.php)
var options              = jplayer_params.options;
var enable_autoplay      = options.enable_autoplay;
var enable_playlist      = options.enable_playlist;

// Check if playlist has a value
if(audio.playlist) {
    $.each(audio.playlist, function(index, el) {

    	var theID = index;
    	var theTracks = el;
    	var thePlaylist = 'playlist' + theID;
    	var thePlayer = $( '#jp_container_' + theID );

    	thePlaylist = new jPlayerPlaylist({
    			jPlayer: "#jquery_jplayer_" + theID,
    			cssSelectorAncestor: "#jp_container_"  + theID
    		}, 
    			theTracks, // track list
    		{
    		playlistOptions: {
    			enableRemoveControls: false,
    			autoPlay: enable_autoplay
    		},
    		swfPath: templateDirectoryUri + '/includes',
    		supplied: 'mp3',
    		wmode: 'window',
			ready: function() {
			    on_ready();
				highlight_playable_tracks();
			},
    		play: function() {
    			on_play();
    		},
    		pause: function() {
    			on_pause();
    		},
    		ended: function() {
    			update_current_track_info();
    		},
			error: function(event) {
				//console.log("Error Event: type = " + event.jPlayer.error.type);				
				
				var selector = '#jp-' + event.jPlayer.error.type;
				
				if ( $(selector).length ) {
					$(selector).show();
				}
				
				if ( 'e_url_not_set' == event.jPlayer.error.type ) {
				    thePlaylist.next();
				}
			},
    	});

    	/** Update and Display functionality */
		var jpPlaylist     = $( '.jp-type-playlist', thePlayer );
    	var jpPlaylistView = $( '.jp-playlist-view', thePlayer );
    	var jpPlaylistNav  = $( '.jp-playlist', thePlayer );
    	var jpTrack        = $( '.jp-current-track', thePlayer );
    	var jpArtist       = $( '.jp-current-artist', thePlayer );
    	var jpAlbum        = $( '.jp-current-album', thePlayer );
    	var jpArtwork      = $( '.jp-current-artwork img.artwork', thePlayer );
    	var jpCurrentTime  = $( '.jp-current-time-wrap', thePlayer );
		var jpNowPlaying   = $( '.jp-now-playing', thePlayer );
		var jpNotifictions = $( '.jp-notification', thePlayer );
    	
    	// Update buttons
    	$( '.jp-next, .jp-previous, .jp-playlist-item, .disc-play' ).click( function() {
    	    update_current_track_info();
    	});
    	
    	// Show and Hide playlist
    	jpPlaylistView.click(function(e){
    	    e.preventDefault();
			if( jpPlaylistNav.is( ':visible' ) ) {
				show_hide_playlist();
				jpPlaylistView.removeClass( 'active' );
			} else {
				show_hide_playlist(true);
				jpPlaylistView.addClass( 'active' );
			}
    	});
    	
		/* Show playlist if option is checked in Theme Options */
		function playlist_view() {
			if( enable_playlist >= 1 ) {
				jpPlaylistNav.show();
			} else {
				jpPlaylistNav.hide(); 
			}
		}    	
    	
    	/* Hide notification messages - Loading & Updated Info */
    	function on_ready() {
    		jpNotifictions.hide();
			jpNowPlaying.fadeTo( 200, 1);
			playlist_view();
			update_current_track_info();
			add_track_number();
			jpPlaylist.removeClass( 'preloading' ).addClass( 'loaded' );
    	    
    		if( jpPlaylistNav.is(':visible') ) {
    		    jpPlaylistView.addClass('active');
    		} else {
    		    jpPlaylistView.removeClass('active');
    		}
    	}
    	
		/**	
		 * Performed each time a track is played.
		 * Updates track info, shows/hides current time,
		 * and adds a "playing" class.
		 */
		function on_play() {
			update_current_track_info();
			jpCurrentTime.fadeTo( 'fast', 1 );
			thePlayer.addClass( 'playing' );
		}
		
		/* Performed each time a track is paused. */
		function on_pause() {
			jpCurrentTime.fadeTo( 'fast', 0 );
			thePlayer.removeClass( 'playing' );
		}

    	/* Update current track information */
    	function update_current_track_info() {
    	    var currentItem   = thePlaylist.playlist[thePlaylist.current];
    	    var currentTrack  = (currentItem.title)  ? currentItem.title : '';
    	    var currentArtist = (currentItem.artist) ? currentItem.artist : '';
    	    var currentAlbum  = (currentItem.album)  ? currentItem.album : '';
    	    var currentPoster = (currentItem.poster) ? currentItem.poster : '';
    	      
    	    jpTrack.html(currentTrack);
    	    jpArtist.html(currentArtist);
    	    jpAlbum.html(currentAlbum);
    	    jpArtwork.attr( 'src', currentPoster );
    	}
    	    	
    	/* Add track number */
    	function add_track_number() {
    		
    		var jpTrackNumber = $( '.jp-track-number', thePlayer );
    	    
    	    jpTrackNumber.remove();
    	    
    	    $( '.tracks li', thePlayer ).each( function() {
    	    	var trackNumber = $( this ).index() + 1;
    	    	$( this ).find( 'a.jp-playlist-item' ).wrapInner( '<span class="jp-track-title" />' );
    	    	$( this ).find( 'a.jp-playlist-item' ).prepend( '<span class="jp-track-number">' + trackNumber + '.</span>' );
    	    });
    	    
    	}
    
		/* Show and Hide playlist */
		function show_hide_playlist(shouldShow) {
			if (shouldShow) {
				jpPlaylistNav.slideDown('fast');
			} else {
				jpPlaylistNav.slideUp('fast');
			}
		}
		
		// Add a class to track list item if it's playable or not
		function highlight_playable_tracks() {				
		    $('.tracks li', thePlayer ).each(function() {
		    	var indexNumber = $( this ).index();
								
		    	if ( '' != theTracks[indexNumber].mp3 ) {
		    		$(this).addClass('playable');
		    	} else {
		    		$(this).addClass('unplayable');
		    	}
		    	
		    });
		}
    });
}
});
