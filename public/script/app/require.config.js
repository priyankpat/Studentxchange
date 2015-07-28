'use strict';

require.config({
	paths: {
		jquery: '../../script/vendor/jquery/jquery-1.11.3.min',
		angular: '../../script/vendor/angular/angular.min',
		angularAnimate: '../../script/vendor/angular/angular-animate.min',
		angularRouter: '../../script/vendor/angular/angular-ui-router',
		angularSanitize: '../../script/vendor/angular/angular-sanitize.min',
		underscore: '../../script/vendor/underscore/underscore-min',
		ngMap: '../../script/vendor/angular/ng-map.min',
		async: '../../script/vendor/async/async',
		iScroll: '../../script/vendor/iscroll/iscroll',
		ngIScroll: '../../script/vendor/iscroll/ng-iscroll.min',
		owlCarousel: '../vendor/owlcarousel/owl.carousel.min',
		appFactory: 'factory',
		app: 'app'

	},
	shim: {
		angular: {
			exports: 'angular'
		},
		angularRouter: ['angular'],
		angularAnimate: ['angular'],
		angularSanitize: ['angular'],
		ngMap: ['angular'],
		iScroll: {
			exports: 'Iscroll'
		},
		ngIScroll: {
			deps: ['iScroll', 'angular'],
		},
		owlCarousel: {
			deps: ['jquery']
		}
	},
	priotity: ['angular', 'iScroll', 'ngIScroll', 'app']
})

require([
	'angular',
	'app',
	'jquery'
], function (angular, app) {
	angular.element().ready(function () {
		log('Angular Ready');
		angular.bootstrap(document, ['SXC']);
	});
});