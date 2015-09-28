angular.module("updateBio")
    .factory('UpdateBioService', function($http) {
        var phpUrl = 'http://groups.northwestern.edu/boneheads/php/main.php';
        var imageUpUrl = phpUrl+'?a=uploadPicture';
        var galleryUrl = 'http://groups.northwestern.edu/boneheads/uploads/';
        var factory = {};
        factory.members = {};
        factory.getMembers = function() {
            return $http.post(phpUrl, {a:'getMembers'})
                .success(function(data) {
                    factory.members = data.members;
                });
        };
        factory.addMember = function(formData) {
            return $http.post(phpUrl, {a:'addMember',form:formData});
        };
        factory.uploadFile = function(files) {
            var fd = new FormData();
            //Take the first selected file
            fd.append("file", files[0]);

            return $http.post(imageUpUrl, fd, {
                withCredentials: true,
                headers: {'Content-Type': undefined },
                transformRequest: angular.identity
            });
        };
        factory.getImagePath = function(file) {
            return galleryUrl + file;
        };
        factory.getImageIfExists = function(imageName) {
            var url = galleryUrl + imageName;
            var request = new XMLHttpRequest();
            request.open('HEAD', url, false);
            request.send();
            if(request.status == 200) {
                return url;
            } else {
                return '';
            }
        };
        return factory;
    });