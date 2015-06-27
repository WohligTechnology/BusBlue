// JavaScript Document

var firstapp = angular.module('firstapp', [
    'ngRoute',
    'phonecatControllers',
    'templateservicemod',
    'navigationservice',
    'restservicemod',
    'pageslide-directive',
    'ui-rangeSlider'
]);

firstapp.config(['$routeProvider',

    function($routeProvider, $routeParams) {
        $routeProvider.
        when('/home', {
            templateUrl: 'views/template.html',
            controller: 'home'
        })
//            .when('/login', {
//            templateUrl: 'views/template.html',
//            controller: 'login'
//        })
//            .when('/forgetpass', {
//            templateUrl: 'views/template.html',
//            controller: 'forgetpass'
//        }).when('/signup', {
//            templateUrl: 'views/template.html',
//            controller: 'signup'
//        })
            .when('/resetpass', {
            templateUrl: 'views/template.html',
            controller: 'resetpass'
        }).when('/about', {
            templateUrl: 'views/template.html',
            controller: 'about'
        }).when('/terms', {
            templateUrl: 'views/template.html',
            controller: 'terms'
        }).when('/listing', {
            templateUrl: 'views/template.html',
            controller: 'listing'
        }).when('/bus', {
            templateUrl: 'views/template.html',
            controller: 'bus'
        }).when('/car-det', {
            templateUrl: 'views/template.html',
            controller: 'car-det'
        }).when('/myprofile', {
            templateUrl: 'views/template.html',
            controller: 'myprofile'
        }).when('/car', {
            templateUrl: 'views/template.html',
            controller: 'car'
        }).when('/coupon', {
            templateUrl: 'views/template.html',
            controller: 'coupon'
        }).when('/checkout-bus', {
            templateUrl: 'views/template.html',
            controller: 'checkout-bus'
        }).when('/contactus', {
            templateUrl: 'views/template.html',
            controller: 'contactus'
        }).
        otherwise({
            redirectTo: '/home'
        });

    }
]);