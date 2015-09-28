angular.module('updateBio')
    .directive('validPassword', function($q, $http) {
        return {
            require: 'ngModel',
            link: function(scope, elm, attrs, ctrl) {

                ctrl.$asyncValidators.validPassword = function(modelValue, viewValue) {

                    if (ctrl.$isEmpty(modelValue)) {
                        // consider empty model valid
                        return $q.when();
                    }
                    var url = 'http://groups.northwestern.edu/boneheads/php/main.php?a=validate&text='+modelValue;
                    var def = $q.defer();

                    $http.get(url)
                        .success(function(data) {
                            if (data.valid) {
                                def.resolve();
                            } else {
                                def.reject();
                            }
                        })
                        .error(function() {
                            def.reject();
                        });

                    return def.promise;
                };
            }
        };
    });