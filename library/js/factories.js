app.factory('SongsService', function($http, util) {
	var url = './php/main.php';
	var factory = {};
	factory.songs = [];
	
	factory.icons = {
		'play':'play_button.png',
		'pause':'pause_button.png',
		'playH':'play_button_hover.png',
		'pauseH':'pause_button_hover.png'
	};
	
	factory.getSongs = function() {
		return $http.post(url,{a:'getSongs'})
			.success(function(data) {
				factory.songs=util.processSQL(data);
			});
	};
	
	factory.getSongsMin = function() {
		return $http.post(url,{a:'getSongsMin'})
			.success(function(data) {
				factory.songs=util.processSQL(data);
			});
	};
	
	factory.addSong = function() {
		return $http.post(url,{a:'addSong'});
	};
	
	factory.getPlayIcon = function(row) {
		var result = '';
		if(row.mouseover==0) {
			if(row.playStatus==0) {
				result = factory.icons.play;
			} else if(row.playStatus==1) {
				result = factory.icons.pause;
			}
		} else if(row.mouseover==1) {
			if(row.playStatus==0) {
				result = factory.icons.playH;
			} else if(row.playStatus==1) {
				result = factory.icons.pauseH;
			}
		}
		return result;
	}
	
	factory.setMouseover = function(x) {
		x.mouseover = (x+1)%1;
	};
	
	return factory;
})

.factory('util', function() {
	var factory = {};
	
	factory.processSQL = function(obj) {
		if('songs' in obj) {
			return obj.songs;
		} else if ('songsMin' in obj) {
			var obj1 = obj.songsMin;
			if(('rows' in obj1) && ('columns' in obj1)) {
				var result = [];
				var numRows = obj1.rows.length;
				var numCols = obj1.columns.length;
				for(var i=0; i<numRows; i++) {
					result[i]={};
					for(var j=0; j<numCols; j++) {
						result[i][obj1.columns[j]] = obj1.rows[i][j];
					}
					result[i].playStatus = 'play';
				}
				return result;
			}
			return [];
		}
		return [];
	}
	
	return factory;
});