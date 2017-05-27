<?php

 include_once('../../config.php');

    session_start();
    $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            }
        mysqli_set_charset($conn,"utf8");

    $editor_data = $_POST[ 'editor1' ];

    if(isset($_POST['editor1'])){
    $sql="UPDATE nakupy SET content = '".$editor_data."' WHERE id=1";

    $conn->query($sql);
}
?>
<!doctype html>
<html ng-app="intranet">
<head>
    <meta charset="UTF-8">
    
    <title>Intranet</title>
    
    <link rel=stylesheet type=text/css href="css/reset.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="http://underscorejs.org/underscore-min.js"></script>
    <script src="https://code.angularjs.org/latest/angular.min.js"></script>
    <script src="app/intranet/intranet.js"></script>
    <script src="app/intranet/servis.js"></script>
<script src="//cdn.ckeditor.com/4.7.0/basic/ckeditor.js"></script>
    <style>
        .ikonka{
            font-size:20px;
            color:darkgreen;
        }
        .role:hover{
            cursor: pointer;
        }
    </style>
</head>
<body ng-controller="mainCtrl">
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="../client/intranet.html" ng-click="panel = true">Intranet</a>
            </div>
            <ul class="nav navbar-nav navbar-right" ng-show="!loggedOut"> 
                <li><a href="../../profile.php?id=<?php echo $_SESSION['username']; ?>"><?php echo $_SESSION['username']; ?></a></li>
                <li><a href="" ng-click="logOut()">logout</a></li>
                
            </ul>
            <ul class="nav navbar-nav navbar-right"> 
                <li><a href="../../index.php">Domov</a></li>
                
            </ul>
            <ul class="nav navbar-nav" ng-show="!loggedOut && firstFour">
                <li><a href="">Pedagogika</a></li>
                <li><a href="">Doktorandi</a></li>
                <li><a href="">Publikácie</a></li>
                <li><a href="">Služobné cesty</a></li>
            </ul>
            <ul class="nav navbar-nav" ng-show="!loggedOut && purchases">
                <li><a href="../client/nakupy.php">Nákupy</a></li>
            </ul>
            <ul class="nav navbar-nav" ng-show="!loggedOut && attendance">
                <li><a href="../z1/client/index.html">Dochádzka</a></li>
            </ul>
            
        </div>
</nav>
    <form action="" method="post" >

    <textarea cols="80" id="editor1" name="editor1" rows="10" width="80%">  


<?php

    $sql2 = "SELECT * FROM nakupy";
    $result = $conn->query($sql2);
while($row=$result->fetch_assoc()){
    
        echo $row['content'];
    }

?>

    </textarea>

        <p>
        <?php if(isset($_SESSION['username'])){

          
          echo ' <input value="Ulož" type="submit">';

        }
        ?>
        </p>
    </form>

    <script>
        CKEDITOR.replace( 'editor1' );

    </script>
</html>

