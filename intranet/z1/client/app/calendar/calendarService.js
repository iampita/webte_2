myApp.service('Calendar',function($http){
    var service = {};
    service.init = function(scope){
        scope.year = year;
        scope.month = month;
        
        scope.editPlan = false;
        scope.editAll = false;
        $http.get('../../server/checksessions.php').then(function(resp){
            var roles = resp.data.roles;
            if(_.findWhere(roles, {roles_id: "1"})){
                scope.editPlan = true;
            }
            if(_.findWhere(roles, {roles_id: "2"})){
                scope.editPlan = true;
                scope.editAll = true;
            }
            if(_.findWhere(roles, {roles_id: "5"})){
                scope.editPlan = true; 
                scope.editAll = true;
            }
            scope.userId = resp.data.id.id;
            console.log(scope.userId);
        });
        scope.nameddays = [{name: "Ne"},
                      {name: "Po"},
                      {name: "Ut"},
                      {name: "St"},
                      {name: "Št"},
                      {name: "Pi"},
                      {name: "So"}];
        
        function currentStart(year, month, day, sign){
            if(month < 10)
                month = "0" + month;
            var date = "" + year + "-" + month + "-" + day;
            if(sign === 0)
                return new Date(date).getDay();
            else if(sign === 1){
                return new Date(year, month, 0).getDate();
            }
        }
        
        scope.months = [{name: 'január' , id:1},
                        {name: 'február', id:2},
                        {name: 'marec' , id:3},
                        {name: 'apríl' , id:4},
                        {name: 'máj' , id:5},
                        {name: 'jún' , id:6},
                        {name: 'júl' , id:7},
                        {name: 'august' , id:8},
                        {name: 'september' , id:9},
                        {name: 'október' , id:10},
                        {name: 'november' , id:11},
                        {name: 'december' , id:12}];
        
        scope.years = {};
        //kalendar na 5 rokov dopredu
        for(var i = 0; i <= 5; i++)
            scope.years['_'+(scope.year+i)] = true;
        
        scope.selectedMonth = scope.months[scope.month];
        
        scope.updateStaticTable = function(ev){
            scope.currDay = currentStart(scope.selectedYear, scope.selectedMonth.id, "01", 0);
            scope.days = new Array(currentStart(scope.selectedYear, scope.selectedMonth.id, "01", 1));
            scope.userMap = [];
        }
        
        function fn(yearFrom, monthFrom, daysFrom, currentYear, currentMonth){
            var day = -1;
            if(currentYear == yearFrom){
                if(currentMonth.id == monthFrom){
                    day = daysFrom;
                    return day;
                }
            }
            return day;
        }
        
        function fn1(absence){
            if(absence === '1'){
                return 1;
            }
            else if(absence === '2'){
                return 2;
            }
            else if(absence === '3'){
                return 3;
            }
            else if(absence === '4'){
                return 4;
            }
            else if(absence === '5'){
                return 5;
            }
            return 0;
        }
        
        $http.get("../../server/get-users.php").then(function(resp){
            scope.employees = resp.data || [];
            //console.log(scope.employees);
            console.log(scope.employees);
            return $http.get("../../server/get-staff-abs-records.php");
        }).then(function(resp){
            scope.records = resp.data || [];
            console.log(scope.records);
            scope.userMap = [];
            //pridanie vsetkych rokov z databazy
            for(var i = 0; i < scope.records.length; i++){
                var cutYear = scope.records[i].date.substring(0,4);
                scope.years['_'+ cutYear] = true;
            }
            scope.calYears = [];
            setYears(scope.years, scope.calYears);
            scope.selectedYear = scope.calYears[0];
            scope.currDay = currentStart(scope.selectedYear, scope.selectedMonth.id, "01", 0);
            scope.days = new Array(currentStart(scope.selectedYear, scope.selectedMonth.id, "01", 1));
            scope.getAbsence = function(child,parent){
                for(var i = 0; i < scope.records.length; i++){
                    var currentYear = Number(scope.selectedYear);
                    var currentMonth = scope.selectedMonth;
                    var yearFrom = Number(scope.records[i].date.substring(0,4));
                    
                    var monthFrom = Number(scope.records[i].date.substring(5,7));
                    
                    var daysFrom = (Number(scope.records[i].date.substring(8,10)) - 1);
                    
                    var absence = scope.records[i].absence_id;
                    
                    if(scope.employees[parent] != null){
                        if(scope.employees[parent].id === scope.records[i].staff_id){
                            var day = fn(yearFrom, monthFrom, daysFrom, currentYear, currentMonth);
                            if(child === day){
                                return fn1(absence); 
                            }
                        }
                    }
                }
                return null;
            }
            
            scope.sickLeave = function(child, parent){
                if(scope.getAbsence(child,parent) === 1){
                    if (_.findWhere(scope.userMap, {emp: Number(scope.employees[parent].id), year:scope.selectedYear, month: scope.selectedMonth.id, day:child, abs:1}) == null && !scope.lock) {
                        scope.userMap.push({emp: Number(scope.employees[parent].id), year:scope.selectedYear, month: scope.selectedMonth.id, day:child, abs:1});
                    }
                    return true;
                }
                return false;
            }
            scope.famMemCare = function(child, parent){
                if(scope.getAbsence(child,parent) === 2){
                    if (_.findWhere(scope.userMap, {emp: Number(scope.employees[parent].id), year:scope.selectedYear, month: scope.selectedMonth.id, day:child, abs:2}) == null && !scope.lock) {
                        scope.userMap.push({emp: Number(scope.employees[parent].id), year:scope.selectedYear, month: scope.selectedMonth.id, day:child, abs:2});
                    }
                    return true;
                }
                return false;
            }
            scope.businessTrip = function(child, parent){
                if(scope.getAbsence(child,parent) === 3){
                    if (_.findWhere(scope.userMap, {emp: Number(scope.employees[parent].id), year:scope.selectedYear, month: scope.selectedMonth.id, day:child, abs:3}) == null && !scope.lock) {
                        scope.userMap.push({emp: Number(scope.employees[parent].id), year:scope.selectedYear, month: scope.selectedMonth.id, day:child, abs:3});
                    }
                    return true;
                }
                return false;
            }
            scope.holiday = function(child, parent){
                if(scope.getAbsence(child,parent) === 4){
                    if (_.findWhere(scope.userMap, {emp: Number(scope.employees[parent].id), year:scope.selectedYear, month: scope.selectedMonth.id, day:child, abs:4}) == null && !scope.lock) {
                        scope.userMap.push({emp: Number(scope.employees[parent].id), year:scope.selectedYear, month: scope.selectedMonth.id, day:child, abs:4});
                    }
                    return true;
                }
                return false;
            }
            scope.holidayPlan = function(child, parent){
                if(scope.getAbsence(child,parent) === 5){
                    if (_.findWhere(scope.userMap, {emp: Number(scope.employees[parent].id), year:scope.selectedYear, month: scope.selectedMonth.id, day:child, abs:5}) == null && !scope.lock) {
                        scope.userMap.push({emp: Number(scope.employees[parent].id), year:scope.selectedYear, month: scope.selectedMonth.id, day:child, abs:5});
                    }
                    return true;
                }
                return false;
            }
        });
    }
    function setYears(obj,arr){
        for(var name in obj){
            var newName = name.substring(1,5);
            arr.push(newName);
        }
    }
    return service;
});