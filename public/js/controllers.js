angular.module('userApp.controllers',['naif.base64']).controller('UserListController',function($scope,$state,popupService,$window,User){

    $scope.users=User.query();

    $scope.deleteUser=function(user){
        if(popupService.showPopup('Really delete this?')){
            user.$delete(function(){
                $window.location.href='';
            });
        }
    }

}).controller('UserViewController',function($scope,$stateParams,User){

    $scope.user=User.get({id:$stateParams.id});

}).controller('UserCreateController',function($scope,$state,popupService,$stateParams,User){

    $scope.user=new User();
    $scope.newUser = true;
    $scope.user.gender = "male";
    $scope.user.hobby = [];
    $scope.hobbyList = ["sports", "travelling", "surfing"];

    $scope.isChecked = function(id){
        var match = false;
        for(var i=0 ; i < $scope.user.hobby.length; i++) {
            if($scope.user.hobby[i] == id) {
                match = true;
            }
        }
        return match;
    };

    $scope.allOptions = ["sports", "travelling", "surfing"];

    $scope.sync = function(bool, item){
        if(bool){
            // add item
            $scope.user.hobby.push(item);
        } else {
            // remove item
            for(var i=0 ; i < $scope.user.hobby.length; i++) {
                if($scope.user.hobby[i] == item.id){
                    $scope.user.hobby.splice(i,1);
                }
            }      
        }
    };

    $scope.addUser=function(){
        if ($scope.user.password != $scope.user.confirmPassword) {
            popupService.showPopup('Passwords should match.');
        } else if (!$scope.user.hobby.length) {
            popupService.showPopup('Select atleast one hobby.');
        } else {
            $scope.user.$save(function(data){
                if (data.status == "error") {
                    console.log(data);
                    popupService.showPopup('Data error!!');
                } else {
                    $state.go('users');
                }
            });
        }
    }

}).controller('UserEditController',function($scope,$state,popupService,$stateParams,User){
    
    $scope.loadUser = function() {
        $scope.user=User.get({id:$stateParams.id});
    }

    $scope.loadUser();

    $scope.updateUser=function(){
        if ($scope.user.hobby.length) {
            $scope.user.$update(function(data){
                if (data.status == "error") {
                    console.log(data);
                    popupService.showPopup('Data error!!');
                } else {
                    $state.go('users');
                }
            });            
        } else {
            popupService.showPopup('Select atleast one hobby.');
        }
    };

    $scope.isChecked = function(id){
        var match = false;
        try {
            for(var i=0 ; i < $scope.user.hobby.length; i++) {
                if($scope.user.hobby[i] == id) {
                    match = true;
                }
            }
        } catch(e) {

        }
        return match;
    };

    $scope.allOptions = ["sports", "travelling", "surfing"];

    $scope.sync = function(bool, item){
        if(bool){
            // add item
            $scope.user.hobby.push(item);
        } else {
            // remove item
            for(var i=0 ; i < $scope.user.hobby.length; i++) {
                if($scope.user.hobby[i] == item){
                    $scope.user.hobby.splice(i,1);
                }
            }      
        }
    };

});