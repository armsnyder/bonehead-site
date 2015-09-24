angular.module('app.meetus')
    .factory('MeetusService', function ($http, util) {
        var url = 'http://groups.northwestern.edu/boneheads/php/main.php';
        var factory = {};
        factory.members = {};
        factory.getMembers = function() {
            return $http.post(url, {a:'getMembers'})
                .success(function(data) {
                    factory.members = data.members;
                });
        }
        factory.getPic = function(file) {
            return 'pulsepro/data/img/gallery/meet-us-pictures/'+file;
        }

        return factory;
    });