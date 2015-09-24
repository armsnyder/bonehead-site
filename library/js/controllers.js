app.controller('SongsController', function($scope, SongsService) {
	$scope.icon = {
		play:{
			static:'./img/play_button.png',
			down:'./img/play_button.png',
			hover:'./img/play_button_hover.png'
			},
		download:{
			static:'./img/download_button.png',
			down:'./img/download_button.png',
			hover:'./img/download_button_hover.png'
			},
		pause:{
			static:'./img/pause_button.png',
			down:'./img/pause_button.png',
			hover:'./img/pause_button_hover.png'
			}
		};
	$scope.getPlayIcon = function(row) {
		return SongsService.getPlayIcon(row);
	}
	$scope.setMouseover = function(x) {
		return SongsService.setMouseover(x);
	}
	SongsService
		.getSongsMin()
		.then(function() {
			$scope.songs = SongsService.songs;
		});
});