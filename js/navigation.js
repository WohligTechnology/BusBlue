var navigationservice = angular.module('navigationservice', [])

.factory('NavigationService', function() {
    var navigation = [{
        name: "Bus",
        classis: "active",
        link: "#/home",
        onsession: "0",
        subnav: []
    }, {
        name: "Car",
        active: "",
        link: "#/car",
        onsession: "0",
        subnav: []
    }];

    return {
        getnav: function() {
            return navigation;
        },
        makeactive: function(menuname) {
            for (var i = 0; i < navigation.length; i++) {
                if (navigation[i].name == menuname) {
                    navigation[i].classis = "active";
                } else {
                    navigation[i].classis = "";
                }
            }
            return menuname;
        }

    }
});