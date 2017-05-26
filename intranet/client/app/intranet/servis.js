intranet.service('fileUpload', ['$http', function ($http) {
    this.uploadFileToUrl = function (file, uploadUrl, fileForm, scope) {
        var fd = new FormData();
        fd.append('file', file);
        fd.append('folder', fileForm.folderName);
        fd.append('date', fileForm.date);
        fd.append('skTitle', fileForm.skTitle);
        fd.append('enTitle', fileForm.enTitle);
        $http.post(uploadUrl, fd, {
            transformRequest: angular.identity,
            headers: {
                'Content-Type': undefined,
                'Process-Data': false
            }
        }).then(function (res) {
            console.log(res);
        });
    }
 }]);

intranet.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;

            element.bind('change', function () {
                scope.$apply(function () {
                    modelSetter(scope, element[0].files[0]);
                });
            });
        }
    };
}]);