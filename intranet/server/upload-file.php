<?php require __DIR__.'/functions.php' ?>
<?php
    $target_dir = "../../aktivity/" . $_POST['folder'];
    $target_file = $target_dir . '/' . basename($_FILES["file"]["name"]);
    mkdir($target_dir);
    move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

    $dbh = connect_to_db();
    $event = fetchEvent($dbh, $_POST['date'], $_POST['skTitle']);
    if(!$event)
        insertEvent($dbh, $_POST['date'], $_POST['skTitle'], $_POST['enTitle'], $_POST['folder']); 
//    $dir    = './';
//    $files = scandir($dir);
//    $filesToSend = array();
//    for($i = 0; $i< count($files); $i++){
//        if (strpos($files[$i], '.txt')) {
//            array_push($filesToSend, $files[$i]);
//        }
//    }
    echo json_encode($event);

?>