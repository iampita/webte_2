var myApp = angular.module('calendar',['ngRoute']);
myApp.config(function($routeProvider){
    $routeProvider
        .when('/', {
            templateUrl: 'app/calendar/calendarStatic.html',
            controller: 'calendarStaticCtrl'
        })
        
        .when('/dynamic', {
            templateUrl: 'app/calendar/calendarDynamic.html',
            controller: 'calendarDynamicCtrl'
        });
});
var year = new Date().getFullYear();
var month = new Date().getMonth();
