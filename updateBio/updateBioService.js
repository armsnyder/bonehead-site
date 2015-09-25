angular.module("updateBio")
    .factory('UpdateBioService', function($http) {
        var phpUrl = 'http://groups.northwestern.edu/boneheads/scripts/misc.php';
        var galleryUrl = 'http://groups.northwestern.edu/boneheads/pulsepro/data/img/gallery/meet-us-pictures/';
        var factory = {};
        factory.members = {};
        factory.getMembers = function() {
            return $http.post(phpUrl, {a:'getMembers'})
                .success(function(data) {
                    factory.members = data.members;
                });
        };
        factory.addMember = function(formData) {

        };
        factory.getImagePath = function(file) {
            return galleryUrl + file;
        };
        return factory;
    });