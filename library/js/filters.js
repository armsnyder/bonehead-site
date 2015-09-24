app.filter('filters.time',function() {
		return function(item) {
			var minutes = Math.floor(item/60);
			var seconds = item-(minutes*60);
			if(seconds<10) {
				seconds = '0'+seconds;
			}
			return minutes+':'+seconds;
		}
	});