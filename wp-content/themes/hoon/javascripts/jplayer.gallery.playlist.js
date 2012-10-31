jQuery( document ).ready( function( $ ) {
	/* Template Path (localized in functions.php) */
	var templateDirectoryUri = jplayer_params.get_template_directory_uri;
	
	/* Audio (localized in functions.php) */
	var audioJson = jplayer_params.format_audio.replace( /&quot;/g, '"' );
	var audio     = $.parseJSON( audioJson );
	
	/* Options (localized in functions.php) */
	var options         = jplayer_params.options;
	var enable_autoplay = options.enable_autoplay;
	var enable_playlist = options.enable_playlist;
		
	/* Player vars */
	var theID            = 'N';
	var theTracks        = audio.playlist;
	var defaultTracks    = get_first_album_id();
	var defaultTrackList = theTracks[defaultTracks];
	var thePlaylist      = 'playlist' + theID;
	var thePlayer        = $( '#jp_container_' + theID );
	
	/* Player object */
	var thePlaylist = new jPlayerPlaylist( {
		jPlayer: '#jquery_jplayer_N',
		cssSelectorAncestor: '#jp_container_N'
		}, 
			defaultTrackList, // track list
		{
		playlistOptions: {
			enableRemoveControls: false,
			autoPlay: false
		},
		swfPath: templateDirectoryUri + '/includes',
		supplied: 'mp3',
		wmode: 'window',
		errorAlerts: false,
		preload: 'auto',
		ready: function() {
			on_ready();
			highlight_playable_tracks( defaultTracks );
			add_track_number();
		},
		loadstart: function() {
		    autoplay_track()
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
		}
	});	
	
	/* Update and Display functionality */
	var jpPlaylist     = $( '.jp-type-playlist', thePlayer );
	var jpPlaylistView = $( '.jp-playlist-view', thePlayer );
	var jpPlaylistNav  = $( '.jp-playlist', thePlayer );
	var jpInterface    = $( '.jp-interface', thePlayer );
	var jpNoTracks     = $( '#jp-no-tracks', thePlayer );
	var jpTrack        = $( '.jp-current-track', thePlayer );
	var jpArtist       = $( '.jp-current-artist', thePlayer );
	var jpAlbum        = $( '.jp-current-album', thePlayer );
	var jpArtwork      = $( '.jp-current-artwork img.artwork', thePlayer );
	var jpCurrentTime  = $( '.jp-current-time-wrap', thePlayer );
	var jpNowPlaying   = $( '.jp-now-playing', thePlayer );
	var jpNotifictions = $( '.jp-notification', thePlayer );
	
	/* Update buttons */
	$( '.jp-next, .jp-previous, .jp-playlist-item' ).click( function() {
		update_current_track_info();
	});
	
	/**
	 * Get the first set of tracks from the array
	 * Used to set default tracks list
	 */
	function get_first_album_id() {
		var selector = '.blocks article.post:first';
		if ($(selector).length) {
			return $(selector).attr('id').replace('post-', '');
		}
		return 'N';
	}
	
	/* Hide notification messages - Loading & Updated Info */
	function on_ready() {
		thePlayer.attr( 'data-album-id', defaultTracks );
		
		if ( isNaN( defaultTracks ) ) {
		  notifications_display( 'no-tracks' );
		} else {
			notifications_display();
			jpNowPlaying.fadeTo( 400, 1);
			playlist_view();
			update_current_track_info();
			jpPlaylist.removeClass( 'preloading' ).addClass( 'loaded' );
			
			if( jpPlaylistNav.is(':visible') ) {
			    jpPlaylistView.addClass('active');
			} else {
			    jpPlaylistView.removeClass('active');
			}
		}
	}
						
	/**	
	 * Performed each time a track is played.
	 * Updates track info, shows/hides current time,
	 * and adds a "playing" class.
	 */
	function on_play( theAlbum ) {
		update_current_track_info();
		jpCurrentTime.fadeTo( 'fast', 1 );
		thePlayer.addClass( 'playing' );
		thePlayer.attr( 'data-album-id', theAlbum );
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

	/* Notification Display */
	function notifications_display(type) {
		jpNotifictions.hide();
		
		if ( 'no-tracks' == type ) {
			jpInterface.hide();
			jpNoTracks.show('fast');
		}
	}
	
	/**
	 * This will autoplay albums when they are selected from
	 * the album lists. Without this, they would play. However,
	 * if the playlist was showing, when selecting a new album,
	 * it would load, but not play. This fixes that AND makes
	 * it easy for users to set the autoplay if wanted…
	 */
	function autoplay_track() {
		if( enable_autoplay >= 1 ) {
		    thePlaylist.play();
		} else {
		    enable_autoplay++;
		}
	}
	
	/* Show playlist if option is checked in Theme Options */
	function playlist_view() {
		
		if ( enable_playlist >= 1 ) {
			jpPlaylistNav.show();
		} else {
			jpPlaylistNav.hide(); 
		}
		
	}
	
	/* Show and Hide playlist */
	jpPlaylistView.click( function(e) {
		
		e.preventDefault();
	  
		if( jpPlaylistNav.is( ':visible' ) ) {
			show_hide_playlist();
			jpPlaylistView.removeClass( 'active' );
		} else {
			show_hide_playlist(true);
			jpPlaylistView.addClass( 'active' );
		}
		
	});
	
	// Add a class to track list item if it's playable or not
	function highlight_playable_tracks(theAlbum) {

		var tracks_list = $( '.tracks li', thePlayer );
		
		
	    tracks_list.each( function( index, li ) {
	    	
	    	var theTrack = theTracks[theAlbum][index];
	    				
	    	if ( '' != theTrack.mp3 ) {
	    		$( this ).addClass( 'playable' );
	    	} else {
	    		$( this ).addClass( 'unplayable' );
	    	}
	    	
	    });
	    
	}
	
	/* Creat playlist for each album */
	$.each(theTracks, function(index, el) {
		var postID = '#post-' + index;
		var album = el;
		
		/** 
		 * Set Playlist and Pause/Play functionality for each album
		 * when entry thumbnail is clicked 
		 */
		$('.entry-thumbnails', postID).click( function() {
			
			if( $(this).hasClass('play-player') ) {
				// remove all pause-player classes, and reset with play-player
				$('.entry-thumbnails.pause-player').removeClass('pause-player').addClass('play-player');
				// add pause-player class to current item and remove play-player class
				$('.entry-thumbnails.play-player', postID).addClass('pause-player').removeClass('play-player');
				// stop any audio being played
				thePlaylist.pause();
				// load new audio playlist
				thePlaylist.setPlaylist(album);
				// play the playlist
				thePlaylist.play();
				// perform all play tasks
				on_play(index);
				// Add playable class to list items
				highlight_playable_tracks( index );
			} else {
				// add play-player class and remove pause-player class
				$('.entry-thumbnails.pause-player', postID).addClass('play-player').removeClass('pause-player');
				// stop all audio being played
				thePlaylist.pause();
				// perform all pause tasks
				on_pause();
			}
		});
	});
});
