<?php
    session_start();
    if($_SESSION['username']){
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($_SESSION, JSON_UNESCAPED_UNICODE); 
    }
    else{
        echo "home";
    } 
?>
