angular.module('app.meetus', ['ngRoute'])
    .config(['$routeProvider', function ($routeProvider) {
        $routeProvider
            .when('/meetus', {
                controller: 'MeetusController',
                templateUrl: 'pulsepro/data/blocks/Meet-the-Boneheads.html'
            })
    }]);