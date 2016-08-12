angular.module("helloWorld", []);

angular.module("helloWorld").controller("helloWorldCtrl", function ($scope) {
	$scope.message = "Hello World!";
});
