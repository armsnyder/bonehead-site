NAME_REGEXP = /\w+ \w+/;
angular.module('updateBio')
    .directive('fullName', function() {
        return {
            require: 'ngModel',
            link: function(scope, elm, attrs, ctrl) {
                ctrl.$validators.fullName = function(modelValue, viewValue) {
                    if (ctrl.$isEmpty(modelValue)) {
                        return false;
                    }
                    return NAME_REGEXP.test(viewValue);
                };
            }
        };
    });