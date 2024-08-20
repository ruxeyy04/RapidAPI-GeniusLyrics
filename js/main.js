(function ($) {
	"use strict";
	$(document).ready(function() {
	  var debounceTimeout;
	  $('#search_music').on('input', function() {
		clearTimeout(debounceTimeout);
  
		var query = $(this).val();
  
		debounceTimeout = setTimeout(function() {
		  if (query.length > 0) {
			const settings = {
			  async: true,
			  crossDomain: true,
			  url: `https://genius-song-lyrics1.p.rapidapi.com/search/?q=${encodeURIComponent(query)}&per_page=5&page=1`,
			  method: 'GET',
			  headers: {
				'x-rapidapi-key': 'd1098010a2msh9f2ec99a08cbfd2p191d5ejsn9b7e02cf8a63',
				'x-rapidapi-host': 'genius-song-lyrics1.p.rapidapi.com'
			  }
			};
  
			$.ajax(settings).done(function(response) {
			  $('#music_recommendations').empty();
  
			  if (response.hits && response.hits.length > 0) {
				response.hits.forEach(function(hit) {
				  var song = hit.result;
				  var title = song.full_title;
				  var artist = song.primary_artist.name;
				  var imageUrl = song.song_art_image_thumbnail_url;
				  var songId = song.id;
  
				  $('#music_recommendations').append(`
					<div class="station-tab song-link" data-song-id="${songId}" data-song-title="${title}">
					  <img src="${imageUrl}" alt="${title}" class="img-thumbnail" style="width: 40px; height: 40px; margin-right: 10px;">
					  <div class="station-info">
						<div class="station-name">${title}</div>
						<div class="station-genre">${artist}</div>
					  </div>
					</div>
				  `);
				});
  
				$('.song-link').on('click', function(e) {
				  e.preventDefault();
				  var songId = $(this).data('song-id');
				  var songTitle = $(this).data('song-title');
				  fetchLyrics(songId, songTitle);
				});
			  } else {
				$('#music_recommendations').append('<p>No results found.</p>');
			  }
			});
		  } else {
			$('#music_recommendations').empty();
		  }
		}, 500); 
	  });
  
	  function fetchLyrics(songId, songTitle) {
		const lyricsSettings = {
		  async: true,
		  crossDomain: true,
		  url: `https://genius-song-lyrics1.p.rapidapi.com/song/lyrics/?id=${songId}`,
		  method: 'GET',
		  headers: {
			'x-rapidapi-key': 'd1098010a2msh9f2ec99a08cbfd2p191d5ejsn9b7e02cf8a63',
			'x-rapidapi-host': 'genius-song-lyrics1.p.rapidapi.com'
		  }
		};
  
		$.ajax(lyricsSettings).done(function(response) {
		  if (response.lyrics && response.lyrics.lyrics && response.lyrics.lyrics.body && response.lyrics.lyrics.body.html) {
			$('#lyricsModalTitle').text(songTitle);
			$('#lyrics_content').html(response.lyrics.lyrics.body.html);
			$('#lyricsModal').modal('show');
		  } else {
			$('#lyrics_content').html('<p>Lyrics not available.</p>');
		  }
		});
	  }
	});
  })(jQuery);
  