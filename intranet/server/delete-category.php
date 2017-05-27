<?php require __DIR__.'/functions.php' ?>
<?php
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

    $dbh = connect_to_db();
    deleteCategory($dbh, $request->pageName, $request->name, $request->description, $request->fileName);
    $categories = fetchCategories($dbh, $request->pageName);
    echo json_encode($categories);
?> 