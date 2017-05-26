var intranet = angular.module('intranet',[]);

intranet.controller('mainCtrl',function($scope, $http, fileUpload){
    $http({
        method: "get",
        url: "../server/checksessions.php"
    }).then(function(resp){
        if(resp.data == "home"){
            $scope.loggedOut = 'true';
        }
        else{
            setPrivilegies(resp.data, 2);
        }
    });
    
    function setPrivilegies(data, state){
        if(state == 2){
            $scope.login = data.username;
            $scope.loggedOut = false;
        }
        var roles = data.roles;
        $scope.firstFour = false;
        $scope.purchases = false;
        $scope.attendance = true;
        $scope.userEdit = false;
        $scope.roleEdit = false;
        $scope.mediaUpload = false;
        
        if(_.findWhere(roles, {roles_id: "1"})){
            $scope.firstFour = true;
            $scope.purchases = true;
        }
        if(_.findWhere(roles, {roles_id: "2"})){
            getUsers();
            $scope.userEdit = true;
        }
        if(_.findWhere(roles, {roles_id: "3"})){
            $scope.mediaUpload = true;
        }
        if(_.findWhere(roles, {roles_id: "4"})){
            $scope.firstFour = true;
        }
        if(_.findWhere(roles, {roles_id: "5"})){
            $scope.firstFour = true;
            $scope.purchases = true;
            $scope.userEdit = true;
            $scope.roleEdit = true;
            $scope.mediaUpload = true;
            getUsers();
            getUserRoles();
        }
    }
    function getUserRoles(){
        $http.get('../server/get-user-roles.php').then(function(resp){
            $scope.userRoles = [];
            var unique = _.uniq(resp.data, function(rec){
                return rec.staff_id;
            });
            for(var i = 0; i < unique.length; i++){
                var roles = _.filter(resp.data, {staff_id: unique[i].staff_id});
                $scope.userRoles.push({staff_id: unique[i].staff_id, roles: []});
                if(_.findWhere(roles, {roles_id: "1"})){
                    $scope.userRoles[i].roles.push(true);
                }
                else
                    $scope.userRoles[i].roles.push(false);
                if(_.findWhere(roles, {roles_id: "2"})){
                    $scope.userRoles[i].roles.push(true);
                }
                else
                    $scope.userRoles[i].roles.push(false);
                if(_.findWhere(roles, {roles_id: "3"})){
                    $scope.userRoles[i].roles.push(true);
                }
                else
                    $scope.userRoles[i].roles.push(false);
                if(_.findWhere(roles, {roles_id: "4"})){
                    $scope.userRoles[i].roles.push(true);
                }
                else
                    $scope.userRoles[i].roles.push(false);
                if(_.findWhere(roles, {roles_id: "5"})){
                    $scope.userRoles[i].roles.push(true);
                }
                else
                    $scope.userRoles[i].roles.push(false);
            }
            $http.get('../server/get-users.php').then(function(resp){
                var logins = [];
                for(var i = 0; i < resp.data.length; i++){
                    if(resp.data[i].ldapLogin)
                        logins.push(resp.data[i]);
                }
                for(var i = 0; i < unique.length; i++){
                    logins = _.without(logins, _.findWhere(logins, {id: $scope.userRoles[i].staff_id}));
                }
                for(var i = 0; i < logins.length; i++){
                    $scope.userRoles.push({staff_id: logins[i].id, roles: []});
                    for(var j = 0; j < 5; j++){
                        $scope.userRoles[i].roles.push(false);
                    }
                }
                console.log($scope.userRoles);
            });
        }); 
    }  
    $scope.setRole = function(index, secondIndex, value){
        $scope.userRoles[index].roles[secondIndex] = value;
    }
    
    $scope.saveRoles = function(index){
        var staff_id = $scope.userRoles[index].staff_id;
        var roles = $scope.userRoles[index].roles;
        var data = [];
        for (i = 0; i < roles.length; i++){
            if(roles[i])
                data.push({staffId: staff_id, rolesId: i + 1});
        }
        $http.post('../server/post-user-roles-change.php', data).then(function(resp){
        });
    }
    function getUsers(){
        $http.get('../server/get-users.php').then(function(resp){
            $scope.staff = resp.data;
            $scope.panel = true;
        });
    }
    $scope.saveChanges = function(index){
        $http.post('../server/post-user-changes.php',$scope.staff[index]).then(function(resp){
        });
    }
    $scope.password = "";
    
    $scope.login = "";
    
    $scope.logOut = function(){
        $http({
            method: "get",
            url: "../server/logout.php"
        }).then(function(resp){
            $scope.loggedOut = true;
            $scope.panel = false;
        });
    }
    
    
    function setPage(data){
        if(data.loginState == "wrongLogin"){
            $scope.loginState = "wrongLogin";
        }
        else if(data.loginState == "wrongPass"){
            $scope.loginState = "wrongPass";
        }
        else if(data.loginState == "loginOK" || data.loginState == "alreadyLoggedIn"){
            $scope.loggedOut = false;
            setPrivilegies(data, 1);
        }
    }
    $scope.submit = function(type){
        var API = type;
        $http({
            method: "post",
            url: "../server/" + API + ".php",
            data: {login: $scope.login, password: $scope.password},
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function(resp){
            setPage(resp.data);
        });
    }
    
    $scope.fileForm = {};
    $scope.fileForm.folderName = "";
    $scope.fileForm.enTitle = "";
    $scope.fileForm.skTitle = "";
    $scope.fileForm.date = "RRRR-MM-DD";
    
    $scope.uploadFile = function () {
        var file = $scope.myFile; 

        var uploadUrl = "../server/upload-file.php";
        fileUpload.uploadFileToUrl(file, uploadUrl, $scope.fileForm, $scope);
    };
    
    $scope.videoForm = {};
    $scope.videoForm.title = "";
    $scope.videoForm.url = "";
    $scope.videoForm.type = "";
    $scope.saveVideo = function(){
        $http.post('../server/save-video.php',{title: $scope.videoForm.title, url:$scope.videoForm.url, type: $scope.videoForm.type }).then(function(resp){
            console.log(resp);
        });
    }
});