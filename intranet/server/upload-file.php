<?php require __DIR__.'/functions.php' ?>
<?php
    if(!$_POST['pageName']){
        $target_dir = "../../aktivity/" . $_POST['folder'];
        $target_file = $target_dir . '/' . basename($_FILES["file"]["name"]);
        mkdir($target_dir);
        move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

        $dbh = connect_to_db();
        $event = fetchEvent($dbh, $_POST['date'], $_POST['skTitle']);
        if(!$event)
            insertEvent($dbh, $_POST['date'], $_POST['skTitle'], $_POST['enTitle'], $_POST['folder']);
        echo json_encode($_POST);
    }
    else {
        $target_dir = "../../uploadedFiles/";
        $target_file = $target_dir .  basename($_FILES["file"]["name"]);
        move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

        $dbh = connect_to_db();
        insertCategory($dbh, $_POST['pageName'], $_POST['title'], $_POST['desc'], basename($_FILES["file"]["name"]));
        $categories = fetchCategories($dbh, $_POST['pageName']);
        echo json_encode($categories);
    }

?>