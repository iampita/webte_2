myApp.controller('calendarDynamicCtrl', function($scope, Calendar, $http){
    $scope.userMap = [];
    
    $scope.lock = false;
    
    Calendar.init($scope);
    
    $scope.mouseDown = false;
    $scope.md = function(){
        $scope.mouseDown = true;
    }
    $scope.mu = function(){
        $scope.mouseDown = false;
    }
    $scope.applyAbsenceOption = function(ev, parent, child){
        if(($scope.employees[parent].id == $scope.userId && $scope.editPlan) || $scope.editAll){
            if($scope.absenceOptions[0]){
                if($scope.mouseDown && ev.currentTarget.className.includes('red') || ev.type === 'click' && ev.currentTarget.className.includes('red')){
                    ev.currentTarget.className = ev.currentTarget.className.replace('red',"");
                    $scope.userMap = _.without($scope.userMap, _.findWhere($scope.userMap, {emp: Number($scope.employees[parent].id), year:$scope.selectedYear, month: $scope.selectedMonth.id, day:child, abs:1}));
                    $scope.lock = true;
                }
                else if(ev.type === 'click' && !ev.currentTarget.className.includes('red') && !ev.currentTarget.className.includes('orange') && !ev.currentTarget.className.includes('green') && !ev.currentTarget.className.includes('blue') && !ev.currentTarget.className.includes('grey') || $scope.mouseDown && !ev.currentTarget.className.includes('red') && !ev.currentTarget.className.includes('orange') && !ev.currentTarget.className.includes('green') && !ev.currentTarget.className.includes('blue') && !ev.currentTarget.className.includes('grey')){
                    ev.currentTarget.className += ' red';
                    if (_.findWhere($scope.userMap, {emp: Number($scope.employees[parent].id), year:$scope.selectedYear, month: $scope.selectedMonth.id, day:child, abs:1}) == null) {
                        $scope.userMap.push({emp: Number($scope.employees[parent].id), year:$scope.selectedYear, month: $scope.selectedMonth.id, day:child, abs:1});
                    }
                }
            }
            else if($scope.absenceOptions[1]){
                if($scope.mouseDown && ev.currentTarget.className.includes('orange') || ev.type === 'click' && ev.currentTarget.className.includes('orange')){
                    ev.currentTarget.className = ev.currentTarget.className.replace('orange',"");
                    $scope.userMap = _.without($scope.userMap, _.findWhere($scope.userMap, {emp: Number($scope.employees[parent].id), year:$scope.selectedYear, month: $scope.selectedMonth.id, day:child, abs:2})); 
                    $scope.lock = true;
                }
                else if(ev.type === 'click' && !ev.currentTarget.className.includes('red') && !ev.currentTarget.className.includes('orange') && !ev.currentTarget.className.includes('green') && !ev.currentTarget.className.includes('blue') && !ev.currentTarget.className.includes('grey') || $scope.mouseDown && !ev.currentTarget.className.includes('red') && !ev.currentTarget.className.includes('orange') && !ev.currentTarget.className.includes('green') && !ev.currentTarget.className.includes('blue') && !ev.currentTarget.className.includes('grey')){
                    ev.currentTarget.className += ' orange';
                    if (_.findWhere($scope.userMap, {emp: Number($scope.employees[parent].id), year:$scope.selectedYear, month: $scope.selectedMonth.id, day:child, abs:2}) == null) {
                            $scope.userMap.push({emp: Number($scope.employees[parent].id), year:$scope.selectedYear, month: $scope.selectedMonth.id, day:child, abs:2});
                    }
                }
            }
            else if($scope.absenceOptions[2]){
                if($scope.mouseDown && ev.currentTarget.className.includes('green') || ev.type === 'click' && ev.currentTarget.className.includes('green')){
                    ev.currentTarget.className = ev.currentTarget.className.replace('green',"");
                    $scope.userMap = _.without($scope.userMap, _.findWhere($scope.userMap, {emp: Number($scope.employees[parent].id), year:$scope.selectedYear, month: $scope.selectedMonth.id, day:child, abs:3})); 
                    $scope.lock = true;
                }
                else if(ev.type === 'click' && !ev.currentTarget.className.includes('red') && !ev.currentTarget.className.includes('orange') && !ev.currentTarget.className.includes('green') && !ev.currentTarget.className.includes('blue') && !ev.currentTarget.className.includes('grey') || $scope.mouseDown && !ev.currentTarget.className.includes('red') && !ev.currentTarget.className.includes('orange') && !ev.currentTarget.className.includes('green') && !ev.currentTarget.className.includes('blue') && !ev.currentTarget.className.includes('grey')){
                    ev.currentTarget.className += ' green';
                    if (_.findWhere($scope.userMap, {emp: Number($scope.employees[parent].id), year:$scope.selectedYear, month: $scope.selectedMonth.id, day:child, abs:3}) == null) {
                            $scope.userMap.push({emp: Number($scope.employees[parent].id), year:$scope.selectedYear, month: $scope.selectedMonth.id, day:child, abs:3});
                    }
                }
            }
            else if($scope.absenceOptions[3]){
                if($scope.mouseDown && ev.currentTarget.className.includes('blue') || ev.type === 'click' && ev.currentTarget.className.includes('blue')){
                    ev.currentTarget.className = ev.currentTarget.className.replace('blue',"");
                    $scope.userMap = _.without($scope.userMap, _.findWhere($scope.userMap, {emp: Number($scope.employees[parent].id), year:$scope.selectedYear, month: $scope.selectedMonth.id, day:child, abs:4})); 
                    $scope.lock = true;
                }
                else if(ev.type === 'click' && !ev.currentTarget.className.includes('red') && !ev.currentTarget.className.includes('orange') && !ev.currentTarget.className.includes('green') && !ev.currentTarget.className.includes('blue') && !ev.currentTarget.className.includes('grey') || $scope.mouseDown && !ev.currentTarget.className.includes('red') && !ev.currentTarget.className.includes('orange') && !ev.currentTarget.className.includes('green') && !ev.currentTarget.className.includes('blue') && !ev.currentTarget.className.includes('grey')){
                    ev.currentTarget.className += ' blue';
                    if (_.findWhere($scope.userMap, {emp: Number($scope.employees[parent].id), year:$scope.selectedYear, month: $scope.selectedMonth.id, day:child, abs:4}) == null) {
                            $scope.userMap.push({emp: Number($scope.employees[parent].id), year:$scope.selectedYear, month: $scope.selectedMonth.id, day:child, abs:4});
                    }
                }
            }
            else if($scope.absenceOptions[4]){
                if($scope.mouseDown && ev.currentTarget.className.includes('grey') || ev.type === 'click' && ev.currentTarget.className.includes('grey')){
                    ev.currentTarget.className = ev.currentTarget.className.replace('grey',"");
                    $scope.userMap = _.without($scope.userMap, _.findWhere($scope.userMap, {emp: Number($scope.employees[parent].id), year:$scope.selectedYear, month: $scope.selectedMonth.id, day:child, abs:5}));
                    $scope.lock = true;
                }
                else if(ev.type === 'click' && !ev.currentTarget.className.includes('red') && !ev.currentTarget.className.includes('orange') && !ev.currentTarget.className.includes('green') && !ev.currentTarget.className.includes('blue') && !ev.currentTarget.className.includes('grey') || $scope.mouseDown && !ev.currentTarget.className.includes('red') && !ev.currentTarget.className.includes('orange') && !ev.currentTarget.className.includes('green') && !ev.currentTarget.className.includes('blue') && !ev.currentTarget.className.includes('grey')){
                    ev.currentTarget.className += ' grey';
                    if (_.findWhere($scope.userMap, {emp: Number($scope.employees[parent].id), year:$scope.selectedYear, month: $scope.selectedMonth.id, day:child, abs:5}) == null) {
                            $scope.userMap.push({emp: Number($scope.employees[parent].id), year:$scope.selectedYear, month: $scope.selectedMonth.id, day:child, abs:5});
                    }
                }
            }
        }
    }
    $scope.selectedOption = "";
    $scope.changeAbsenceOption = function(ev){
        if($scope.editAll){
       if(ev.currentTarget.className.includes('red')){
           $scope.selectedOption = "PN";
           for(var i = 0; i < 5; i++){
               if(i == 0)
                   $scope.absenceOptions[i] = true;
               else
                   $scope.absenceOptions[i] = false;
           }
       }
        else if(ev.currentTarget.className.includes('orange')){
            $scope.selectedOption = "OČR";
           for(var i = 0; i < 5; i++){
               if(i == 1)
                   $scope.absenceOptions[i] = true;
               else
                   $scope.absenceOptions[i] = false;
           }
       }
        else if(ev.currentTarget.className.includes('green')){
            $scope.selectedOption = "Služobná cesta";
           for(var i = 0; i < 5; i++){
               if(i == 2)
                   $scope.absenceOptions[i] = true;
               else
                   $scope.absenceOptions[i] = false;
           }
       }
        else if(ev.currentTarget.className.includes('blue')){
            $scope.selectedOption = "Dovolenka";
           for(var i = 0; i < 5; i++){
               if(i == 3)
                   $scope.absenceOptions[i] = true;
               else
                   $scope.absenceOptions[i] = false;
           }
       } 
        else if(ev.currentTarget.className.includes('grey')){
            $scope.selectedOption = "Plán dovolenky";
           for(var i = 0; i < 5; i++){
               if(i == 4)
                   $scope.absenceOptions[i] = true;
               else
                   $scope.absenceOptions[i] = false;
           }
       } 
        }
        else if($scope.editPlan){
            if(ev.currentTarget.className.includes('grey')){
                $scope.selectedOption = "Plán dovolenky";
               for(var i = 0; i < 5; i++){
                   if(i == 4)
                       $scope.absenceOptions[i] = true;
                   else
                       $scope.absenceOptions[i] = false;
               }
           } 
        }
    }
    
    $scope.absenceOptions = [false,false,false,false,false];
    $scope.createData = function(data) {
        var toSend = [];
        for(var i = 0; i < data.length; i++){
            var date;
            if(data[i].month < 10 && data[i].day+1 < 10)
                date = data[i].year + "-" + "0" + data[i].month + "-" + "0" + (data[i].day + 1);
            else if(data[i].month < 10)
                date = data[i].year + "-" + "0" + data[i].month + "-" + (data[i].day + 1);
            else if((data[i].day+1) < 10)
                date = data[i].year + "-" + data[i].month + "-" + "0" + (data[i].day + 1);
            else
                date = data[i].year + "-" + data[i].month + "-" + (data[i].day + 1);
            
            toSend.push({staff_id: data[i].emp, absence_id: data[i].abs, dateAtr: date});
        }
        if($scope.selectedMonth.id < 10){
            toSend.push({from: $scope.selectedYear + "-" + "0" + $scope.selectedMonth.id + "-" + "01", to: $scope.selectedYear + "-" + "0" + $scope.selectedMonth.id + "-" + $scope.days.length});
        }
        else{
            toSend.push({from: $scope.selectedYear + "-" + $scope.selectedMonth.id + "-" + "01", to: $scope.selectedYear + "-" + $scope.selectedMonth.id + "-" + $scope.days.length});
        }
        return toSend;
    }
    $scope.save = function(){
        
        var data = $scope.createData($scope.userMap);
//        console.log(data);
        var request = $http({
            method: "post",
            url: "../../server/post-calendar-data.php",
            data: data,
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        });
        window.location.reload();
    }
    
    $scope.showModal = false;
    $scope.buttonClicked;
    $scope.toggleModal = function(btnClicked){
        if($scope.editAll){
            $scope.buttonClicked = btnClicked;
            $scope.showModal = !$scope.showModal;
        }
        else if($scope.editPlan && $scope.employees[btnClicked].id == $scope.userId){
            $scope.buttonClicked = btnClicked;
            $scope.showModal = !$scope.showModal;
        } 
    };
});
