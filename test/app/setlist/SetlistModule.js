angular.module('app.setlist', ['ngRoute'])
    .config(['$routeProvider', function ($routeProvider) {
        $routeProvider
            .when('/library', {
                controller: 'SetlistController',
                templateUrl: 'app/setlist/view-setlist-public.html'
            })
            .when('/library/test', {
                controller: 'SetlistController',
                templateUrl: 'app/setlist/test.html'
            })
    }]);