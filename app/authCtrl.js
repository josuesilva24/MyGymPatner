app.controller('authCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data) {
    //initially set those objects to null to avoid undefined error
    $scope.login = {};
    $scope.signup = {};
    
    $scope.doLogin = function (customer) {
       Data.get( 'login&id=' + 1).then(function (results) {
            if (results.status == 200) {
                Data.toast(results);
                $location.path('dashboard');
            }
        });
    };
    $scope.signup = {email:'',password:'',name:'',phone:'',address:''};
    $scope.signUp = function (customer) {
        Data.post('session', {
            id: 1
        }).then(function (results) {
            Data.toast(results);
            if (results.status == 200) {
                $location.path('dashboard');
            }
        });
    };
    $scope.logout = function () {
        Data.get('logout').then(function (results) {
            Data.toast(results);
            $location.path('login');
        });
    }
});