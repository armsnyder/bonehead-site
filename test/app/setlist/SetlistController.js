angular.module('app.setlist')
    .controller('SetlistController', function ($scope, SetlistService) {
        $scope.icon = {
            play: {
                static: '../boneheads/img/play_button.png',
                down: '../boneheads/img/play_button.png',
                hover: '../boneheads/img/play_button_hover.png'
            },
            download: {
                static: '../boneheads/img/download_button.png',
                down: '../boneheads/img/download_button.png',
                hover: '../boneheads/img/download_button_hover.png'
            },
            pause: {
                static: '../boneheads/img/pause_button.png',
                down: '../boneheads/img/pause_button.png',
                hover: '../boneheads/img/pause_button_hover.png'
            }
        };
        $scope.getPlayIcon = function (row) {
            return SetlistService.getPlayIcon(row);
        }
        $scope.setMouseover = function (x) {
            return SetlistService.setMouseover(x);
        }
        SetlistService
            .getSongsMin()
            .then(function () {
                $scope.songs = SetlistService.songs;
            });
    });