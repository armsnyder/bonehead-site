angular.module("updateBio")
    .controller('UpdateBioController', function($scope, UpdateBioService) {
        $scope.match = null;
        var nameTable = null;
        $scope.status = "";
        UpdateBioService.getMembers().then(function() {
            nameTable = createNameTable(UpdateBioService.members);
        });
        $scope.submit = function() {
            $scope.status = "Submitting...";
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
            console.log("old photo: "+$scope.form.picture);
            $scope.form.picture = null;
        };
        $scope.useOldFile = function() {
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
    });