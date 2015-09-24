var app = angular.module('boneheadLibrary', ['ngRoute'])
	.config(['$routeProvider', function($routeProvider) {
		$routeProvider
			.when('/', {
					controller: 'SongsController',
					templateUrl: './partials/songs.html'
				})
			.when('/test/', {
					controller: 'SongsController',
					templateUrl: './partials/test.html'
				})
			.otherwise({redirectTo:'/'});
	}]);