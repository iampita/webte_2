<?php
require __DIR__.'/config.php';

function fetchAllStaff( $conn ){
    $request = $conn->prepare(" SELECT id, name, surname, title1, title2, ldapLogin, room, phone, department, staffRole, function FROM staff");
    $request->setFetchMode(PDO::FETCH_ASSOC);
    return $request->execute() ? $request->fetchAll() : false;
}

function fetchStaff( $conn, $login ){
    $request = $conn->prepare(" SELECT id FROM staff where ldapLogin = :login");
    $request->setFetchMode(PDO::FETCH_ASSOC);
    return $request->execute(array(':login' => $login)) ? $request->fetch() : false;
}

function fetchStaffRoles($conn, $id){
    $request = $conn->prepare(" SELECT roles_id FROM staff_roles where staff_id = :id");
    $request->bindParam(':id', $id);
    $request->setFetchMode(PDO::FETCH_ASSOC);
    return $request->execute() ? $request->fetchAll() : false;
//    return $request->execute(array(':id' => $id)) ? $request->fetch() : false;
}
function fetchStaffAbs($conn){
    $request = $conn->prepare(" SELECT staff_id, absence_id, date FROM staff_absence");
    $request->setFetchMode(PDO::FETCH_ASSOC);
    return $request->execute() ? $request->fetchAll() : false;
//    return $request->execute(array(':id' => $id)) ? $request->fetch() : false;
}

function updateStaff($conn, $id, $name, $surname, $title1, $title2, $ldapLogin, $room, $phone, $department, $staffRole, $function){
    $stmt = $conn->prepare("update staff set name = :name, surname = :surname, title1 = :title1, title2 = :title2, ldapLogin = :ldapLogin, room = :room, phone = :phone, department = :department, staffRole = :staffRole, function = :function where id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':surname', $surname);
    $stmt->bindParam(':title1', $title1);
    $stmt->bindParam(':title2', $title2);
    $stmt->bindParam(':ldapLogin', $ldapLogin);
    $stmt->bindParam(':room', $room);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':department', $department);
    $stmt->bindParam(':staffRole', $staffRole);
    $stmt->bindParam(':function', $function);
    $stmt->execute();
}
function fetchRoles($conn){
    $request = $conn->prepare(" SELECT id, staff_id, roles_id FROM staff_roles");
    $request->setFetchMode(PDO::FETCH_ASSOC);
    return $request->execute() ? $request->fetchAll() : false;
}
function deleteRoles($conn, $staffId){
    $stmt = $conn->prepare("delete from staff_roles where staff_id = :staffId");
    $stmt->bindParam(':staffId', $staffId);
    $stmt->execute();
    
}
function insertRoles($conn, $staffId, $rolesId){
    $stmt = $conn->prepare("INSERT INTO staff_roles (staff_id, roles_id) VALUES (:staffId, :rolesId)");
    $stmt->bindParam(':staffId', $staffId);
    $stmt->bindParam(':rolesId', $rolesId);
    $stmt->execute();
}

function insertEvent($conn, $date, $skTitle, $enTitle, $folder){
    $stmt = $conn->prepare("INSERT INTO event (Date, `Title-SK`, `Title-EN`, Folder) VALUES (:date, :skTitle, :enTitle, :folder)");
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':skTitle', $skTitle);
    $stmt->bindParam(':enTitle', $enTitle);
    $stmt->bindParam(':folder', $folder);
    $stmt->execute(); 
}
function fetchEvent($conn, $date, $skTitle){
    $request = $conn->prepare(" SELECT id FROM event where Date = :date and `Title-SK` = :skTitle");
    $request->bindParam(':date', $date);
    $request->bindParam(':skTitle', $skTitle);
    $request->setFetchMode(PDO::FETCH_ASSOC);
    return $request->execute() ? $request->fetchAll() : false;
}
function saveVideo($conn, $title, $url, $type){
    $stmt = $conn->prepare("INSERT INTO video (name, url, type) VALUES (:title, :url, :type)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':url', $url);
    $stmt->bindParam(':type', $type);
    $stmt->execute(); 
}
//function fetchStaffRoles( $conn ){
//    $request = $conn->prepare(" SELECT employee_absence.employee_id, employee_absence.absence_id, employee_absence.date FROM employee join employee_absence on employee.id = employee_absence.employee_id join absence on employee_absence.absence_id = absence.id");
//    $request->setFetchMode(PDO::FETCH_ASSOC);
//    return $request->execute() ? $request->fetchAll() : false;
//}

function createStaffAbsRecord($conn, $empId, $absId, $date){
    $stmt = $conn->prepare("INSERT INTO staff_absence (staff_id, absence_id, date) VALUES (:staff_id, :absence_id, :date)");
    $stmt->bindParam(':staff_id', $empId);
    $stmt->bindParam(':absence_id', $absId);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
}
function deleteOldMonth($conn, $from, $to){
    $stmt = $conn->prepare("delete from staff_absence where date >= :from && date <= :to");
    $stmt->bindParam(':from', $from);
    $stmt->bindParam(':to', $to);
    $stmt->execute();
}