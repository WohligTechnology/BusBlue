var lat = 0;
var long = 0;
var phonecatControllers = angular.module('phonecatControllers', ['templateservicemod', 'navigationservice', 'restservicemod', 'ngRoute', 'ngDialog', 'infinite-scroll', 'wu.masonry', 'iso.directives', 'ui.bootstrap']);

phonecatControllers.controller('home',
    function($scope, TemplateService, NavigationService, RestService, $filter, $location, $timeout) {


        $scope.template = TemplateService;
        $scope.menutitle = NavigationService.makeactive("Bus");
        TemplateService.title = $scope.menutitle;
        TemplateService.content = "views/home.html";
        $scope.navigation = NavigationService.getnav();
        $scope.coords = {};

        $scope.show = false;
        $scope.pageClass = "page-home";
        $scope.pageready = "true";

//        $scope.login = function(listing) {
//            $scope.listingid = listing;
//           
//            ngDialog.open({
//                template: 'views/login.html',
//                controller: 'home'
//            });
//        };
    
//        $scope.logindiv = false;
    
        $scope.loginshow = function() {
            $scope.logindiv = true;
        }
        $scope.hidelogin = function() {
            $scope.logindiv = false;
        }

        angular.element(document).ready(function() {
            $scope.pageready = "false";




            /************ date picker **********/
            $scope.today = function() {
                $scope.dt = new Date();
            };
            $scope.today();

            $scope.clear = function() {
                $scope.dt = null;
            };

            // Disable weekend selection
            $scope.disabled = function(date, mode) {
                return (mode === 'day' && (date.getDay() === 0 || date.getDay() === 6));
            };

            $scope.toggleMin = function() {
                $scope.minDate = $scope.minDate ? null : new Date();
            };
            $scope.toggleMin();

            $scope.open = function($event) {
                console.log('Open Calendar');
                $event.preventDefault();
                $event.stopPropagation();

                $scope.opened = true;
            };

            $scope.dateOptions = {
                formatYear: 'yy',
                startingDay: 1
            };

            $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
            $scope.format = $scope.formats[0];

            var tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            var afterTomorrow = new Date();
            afterTomorrow.setDate(tomorrow.getDate() + 2);
            $scope.events = [{
                date: tomorrow,
                status: 'full'
            }, {
                date: afterTomorrow,
                status: 'partially'
            }];

            $scope.getDayClass = function(date, mode) {
                if (mode === 'day') {
                    var dayToCheck = new Date(date).setHours(0, 0, 0, 0);

                    for (var i = 0; i < $scope.events.length; i++) {
                        var currentDay = new Date($scope.events[i].date).setHours(0, 0, 0, 0);

                        if (dayToCheck === currentDay) {
                            return $scope.events[i].status;
                        }
                    }
                }

                return '';
            };

            /************ End date picker **********/

        });

        $scope.list = [];
        for (var i = 0; i < 6; i++) {
            $timeout(function() {
                $scope.list.push({
                    title: "item"
                });
            }, 500 * i);
        };

        $scope.myPagingFunction = function() {
            $timeout(function() {
                $scope.list.push({
                    title: "item"
                });
            }, 500 * i);
        }

        function showPosition2(position) {
            var latlon = position.coords.latitude + "," + position.coords.longitude;
            console.log("Positions:.........");
            console.log(position.coords);
            $scope.coords = position.coords;
            lat = position.coords.latitude;
            long = position.coords.longitude;
            $scope.showw = true;
        }

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition2, showError);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }


    });

phonecatControllers.controller('car',
    function($scope, TemplateService, NavigationService, RestService, $location, $http, ngDialog) {
        $scope.template = TemplateService;
        $scope.menutitle = NavigationService.makeactive("Car");
        TemplateService.title = $scope.menutitle;
        TemplateService.content = "views/car.html";
        $scope.pageClass = "page-home";
        $scope.navigation = NavigationService.getnav();


        $scope.login = function(logins) {
            $scope.listingid = logins;
            console.log("Demo is wokring");
            ngDialog.open({
                template: 'views/login.html',
                controller: 'car'
            });
        };


        $scope.isCollapse = true;

        //date slider

        $scope.Interval = 5000;
        var slides = $scope.slides = [];
        //     $scope.slides = [{
        //            date: '26-05-2015',
        //            
        //        }, {
        //            date: '27-05-2015',
        //           
        //        }];

        // slider end
        $scope.tab = 'out';
        $scope.class = '';
        $scope.classd = 'active';
        $scope.classe = '';
        $scope.tabchange = function(tab, a) {
            console.log(tab);
            $scope.tab = tab;
            if (a == 1) {
                $scope.class = '';
                $scope.classd = "active";
                $scope.classe = '';
            } else if (a == 2) {
                $scope.class = "active";
                $scope.classd = '';
                $scope.classe = '';
            } else {
                $scope.class = '';
                $scope.classd = '';
                $scope.classe = "active";
            }
        };



        //        $scope.changeClass = function (a) {
        //         
        //        }
        angular.element(document).ready(function() {
            $scope.pageready = "false";


            /************ date picker **********/
            $scope.today = function() {
                $scope.dt = new Date();
            };
            $scope.today();

            $scope.clear = function() {
                $scope.dt = null;
            };

            // Disable weekend selection
            $scope.disabled = function(date, mode) {
                return (mode === 'day' && (date.getDay() === 0 || date.getDay() === 6));
            };

            $scope.toggleMin = function() {
                $scope.minDate = $scope.minDate ? null : new Date();
            };
            $scope.toggleMin();

            $scope.open = function($event) {
                console.log('Open Calendar');
                $event.preventDefault();
                $event.stopPropagation();

                $scope.opened = true;
            };

            $scope.dateOptions = {
                formatYear: 'yy',
                startingDay: 1
            };

            $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
            $scope.format = $scope.formats[0];

            var tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            var afterTomorrow = new Date();
            afterTomorrow.setDate(tomorrow.getDate() + 2);
            $scope.events = [{
                date: tomorrow,
                status: 'full'
            }, {
                date: afterTomorrow,
                status: 'partially'
            }];

            $scope.getDayClass = function(date, mode) {
                if (mode === 'day') {
                    var dayToCheck = new Date(date).setHours(0, 0, 0, 0);

                    for (var i = 0; i < $scope.events.length; i++) {
                        var currentDay = new Date($scope.events[i].date).setHours(0, 0, 0, 0);

                        if (dayToCheck === currentDay) {
                            return $scope.events[i].status;
                        }
                    }
                }

                return '';
            };

            /************ End date picker **********/

        });
        /**** Time picker ********/

        $scope.mytime = new Date();

        $scope.hstep = 1;
        $scope.mstep = 15;

        $scope.options = {
            hstep: [1, 2, 3],
            mstep: [1, 5, 10, 15, 25, 30]
        };

        $scope.ismeridian = true;
        $scope.toggleMode = function() {
            $scope.ismeridian = !$scope.ismeridian;
        };

        $scope.update = function() {
            var d = new Date();
            d.setHours(14);
            d.setMinutes(0);
            $scope.mytime = d;
        };

        /**** Time picker end *****/


    });

//phonecatControllers.controller('myprofile',
//    function($scope, TemplateService, NavigationService, RestService, $location, $http) {
//        $scope.template = TemplateService;
//        $scope.menutitle = NavigationService.makeactive("My Profile");
//        TemplateService.title = $scope.menutitle;
//        TemplateService.content = "views/myprofile.html";
//        $scope.navigation = NavigationService.getnav();
//    
//  
//
//    
//    
//    });

phonecatControllers.controller('Datepicker',
    function($scope, TemplateService, NavigationService, RestService, $location, $http) {


        console.log("int datepicker");
        $scope.today = function() {
            $scope.dt = new Date();
        };
        $scope.today();

        $scope.clear = function() {
            $scope.dt = null;
        };

        // Disable weekend selection
        $scope.disabled = function(date, mode) {
            return (mode === 'day' && (date.getDay() === 0 || date.getDay() === 6));
        };

        $scope.toggleMin = function() {
            $scope.minDate = $scope.minDate ? null : new Date();
        };
        $scope.toggleMin();

        $scope.open = function($event) {
            $event.preventDefault();
            $event.stopPropagation();

            $scope.opened = true;
        };

        $scope.dateOptions = {
            formatYear: 'yy',
            startingDay: 1
        };

        $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
        $scope.format = $scope.formats[0];

        var tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        var afterTomorrow = new Date();
        afterTomorrow.setDate(tomorrow.getDate() + 2);
        $scope.events = [{
            date: tomorrow,
            status: 'full'
        }, {
            date: afterTomorrow,
            status: 'partially'
        }];

        $scope.getDayClass = function(date, mode) {
            if (mode === 'day') {
                var dayToCheck = new Date(date).setHours(0, 0, 0, 0);

                for (var i = 0; i < $scope.events.length; i++) {
                    var currentDay = new Date($scope.events[i].date).setHours(0, 0, 0, 0);

                    if (dayToCheck === currentDay) {
                        return $scope.events[i].status;
                    }
                }
            }

            return '';
        };

    });

phonecatControllers.controller('login',
    function($scope, TemplateService, NavigationService, RestService, $location) {
        $scope.template = TemplateService;
        TemplateService.title = $scope.menutitle;
        TemplateService.content = "views/login.html";
        $scope.navigation = NavigationService.getnav();
        $scope.pageClass = "page-login";
        $scope.headclass = 'changehead';
        $scope.loginfunc = function(login) {
            console.log("in login");
            toaster.pop("error", "Login Error", "Invalid username or password", 5000);
            toaster.pop("success", "Welcome", "Registered successfully", 5000);
        }

    });
phonecatControllers.controller('coupon',
    function($scope, TemplateService, NavigationService, RestService, $location) {
        $scope.template = TemplateService;
        TemplateService.title = $scope.menutitle;
        TemplateService.content = "views/coupon.html";
        $scope.navigation = NavigationService.getnav();
        $scope.pageClass = "page-login";
        $scope.headclass3 = 'coupon';
        $scope.loginfunc = function(login) {
            console.log("in login");
            toaster.pop("error", "Login Error", "Invalid username or password", 5000);
            toaster.pop("success", "Welcome", "Registered successfully", 5000);
        }
        $scope.filter = {
            tags: ""
        };
        $scope.changefilter = function(data) {
            for (var i = 0; i < $scope.filters.length; i++) {
                if ($scope.filters[i].name == data) {
                    $scope.filters[i].class = "select";
                } else {
                    $scope.filters[i].class = "";
                }

                if (data == "all") {
                    data = "";
                } {
                    $scope.filter.tags = data;
                }
            }
        };

        $scope.filters = [{
            "class": "select",
            "name": "all"
        }, {
            "class": "",
            "name": "food"
        }, {
            "class": "",
            "name": "entertainment"
        }, {
            "class": "",
            "name": "store"
        }, {
            "class": "",
            "name": "care"
        }, {
            "class": "",
            "name": "travel"
        }, {
            "class": "",
            "name": "lifestyle"
        }];

        $scope.coupons = [{
            "title": "you can pick this coupon only once",
            "image": "images/810_1416552824765.png",
            "name": "Free Garlic bread!",
            "button": "pick for ₹0",
            "tags": ["food", "care"]
        }, {
            "title": "you can pick this coupon only once",
            "image": "images/810_1416552824765.png",
            "name": "Free Butter bread!",
            "button": "pick for ₹0",
            "tags": ["food", "care"]
        }, {
            "title": "you can pick this coupon only once",
            "image": "images/810_1416552824765.png",
            "name": "Free Tushar bread!",
            "button": "pick for ₹0",
            "tags": ["food", "care"]
        }, {
            "title": "you can pick this coupon only once",
            "image": "images/810_1416552824765.png",
            "name": "Free Mahesh bread!",
            "button": "pick for ₹0",
            "tags": ["food", "care"]
        }, {
            "title": "you can pick this coupon only once",
            "image": "images/810_1416552824765.png",
            "name": "Free Chintan bread!",
            "button": "pick for ₹0",
            "tags": ["food", "care"]
        }, {
            "title": "you can pick this coupon only once",
            "image": "images/810_1416552824765.png",
            "name": "Free Sohan bread!",
            "button": "pick for ₹0",
            "tags": ["food", "lifestyle"]
        }, {
            "title": "you can pick this coupon only once",
            "image": "images/810_1416552824765.png",
            "name": "Free Sexy bread!",
            "button": "pick for ₹0",
            "tags": ["entertainment", "store"]
        }, {
            "title": "you can pick this coupon only once",
            "image": "images/810_1416552824765.png",
            "name": "Free Android bread!",
            "button": "pick for ₹0",
            "tags": ["food", "care"]
        }, ];


        $scope.checked = false; // This will be binded using the ps-open attribute

        $scope.toggle = function() {
            $scope.checked = !$scope.checked
        }

        angular.element(document).ready(function() {

            c = angular.element(document.querySelector('#controller-demo')).scope();
        });

        // Test
        angular.element(document).ready(function() {
            if (console.assert)
                console.assert(document.querySelectorAll('body > .ng-pageslide').length == 9, 'Made all of them')
        });

    });

phonecatControllers.controller('myprofile',
    function($scope, TemplateService, NavigationService, RestService, $location) {
        $scope.show1 = true;
        $scope.show2 = false;
        $scope.template = TemplateService;
        TemplateService.title = $scope.menutitle;
        TemplateService.content = "views/myprofile.html";
        $scope.navigation = NavigationService.getnav();
        $scope.pageClass = "page-login";
        $scope.headclass4 = 'profile';
        $scope.loginfunc = function(login) {
            console.log("in login");
            toaster.pop("error", "Login Error", "Invalid username or password", 5000);
            toaster.pop("success", "Welcome", "Registered successfully", 5000);
        }

        
//        ***** tabchange ****
            
        $scope.tab = 'coupon';
        $scope.class = '';
        $scope.classd = 'selected';
        $scope.classe = '';
        $scope.tabchange = function (tab,a) {
            //        console.log(tab);
            $scope.tab = tab;
            if (a == 1) {
                $scope.class = '';
                $scope.classd = "selected";
                $scope.classe = '';
            } else if (a == 2) {
                $scope.class = '';
                $scope.classd = '';
                $scope.classe = 'selected';
            } else {
                $scope.class = 'selected';
                $scope.classd = '';
                $scope.classe = '';
            }
        };
 
        
//            ******** end *******
            
        $scope.checked = false; // This will be binded using the ps-open attribute

        $scope.toggle = function() {
            $scope.checked = !$scope.checked
        }

        angular.element(document).ready(function() {

            c = angular.element(document.querySelector('#controller-demo')).scope();
        });

        // Test
        angular.element(document).ready(function() {
            if (console.assert)
                console.assert(document.querySelectorAll('body > .ng-pageslide').length == 9, 'Made all of them')
        });
        $scope.toggle = function() {
            $scope.show1 = true;
            $scope.show2 = false;
        }
        $scope.toggle1 = function() {
            $scope.show1 = false;
            $scope.show2 = true;
        }

    });


phonecatControllers.controller('forgetpass',
    function($scope, TemplateService, NavigationService, RestService, $location) {
        $scope.template = TemplateService;
        TemplateService.title = $scope.menutitle;
        TemplateService.content = "views/forgetpass.html";
        $scope.navigation = NavigationService.getnav();
        $scope.pageClass = "page-login";
        $scope.headclass = 'changehead';
        $scope.loginfunc = function(login) {
            console.log("in login");
            toaster.pop("error", "Login Error", "Invalid username or password", 5000);
            toaster.pop("success", "Welcome", "Registered successfully", 5000);
        }

    });

phonecatControllers.controller('resetpass',
    function($scope, TemplateService, NavigationService, RestService, $location) {
        $scope.template = TemplateService;
        TemplateService.title = $scope.menutitle;
        TemplateService.content = "views/resetpass.html";
        $scope.navigation = NavigationService.getnav();
        $scope.pageClass = "page-login";
        $scope.headclass = 'changehead';
        $scope.loginfunc = function(login) {
            console.log("in login");
            toaster.pop("error", "Login Error", "Invalid username or password", 5000);
            toaster.pop("success", "Welcome", "Registered successfully", 5000);
        }

    });

phonecatControllers.controller('about',
    function($scope, TemplateService, NavigationService, RestService, $location) {
        $scope.template = TemplateService;
        TemplateService.title = $scope.menutitle;
        TemplateService.content = "views/about.html";
        $scope.navigation = NavigationService.getnav();
        $scope.pageClass = "page-login";
        $scope.headclass1 = 'changeheads';
        $scope.loginfunc = function(login) {
            console.log("in login");
            toaster.pop("error", "Login Error", "Invalid username or password", 5000);
            toaster.pop("success", "Welcome", "Registered successfully", 5000);
        }

    });
phonecatControllers.controller('car-det',
    function($scope, TemplateService, NavigationService, RestService, $location, ngDialog) {
        $scope.template = TemplateService;
        TemplateService.title = $scope.menutitle;
        TemplateService.content = "views/car-det.html";
        $scope.navigation = NavigationService.getnav();
        $scope.pageClass = "page-login";
        $scope.headclass1 = 'changeheads';
        $scope.loginfunc = function(login) {
            console.log("in login");
            toaster.pop("error", "Login Error", "Invalid username or password", 5000);
            toaster.pop("success", "Welcome", "Registered successfully", 5000);
        }

        angular.element(document).ready(function() {
            $scope.pageready = "false";


            $scope.isCollapse = true;

            /************ date picker **********/
            $scope.today = function() {
                $scope.dt = new Date();
            };
            $scope.today();

            $scope.clear = function() {
                $scope.dt = null;
            };

            // Disable weekend selection
            $scope.disabled = function(date, mode) {
                return (mode === 'day' && (date.getDay() === 0 || date.getDay() === 6));
            };

            $scope.toggleMin = function() {
                $scope.minDate = $scope.minDate ? null : new Date();
            };
            $scope.toggleMin();

            $scope.open = function($event) {
                console.log('Open Calendar');
                $event.preventDefault();
                $event.stopPropagation();

                $scope.opened = true;
            };

            $scope.dateOptions = {
                formatYear: 'yy',
                startingDay: 1
            };

            $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
            $scope.format = $scope.formats[0];

            var tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            var afterTomorrow = new Date();
            afterTomorrow.setDate(tomorrow.getDate() + 2);
            $scope.events = [{
                date: tomorrow,
                status: 'full'
            }, {
                date: afterTomorrow,
                status: 'partially'
            }];

            $scope.getDayClass = function(date, mode) {
                if (mode === 'day') {
                    var dayToCheck = new Date(date).setHours(0, 0, 0, 0);

                    for (var i = 0; i < $scope.events.length; i++) {
                        var currentDay = new Date($scope.events[i].date).setHours(0, 0, 0, 0);

                        if (dayToCheck === currentDay) {
                            return $scope.events[i].status;
                        }
                    }
                }

                return '';
            };

            /************ End date picker **********/

        });
        /**** Time picker ********/

        $scope.mytime = new Date();

        $scope.hstep = 1;
        $scope.mstep = 15;

        $scope.options = {
            hstep: [1, 2, 3],
            mstep: [1, 5, 10, 15, 25, 30]
        };

        $scope.ismeridian = true;
        $scope.toggleMode = function() {
            $scope.ismeridian = !$scope.ismeridian;
        };

        $scope.update = function() {
            var d = new Date();
            d.setHours(14);
            d.setMinutes(0);
            $scope.mytime = d;
        };

        /**** Time picker end *****/


        // search tab change 
        $scope.tab = 'out';
        $scope.class = '';
        $scope.classd = 'active';
        $scope.classe = '';
        $scope.tabchange = function(tab, a) {
            console.log(tab);
            $scope.tab = tab;
            if (a == 1) {
                $scope.class = '';
                $scope.classd = "active";
                $scope.classe = '';
            } else if (a == 2) {
                $scope.class = "active";
                $scope.classd = '';
                $scope.classe = '';
            } else {
                $scope.class = '';
                $scope.classd = '';
                $scope.classe = "active";
            }
        };


        // end

        $scope.jqueryScrollbarOptions = {
            "type": "simpble",
            "onScroll": function(y, x) {
                if (y.scroll == y.maxScroll) {
                    alert('Scrolled to bottom');
                }
            }
        };





        $scope.items = [
            'Option 1',
            'Option 2',
            'Option 3'
        ];
        $scope.amenties = [
            'Option 1',
            'Option 2',
            'Option 3'
        ];
        $scope.boearding = [
            'Option 1',
            'Option 2',
            'Option 3'
        ];
        $scope.dropping = [
            'Option 1',
            'Option 2',
            'Option 3'
        ];
        $scope.rating = [
            'Option 1',
            'Option 2',
            'Option 3'
        ];






        $scope.rate = 4.5;
        $scope.max = 5;
        $scope.isReadonly = false;

        $scope.myInterval = 3000;
        $scope.slides = [{
            image: 'http://lorempixel.com/400/200/'
        }, {
            image: 'http://lorempixel.com/400/200/food'
        }, {
            image: 'http://lorempixel.com/400/200/sports'
        }, {
            image: 'http://lorempixel.com/400/200/people'
        }];




        $scope.ratingStates = [{
            stateOn: 'glyphicon-ok-sign',
            stateOff: 'glyphicon-ok-circle'
        }, {
            stateOn: 'glyphicon-star',
            stateOff: 'glyphicon-star-empty'
        }, {
            stateOn: 'glyphicon-heart',
            stateOff: 'glyphicon-ban-circle'
        }, {
            stateOn: 'glyphicon-heart'
        }, {
            stateOff: 'glyphicon-off'
        }];

        //        $scope.onemailclick = function (listing) {
        //            $scope.listingid = listing;
        //            console.log("Demo is wokring");
        //            ngDialog.open({
        //                template: 'views/buspop.html',
        //                controller: 'bus'
        //            });
        //        };
        //
        //        $scope.seat = function (listings) {
        //            $scope.listingid = listings;
        //            console.log("Demo is wokring");
        //            ngDialog.open({
        //                template: 'views/seat.html',
        //                controller: 'bus'
        //            });
        //        };
        //
        //        $scope.slide = function (slidess) {
        //            $scope.listingid = slidess;
        //            console.log("Demo is wokring");
        //            ngDialog.open({
        //                template: 'views/bslide.html',
        //                controller: 'bus'
        //            });
        //        };

    });

phonecatControllers.controller('bus',
    function($scope, TemplateService, NavigationService, RestService, $location, ngDialog) {
        $scope.template = TemplateService;
        TemplateService.title = $scope.menutitle;
        TemplateService.content = "views/bus.html";
        $scope.navigation = NavigationService.getnav();
        $scope.pageClass = "page-login";
        $scope.headclass1 = 'changeheads';
        $scope.loginfunc = function(login) {
            console.log("in login");
            toaster.pop("error", "Login Error", "Invalid username or password", 5000);
            toaster.pop("success", "Welcome", "Registered successfully", 5000);
        }

        $scope.jqueryScrollbarOptions = {
            "type": "simpble",
            "onScroll": function(y, x) {
                if (y.scroll == y.maxScroll) {
                    alert('Scrolled to bottom');
                }
            }
        };


        $scope.items = [
            'Option 1',
            'Option 2',
            'Option 3'
        ];
        $scope.amenties = [
            'Option 1',
            'Option 2',
            'Option 3'
        ];
        $scope.boearding = [
            'Option 1',
            'Option 2',
            'Option 3'
        ];
        $scope.dropping = [
            'Option 1',
            'Option 2',
            'Option 3'
        ];
        $scope.rating = [
            'Option 1',
            'Option 2',
            'Option 3'
        ];






        $scope.rate = 4.5;
        $scope.max = 5;
        $scope.isReadonly = false;

        $scope.myInterval = 3000;
        $scope.slides = [{
            image: 'http://lorempixel.com/400/200/'
        }, {
            image: 'http://lorempixel.com/400/200/food'
        }, {
            image: 'http://lorempixel.com/400/200/sports'
        }, {
            image: 'http://lorempixel.com/400/200/people'
        }];




        $scope.ratingStates = [{
            stateOn: 'glyphicon-ok-sign',
            stateOff: 'glyphicon-ok-circle'
        }, {
            stateOn: 'glyphicon-star',
            stateOff: 'glyphicon-star-empty'
        }, {
            stateOn: 'glyphicon-heart',
            stateOff: 'glyphicon-ban-circle'
        }, {
            stateOn: 'glyphicon-heart'
        }, {
            stateOff: 'glyphicon-off'
        }];

        $scope.isCollapse = true;

        $scope.onemailclick = function(listing) {
            $scope.listingid = listing;
            console.log("Demo is wokring");
            ngDialog.open({
                template: 'views/buspop.html',
                controller: 'bus'
            });
        };

        $scope.seat = function(listings) {
            $scope.listingid = listings;
            console.log("Demo is wokring");
            ngDialog.open({
                template: 'views/seat.html',
                controller: 'bus'
            });
        };

        $scope.slide = function(slidess) {
            $scope.listingid = slidess;
            console.log("Demo is wokring");
            ngDialog.open({
                template: 'views/bslide.html',
                controller: 'bus'
            });
        };

    });

phonecatControllers.controller('terms',
    function($scope, TemplateService, NavigationService, RestService, $location) {
        $scope.template = TemplateService;
        TemplateService.title = $scope.menutitle;
        TemplateService.content = "views/terms.html";
        $scope.navigation = NavigationService.getnav();
        $scope.pageClass = "page-login";
        $scope.headclass1 = 'changeheads';
        $scope.loginfunc = function(login) {
            console.log("in login");
            toaster.pop("error", "Login Error", "Invalid username or password", 5000);
            toaster.pop("success", "Welcome", "Registered successfully", 5000);
        }

    });

phonecatControllers.controller('signup',
    function($scope, TemplateService, NavigationService, RestService, $location) {
        $scope.template = TemplateService;
        $scope.headclass = 'changehead';
        TemplateService.title = $scope.menutitle;
        TemplateService.content = "views/signup.html";
        $scope.navigation = NavigationService.getnav();
        $scope.pageClass = "page-signup";


        $scope.signupfunc = function(login) {
            console.log("toaster");
            toaster.pop("error", "Signup Error", "Already Exist. Choose Another Email Address", 5000);
            toaster.pop("success", "Welcome", "Registered successfully", 5000);
        }

    });
phonecatControllers.controller('logout',
    function($scope, TemplateService, NavigationService, RestService, $location) {

    });
phonecatControllers.controller('contactus',
    function($scope, TemplateService, NavigationService) {
        $scope.template = TemplateService;
        TemplateService.title = $scope.menutitle;
        $scope.headclass1 = 'changeheads';
        TemplateService.content = "views/contactus.html";
        $scope.navigation = NavigationService.getnav();
    });

phonecatControllers.controller('listing',
    function($scope, TemplateService, NavigationService) {
        $scope.template = TemplateService;
        TemplateService.title = $scope.menutitle;
        TemplateService.content = "views/listing.html";
        $scope.navigation = NavigationService.getnav();

        $scope.changeorderto = function(neworder) {
            $scope.order = neworder;
        };

        $scope.xList = [{
            name: 'a',
            number: '1',
            date: '1360413309421',
            class: 'purple'
        }, {
            name: 'b',
            number: '5',
            date: '1360213309421',
            class: 'orange'
        }, {
            name: 'c',
            number: '10',
            date: '1360113309421',
            class: 'blue'
        }, {
            name: 'd',
            number: '2',
            date: '1360113309421',
            class: 'green'
        }, {
            name: 'e',
            number: '6',
            date: '1350613309421',
            class: 'green'
        }, {
            name: 'f',
            number: '21',
            date: '1350613309421',
            class: 'orange'
        }, {
            name: 'g',
            number: '3',
            date: '1340613309421',
            class: 'blue'
        }, {
            name: 'h',
            number: '7',
            date: '1330613309001',
            class: 'purple'
        }, {
            name: 'i',
            number: '22',
            date: '1360412309421',
            class: 'blue'
        }]
        $scope.pageClass = "page-signup";

        $scope.items = [{
            "id": 0,
            "picture": "http://placehold.it/32x32",
            "age": 31,
            "name": "Mathews Goff"
        }, {
            "id": 1,
            "picture": "http://placehold.it/32x32",
            "age": 36,
            "name": "Collins Alston"
        }, {
            "id": 2,
            "picture": "http://placehold.it/32x32",
            "age": 27,
            "name": "Jasmine Rollins"
        }, {
            "id": 3,
            "picture": "http://placehold.it/32x32",
            "age": 32,
            "name": "Julie Jefferson"
        }, {
            "id": 4,
            "picture": "http://placehold.it/32x32",
            "age": 23,
            "name": "Wilder King"
        }, {
            "id": 5,
            "picture": "http://placehold.it/32x32",
            "age": 23,
            "name": "Stanley Moore"
        }, {
            "id": 6,
            "picture": "http://placehold.it/32x32",
            "age": 36,
            "name": "Reynolds Bishop"
        }, {
            "id": 7,
            "picture": "http://placehold.it/32x32",
            "age": 26,
            "name": "Bryant Flowers"
        }, {
            "id": 8,
            "picture": "http://placehold.it/32x32",
            "age": 38,
            "name": "Jenifer Martinez"
        }, {
            "id": 9,
            "picture": "http://placehold.it/32x32",
            "age": 40,
            "name": "Mcguire Pittman"
        }, {
            "id": 10,
            "picture": "http://placehold.it/32x32",
            "age": 34,
            "name": "Valdez Hyde"
        }, {
            "id": 11,
            "picture": "http://placehold.it/32x32",
            "age": 34,
            "name": "Marla Mayo"
        }, {
            "id": 12,
            "picture": "http://placehold.it/32x32",
            "age": 30,
            "name": "Brown Ortega"
        }, {
            "id": 13,
            "picture": "http://placehold.it/32x32",
            "age": 32,
            "name": "Jeannette William"
        }, {
            "id": 14,
            "picture": "http://placehold.it/32x32",
            "age": 30,
            "name": "Bridges Ashley"
        }, {
            "id": 15,
            "picture": "http://placehold.it/32x32",
            "age": 33,
            "name": "Latasha Hewitt"
        }, {
            "id": 16,
            "picture": "http://placehold.it/32x32",
            "age": 35,
            "name": "Alma Sawyer"
        }, {
            "id": 17,
            "picture": "http://placehold.it/32x32",
            "age": 21,
            "name": "Liz Mcbride"
        }, {
            "id": 18,
            "picture": "http://placehold.it/32x32",
            "age": 26,
            "name": "Mcintosh Chandler"
        }, {
            "id": 19,
            "picture": "http://placehold.it/32x32",
            "age": 20,
            "name": "Alford Hartman"
        }, {
            "id": 20,
            "picture": "http://placehold.it/32x32",
            "age": 29,
            "name": "Tiffany Green"
        }, {
            "id": 21,
            "picture": "http://placehold.it/32x32",
            "age": 38,
            "name": "Stafford Riggs"
        }, {
            "id": 22,
            "picture": "http://placehold.it/32x32",
            "age": 40,
            "name": "Elinor Chambers"
        }, {
            "id": 23,
            "picture": "http://placehold.it/32x32",
            "age": 27,
            "name": "Carly Howard"
        }, {
            "id": 24,
            "picture": "http://placehold.it/32x32",
            "age": 27,
            "name": "Rosalind Sanchez"
        }, {
            "id": 25,
            "picture": "http://placehold.it/32x32",
            "age": 28,
            "name": "Jaclyn Shelton"
        }, {
            "id": 26,
            "picture": "http://placehold.it/32x32",
            "age": 25,
            "name": "Hughes Phelps"
        }, {
            "id": 27,
            "picture": "http://placehold.it/32x32",
            "age": 36,
            "name": "Rosetta Barrett"
        }, {
            "id": 28,
            "picture": "http://placehold.it/32x32",
            "age": 29,
            "name": "Jarvis Wong"
        }, {
            "id": 29,
            "picture": "http://placehold.it/32x32",
            "age": 23,
            "name": "Kerri Pennington"
        }];
    });

phonecatControllers.controller('forgot',
    function($scope, TemplateService, NavigationService, RestService) {
        $scope.template = TemplateService;
        TemplateService.title = $scope.menutitle;
        TemplateService.content = "views/forgot.html";
        $scope.navigation = NavigationService.getnav();

    });

phonecatControllers.controller('headerctrl',
    function($scope, TemplateService, ngDialog) {
        $scope.template = TemplateService;

        //        $scope.imagepath = imagepath;
        //            ******** login pop ******

        $scope.login = function() {
            //            $scope.listingid = listing;

            ngDialog.open({
                template: 'views/login.html',
                controller: 'headerctrl'
            });
        };




        //            ********* end ********


    });