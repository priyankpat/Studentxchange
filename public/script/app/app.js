'use strict';
define(['angular', 'angularRouter', 'angularAnimate', 'angularSanitize', 'underscore', 'ngMap', 'async!http://maps.google.com/maps/api/js', 'iScroll', 'ngIScroll'], function(angular, angularRouter, angularAnimate, angularSanitize, _, ngMap, iScroll, ngISCroll) {
    var app = angular.module('SXC', ['ui.router', 'ngAnimate', 'ngSanitize', 'ngMap', 'ng-iscroll']);
    app.constant("CSRF_TOKEN", getMetaContent("csrf_token"));
    app.run(function($rootScope, $location, $state, $timeout, AuthenticationService, FlashService) {

        var routesThatRequireAuth = ['/dashboard', '/dashboard/home', '/dashboard/library', '/dashboard/listings', '/dashboard/profile'];
        $rootScope.$on('$stateChangeStart', function() {
   			console.log("starting")
        });

        $rootScope.$on('$stateChangeSuccess', function () {
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
            }).state('dashboard.profile', {
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
            $httpProvider.defaults.headers.post['Content-Type'] = 'application/json; charset=utf-8';
        }
    ]);
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
    app.controller('DashboardController', function ($scope, $location, $timeout, $state, AuthenticationService, FlashService) {
    	$scope.$parent.myScrollOptions = {
    		snap: false,
    		mouseWheel: true
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
        }
        var sanitizeCredentials = function(credentials) {
            return {
                email: $sanitize(credentials.email),
                password: $sanitize(credentials.password),
                'X-CSRF-TOKEN': CSRF_TOKEN
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