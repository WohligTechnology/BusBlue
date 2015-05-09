var lat = 0;
var long = 0;
var apiServer = "";
var adminurl = "";
var restservicemod = angular.module('restservicemod', [])

.factory('RestService', function($http) {


    return {
        getmap: function(data) {
            return $http.get("https://maps.googleapis.com/maps/api/geocode/json?address=" + data + "&key=AIzaSyAj0OXepKIgjTlZiPe_ZVYTDjL8rYpobgQ", {});
        },
        getiplatlongjson: function(data) {
            return $http.get(adminurl + "user/getlocationip?ip=" + data, {});
        }
    }
});