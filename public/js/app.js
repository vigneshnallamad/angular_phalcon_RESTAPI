angular.module('userApp',['ui.router','ngResource','userApp.controllers','userApp.services']);

angular.module('userApp').config(function($stateProvider,$httpProvider,$locationProvider){
    $stateProvider.state('users',{
        url:'/users',
        templateUrl:'partials/users.html',
        controller:'UserListController'
    }).state('viewUser',{
       url:'/users/:id/view',
       templateUrl:'partials/user-view.html',
       controller:'UserViewController'
    }).state('newUser',{
        url:'/users/new',
        templateUrl:'partials/user-add.html',
        controller:'UserCreateController'
    }).state('editUser',{
        url:'/users/:id/edit',
        templateUrl:'partials/user-edit.html',
        controller:'UserEditController'
    });
    // $locationProvider.html5Mode(true);
}).run(function($state){
   $state.go('users');
});