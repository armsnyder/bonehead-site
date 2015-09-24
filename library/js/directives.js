app.directive('playButton', function() {
	return {
		link: function($scope, elm, attrs) {
				elm.bind('click',function(){
								$scope.$apply(function() {

					var id=attrs.playButton;
					var song = {};
					for(var i in $scope.songs) {
						$scope.songs[i].playStatus = 'play';
						if($scope.songs[i].id==id) {
							song = $scope.songs[i];
							if($scope.songs[i].playStatus=='play') {
								console.log($scope.songs[i].playStatus);
								$scope.songs[i].playStatus = 'pause';
							}
						}
					}
					attrs.$set('src',$scope.icon[attrs.hoverImage].hover);
				});
			});
		}
	}
})
.directive('hoverImage', function() {
	return {
		link: function($scope, elm, attrs) {
			attrs.$set('src',$scope.icon[attrs.hoverImage].static);
			elm.bind('mouseenter',function(){
				attrs.$set('src',$scope.icon[attrs.hoverImage].hover);	
			});
			elm.bind('mouseleave',function(){
				attrs.$set('src',$scope.icon[attrs.hoverImage].static);
			});
			elm.bind('mousedown',function(){
				attrs.$set('src',$scope.icon[attrs.hoverImage].down);
			});
			elm.bind('mouseup',function(){
				attrs.$set('src',$scope.icon[attrs.hoverImage].hover);
			});
		}
	}
});