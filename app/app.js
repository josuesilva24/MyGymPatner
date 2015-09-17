var app = angular.module('myApp', ['ngRoute', 'ngAnimate', 'toaster']);

app.config(['$routeProvider',
        function($routeProvider) {
            $routeProvider.
            when('/login', {
                    title: 'Login',
                    templateUrl: 'login.html',
                    controller: 'authCtrl'
                })
                .when('/logout', {
                    title: 'Logout',
                    templateUrl: 'login.html',
                    controller: 'logoutCtrl'
                })
                .when('/signup', {
                    title: 'Signup',
                    templateUrl: 'partials/signup.html',
                    controller: 'authCtrl'
                })
                .when('/dashboard', {
                    title: 'Dashboard',
                    templateUrl: 'dashboard.html',
                    controller: 'dashboardCtrl'
                })
                .when('/', {
                    title: 'Login',
                    templateUrl: 'login.html',
                    controller: 'authCtrl',
                    role: '0'
                })
                .otherwise({
                    redirectTo: '/login'
                });
        }
    ])
    .run(function($rootScope, $location, Data) {


        $rootScope.Logout = function() {
            Data.get('logout').then(function(results) {
                if (results.status == 200) {
                    $location.path('/login');
                }
            });
        };

        $rootScope.$on("$routeChangeStart", function(event, next, current) {
            Data.get('session').then(function(results) {
                if (results.data) {
                    results = results.data;
                    if (results.uid) { //para login test dejar en true
                        $rootScope.authenticated = true;
                        $rootScope.uid = results.uid;
                        $rootScope.name = results.name;
                        $rootScope.email = results.email;
                        $rootScope.email2 = "results.email";
                        $location.path("/dashboard");
                    } else {
                        var nextUrl = next.$$route.originalPath;
                        $rootScope.authenticated = false;

                        if (nextUrl == '/signup' || nextUrl == '/login') {

                        } else {
                            $location.path("/login");
                        }
                    }
                }
            });
        });
    });
