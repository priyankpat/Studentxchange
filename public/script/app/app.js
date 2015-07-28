'use strict';
define(['angular', 'iScroll', 'ngIScroll', 'angularRouter', 'angularAnimate', 'angularSanitize', 'underscore', 'ngMap', 'async!https://maps.google.com/maps/api/js', 'owlCarousel'], function(angular, iScroll, ngISCroll, angularRouter, angularAnimate, angularSanitize, _, ngMap, owlCarousel) {
    var app = angular.module('SXC', ['ui.router', 'ngAnimate', 'ngSanitize', 'ngMap', 'ng-iscroll']);
     app.constant("CSRF_TOKEN", getMetaContent("csrf-token"));
    app.run(function($rootScope, $location, $state, $timeout, AuthenticationService, FlashService) {

        var routesThatRequireAuth = ['/dashboard', '/dashboard/home', '/dashboard/library', /*'/dashboard/listings/browse', '/dashboard/details',*/ '/dashboard/profile'];
        $rootScope.$on('$stateChangeStart', function() {
        });

        $rootScope.$on('$stateChangeSuccess', function () {
            console.log($location.path())
        	if(_(routesThatRequireAuth).contains($location.path()) && !AuthenticationService.isLoggedIn()) {
	        	$state.go('auth.login'); 
	        	$timeout(function () {
		        	FlashService.show("Please login to continue", 'error'); 
		        }, 300);

		        $timeout(function () {
		        	FlashService.clear();
		        }, 3000);
	        } else {
	        	if(_(routesThatRequireAuth).contains($location.path()) && !AuthenticationService.isLoggedIn()) {
	        		$state.go('dashboard.home'); 
	        	}
	        }
        });
    });
    app.config(['$stateProvider', '$urlRouterProvider', '$httpProvider',
        function($stateProvider, $urlRouterProvider, $httpProvider) {
            $urlRouterProvider.otherwise('/404');
            $stateProvider.state('auth', {
                url: '/auth',
                templateUrl: 'partials/auth/main.html'
            }).state('auth.login', {
                url: '/login',
                templateUrl: 'partials/auth/login.html',
                controller: 'LoginController'
            }).state('auth.alternate', {
                url: '/alternate',
                templateUrl: 'partials/auth/alternate-login.html'
            }).state('auth.forgot', {
                url: '/forgot',
                templateUrl: 'partials/auth/forgot.html'
            }).state('auth.logout', {
            	url: '/logout',
            	templateUrl: 'partials/auth/login.html'
            }).state('auth.register', {
                url: '/register',
                templateUrl: 'partials/auth/register.html',
                controller: 'RegisterController'
            }).state('auth.activate', {
                url: '/activate',
                templateUrl: 'partials/auth/activate.html',
                controller: 'ActivateController'
            })
            .state('dashboard', {
                url: '/dashboard',
                templateUrl: 'partials/dashboard/main.html',
                controller: 'DashboardController'
            }).state('dashboard.home', {
            	url: '/home',
            	templateUrl: 'partials/dashboard/home.html'
            }).state('dashboard.library', {
            	url: '/library',
            	templateUrl: 'partials/dashboard/library.html'
            }).state('dashboard.listings', {
            	url: '/listings',
            	templateUrl: 'partials/dashboard/listings.html'
            }).state('dashboard.listings.browse', {
            	url: '/browse',
            	templateUrl: 'partials/listings/browse.html',
            	controller: 'ListingBrowseController'
            }).state('dashboard.listings.details', {
            	url: '/details/:listingId',
            	templateUrl: 'partials/listings/details.html',
            	controller: 'ListingDetailsController'
            })
            .state('dashboard.profile', {
                url: '/profile',
                templateUrl: 'partials/auth/profile.html'
            }).state('dashboard.inbox', {
                url: '/inbox',
                templateUrl: 'partials/dashboard/inbox.html'
            })
            .state('404', {
                url: '/404',
                templateUrl: 'partials/misc/404.html'
            })
            .state('policy', {
                url: '/policy',
                templateUrl: 'partials/support/main.html'
            })
            .state('landing', {
                url: '/landing', 
                templateUrl: 'partials/landing/home.html'
            })
            $httpProvider.defaults.headers.post['Content-Type'] = 'application/json; charset=utf-8';
        }
    ]);
    app.controller('landingController', ['$scope', '$location', '$state', function ($scope, $location, $state) {
		$scope.pageClass = 'page-landing';
		$scope.mainStyle = function () {
			return "height: " + window.innerHeight + "px";
		}

		$scope.infoStyle = function () {
			return "height: " + window.innerHeight + "px";
		}

		$scope.toggleLogin = function () {
			$state.go('auth.login');
		}

		$scope.toggleRegister = function () {
			$state.go('auth.register');
		}
	}]);
    app.controller('LoginController', function($scope, $location, $timeout, AuthenticationService, FlashService) {
        $scope.credentials = {
            user: "",
            password: ""
        }
        $scope.isProcessing = false;
        $scope.login = function() {
            $scope.isProcessing = true;
            AuthenticationService.login($scope.credentials).success(function() {
                $timeout(function() {
                    $location.path('/dashboard/home');
                }, 3000);
            }).error(function() {
                $timeout(function() {
                    $scope.isProcessing = false;
                }, 800);
            });
        }   
    });
    app.controller('RegisterController', function ($scope, $location, $timeout, $state, AuthenticationService, FlashService) {
        $scope.isProcessing = false;
        $scope.register = function () {
            $scope.isProcessing = true;
            AuthenticationService.validateUsername($scope.credentials).success(function () {
                AuthenticationService.validateEmail($scope.credentials).success(function () {
                    AuthenticationService.register($scope.credentials).success(function () {
                        console.log("success");
                    }).error(function() {
                         console.log("error");
                    });
                }).error(function () {
                    $timeout(function() {
                        $scope.isProcessing = false;
                    }, 800);
                });
            }).error(function () {
                $timeout(function() {
                    $scope.isProcessing = false;
                }, 800);
            });
        }
    });
    app.controller("ActivateController", function ($scope) {
         
    });
    app.controller('DashboardController', function ($scope, $location, $timeout, $state, AuthenticationService, FlashService) {
        $scope.isSidebarToggleActive = true;
        $scope.isListToggleActive = false;
    	$scope.$parent.myScrollOptions = {
    		snap: false,
    		hScrollbar: true,
    		mouseWheel: true,
    		momentum: true
    	}
    	$scope.logout = function () {
        	AuthenticationService.logout().success(function () {
        		$state.go('auth.login');
        		FlashService.show('Bye! See You Later!', 'success');
        		$timeout(function () {
		        	FlashService.clear();
		        }, 3000);
        	});
        }
        
        $scope.toggleSidebar = function () {
            console.log($scope.isSidebarToggleActive)
            if(!$scope.isSidebarToggleActive) {
                $scope.isSidebarToggleActive = true;
                $scope.isListToggleActive = false;
            }
            else {
                $scope.isSidebarToggleActive = false;
                $scope.isListToggleActive = true;
            }
        }
        
    });
    app.controller("ListingBrowseController", function ($scope, $http) {
        $http.get("/api/dashboard/get/listings?i=2")
        .success(function (data, status, headers, config) {
            if(status == 200) {
                if(data.length != 0) {
                    $scope.listingData = data;
                } else {
                    $scope.listingError = "No Listings Found";
                }
            }
                
        })
        .error(function (data, status, headers, config) {
            if(status == 404) {
                
            }
        })
    });
    app.controller("ListingDetailsController", function ($rootScope, $scope, $stateParams, $timeout) {
        $(".listing-carousel").owlCarousel({
            items: 1,
            dots: true,
            lazyLoad: true
        });
    });
    app.factory("AuthenticationService", function($http, $timeout, $sanitize, SessionService, FlashService, CSRF_TOKEN) {
        var cacheSession = function() {
            SessionService.set('authenticated', true);
        };
        var uncacheSession = function() {
            SessionService.unset('authenticated');
        };
        var loginError = function(response) {
            $timeout(function() {
                FlashService.show(response.flash, 'error');
            }, 800);
        };
        var loginSuccess = function(response) {
            $timeout(function() {
                FlashService.show(response.response, 'success');
            }, 800);
        };
        var registerSuccess = function (response) {
            console.log(response.flash)
            $timeout(function () {
                FlashService.show(response.response, 'success');
            }, 800);
        };
        var registerError = function (response) {
            console.log(response)
            $timeout(function () {
                FlashService.show(response.flash, 'error');
            }, 800);
        }
        var sanitizeCredentials = function(credentials) {
            return {
                email: $sanitize(credentials.email),
                password: $sanitize(credentials.password),
                '_token': CSRF_TOKEN
            }
        };
        var sanitizeRegisterCredentials = function (credentials) {
            return {
                fullname: $sanitize(credentials.fullname),
                username: $sanitize(credentials.username),
                email: $sanitize(credentials.email),
                role: $sanitize(credentials.role),
                '_token': CSRF_TOKEN
            }  
        };
        var sanitizeEmail = function (credentials) {
            return {
                email: $sanitize(credentials.email)
            }
        };
        var sanitizeUsername = function (credentials) {
            return {
                username: $sanitize(credentials.username)
            }
        };
        return {
            login: function(credentials) {
                var login = $http.post("/api/auth/login", sanitizeCredentials(credentials));
                login.success(cacheSession);
                login.success(loginSuccess);
                login.error(loginError);
                return login;
            },
            logout: function() {
            	var logout = $http.get("/api/auth/logout");
            	logout.success(uncacheSession);
            	return logout;
            },
            isLoggedIn: function () {
            	return SessionService.get('authenticated');
            },
            register: function (credentials) {
                console.log(sanitizeRegisterCredentials(credentials))
                var register = $http.post("/api/auth/register", sanitizeRegisterCredentials(credentials));
                register.success(registerSuccess);
                register.error(registerError);
                return register;
            },
            validateEmail: function (credentials) {
                var validateEmail = $http.post('/api/auth/register/validate/email', sanitizeEmail(credentials));
                validateEmail.success(function (response) {
                    return true;
                });
                validateEmail.error(registerError);
                return validateEmail;
            },
            validateUsername: function (credentials) {
                var validateUsername = $http.post('/api/auth/register/validate/username', sanitizeUsername(credentials));
                validateUsername.success(function (response) {
                    return true;
                });
                validateUsername.error(registerError);
                return validateUsername;
            }
        }
    });
    app.factory("SessionService", function() {
        return {
            get: function(key) {
                return sessionStorage.getItem(key);
            },
            set: function(key, val) {
                return sessionStorage.setItem(key, val);
            },
            unset: function(key) {
                return sessionStorage.removeItem(key);
            }
        }
    });
    app.factory("FlashService", function($rootScope) {
        return {
            show: function(message, type) {
                $rootScope.flash = message;
                $rootScope.type = type;
                $rootScope.isErrorThrown = true;
            },
            clear: function() {
                $rootScope.flash = "";
                $rootScope.isErrorThrown = false;
            }
        }
    });
    return app;
});