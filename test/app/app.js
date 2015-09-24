'use strict';

// Declare app level module which depends on views, and components
angular.module('app', [
    'ngRoute',
    'app.setlist',
    'app.meetus',
    'app.directives',
    'app.filters'
])
    .config(['$routeProvider', function ($routeProvider) {
        $routeProvider
            .when('/faq',{
                templateUrl: 'pulsepro/data/blocks/FAQ.html'
            })
            .when('/alumni', {
                templateUrl: 'pulsepro/data/blocks/Alumni.html'
            })
            .otherwise({redirectTo: '/library'});
    }]);
