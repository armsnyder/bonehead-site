angular.module('app.meetus')
    .controller('MeetusController', function ($scope, MeetusService) {
        $scope.members = {};
        $scope.getPic = function(file) {
            return MeetusService.getPic(file);
        }
        MeetusService.getMembers().then(function() {
            $scope.members = MeetusService.members;
        });
    });