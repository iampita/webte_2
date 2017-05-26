<?php
require __DIR__.'/config.php';

function fetchEmployees( $conn ){
    $request = $conn->prepare(" SELECT id, name, surname FROM employee");
    $request->setFetchMode(PDO::FETCH_ASSOC);
    return $request->execute() ? $request->fetchAll() : false;
}

function fetchEmployee( $conn, $id ){
    $request = $conn->prepare(" SELECT id, name, surname FROM employee where id = :id");
    $request->setFetchMode(PDO::FETCH_ASSOC);
    return $request->execute(array(':id' => $id)) ? $request->fetch() : false;
}

function fetchEmpAbs( $conn ){
    $request = $conn->prepare(" SELECT employee_absence.employee_id, employee_absence.absence_id, employee_absence.date FROM employee join employee_absence on employee.id = employee_absence.employee_id join absence on employee_absence.absence_id = absence.id");
    $request->setFetchMode(PDO::FETCH_ASSOC);
    return $request->execute() ? $request->fetchAll() : false;
}

function fetchAbsences( $conn ){
    $request = $conn->prepare(" SELECT id, type FROM absence");
    $request->setFetchMode(PDO::FETCH_ASSOC);
    return $request->execute() ? $request->fetchAll() : false;
}

function fetchAbsence( $conn, $id ){
    $request = $conn->prepare(" SELECT id, type FROM absence where id = :id");
    $request->setFetchMode(PDO::FETCH_ASSOC);
    return $request->execute(array(':id' => $id)) ? $request->fetch() : false;
}

function createEmpAbsRecord($conn, $empId, $absId, $date){
    $stmt = $conn->prepare("INSERT INTO employee_absence (employee_id, absence_id, date) VALUES (:employee_id, :absence_id, :date)");
    $stmt->bindParam(':employee_id', $empId);
    $stmt->bindParam(':absence_id', $absId);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
}
function deleteOldMonth($conn, $from, $to){
    $stmt = $conn->prepare("delete from employee_absence where date >= :from && date <= :to");
    $stmt->bindParam(':from', $from);
    $stmt->bindParam(':to', $to);
    $stmt->execute();
}