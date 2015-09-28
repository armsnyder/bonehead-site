angular.module("updateBio")
    .controller('UpdateBioController', function($scope, UpdateBioService) {
        $scope.match = null;
        var nameTable = null;
        $scope.status = "";
        $scope.formEnabled = true;
        $scope.done = false;
        $scope.formError = '';
        $scope.uploadError = '';
        $scope.pictureUrl = '';
        $scope.uploadInProgress = false;
        UpdateBioService.getMembers().success(function() {
            nameTable = createNameTable(UpdateBioService.members);
        });
        $scope.uploadFile = function(files) {
            if ($scope.uploadInProgress) {
                $scope.uploadError = 'Upload in progress. Please wait.';
                return;
            }
            $scope.uploadInProgress = true;
            $scope.uploadError = '';
            $scope.pictureUrl = '';
            UpdateBioService.uploadFile(files)
                .success(function(data) {
                    $scope.uploadError = '';
                    $scope.uploadInProgress = false;
                    if (data.hasOwnProperty('success')) {
                        $scope.pictureUrl = UpdateBioService.getImagePath(data.success);
                        $scope.form.picture = data.success;
                    } else {
                        $scope.uploadError = 'Please ensure this is a valid image file under 1 Mb in size.'
                    }
                })
                .error(function() {
                    $scope.uploadInProgress = false;
                    $scope.uploadError = 'Please ensure this is a valid image file under 1 Mb in size.'
                });
        };
        $scope.submit = function() {
            $scope.formError = '';
            $scope.formEnabled = false;
            $scope.status = "Submitting...";
            UpdateBioService.addMember($scope.form)
                .success(function(data) {
                    if (data.hasOwnProperty('success')) {
                        onSubmitSuccess();
                        return;
                    }
                    if (data.hasOwnProperty('error')) {
                        onSubmitError(data.error);
                        return;
                    }
                    onSubmitError('Unknown error.');

                }).error(function(err) {
                    onSubmitError(err);
                });
        };
        $scope.findMatch = function() {
            var enteredName = $scope.form.gov_name;
            if (enteredName == null) {
                clearMatch();
                return;
            }
            if (nameTable.hasOwnProperty(enteredName)) {
                fillIn(nameTable[enteredName]);
            } else {
                if ($scope.match != null) {
                    clearMatch();
                }
            }
        };
        $scope.clearFile = function() {
            $scope.pictureUrl = '';
            $scope.form.picture = null;
        };
        $scope.useOldFile = function() {
            if ($scope.match != null) {
                $scope.pictureUrl = UpdateBioService.getImagePath($scope.match.picture);
            }
            $scope.form.picture = $scope.match.picture;
        };
        function clearMatch() {
            if ($scope.match == null) return;
            angular.forEach($scope.match, function(value, key) {
                if ($scope.form.hasOwnProperty(key) && key != 'gov_name') {
                    $scope.form[key] = '';
                }
            });
            $scope.match = null;
            $scope.pictureUrl = '';
        }
        function onSubmitSuccess() {
            //clearForm();
            $scope.formEnabled = true;
            $scope.done = true;
        }
        function onSubmitError(err) {
            $scope.status = '';
            $scope.formError = 'Error message: '+err;
            $scope.formEnabled = true;
        }
        function createNameTable(members) {
            var result = {};
            for (var key in members) {
                if (members.hasOwnProperty(key)) {
                    angular.forEach(members[key], function(value) {
                        if (value.hasOwnProperty('gov_name')) {
                            result[value['gov_name']] = value;
                        }
                    });
                }
            }
            return result;
        }
        function fillIn(member) {
            $scope.pictureUrl = UpdateBioService.getImagePath(member.picture);
            $scope.match = member;
            angular.forEach(member, function(value, key) {
                if (key == 'year') {
                    $scope.form[key] = parseInt(member[key]);
                } else {
                    $scope.form[key] = member[key];
                }
            });
            $scope.form.radio = 0;
        }
        function getImageIfExists(imageName) {
            return UpdateBioService.getImageIfExists(imageName);
        }
    });