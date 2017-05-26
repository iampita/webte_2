<!DOCTYPE html>
<html>
	<head>
		<title>Zadanie 6</title>
		<meta charset="utf-8">
		<!-- <link rel="stylesheet" type="text/css" href="stylesheet.css"> -->
<style>
body{
	margin: 0px;
}
ul {
	margin-top: 0px;
	margin-bottom: 20px;
    list-style-type: none;
    padding: 0;
    overflow: hidden;
    background-color: #333;
    font-size: 14px;
}

li {
    float: left;
}

li:first-child {
    font-size: 18px;  
}

li a {
    display: block;
    color: #9d9d9d;
    text-align: center;
    padding: 15px 16px;
    text-decoration: none;
}

li:first-child a{
    padding: 14px 16px;
}

li a:hover {
    color: white;
}

	form  { display: table;      }
	p     { display: table-row;  }
	label { display: table-cell; }
	input { display: table-cell; }


</style>

	</head>
	<body>
	<ul>
  <li><a class="active" href="../index.php">Home</a></li>
  <li><a href="#news">News</a></li>
  <li><a href="#contact">Contact</a></li>
  <li><a href="#about">About</a></li>
</ul>
<?php
	session_start() ;

	include_once('config.php');
	error_reporting(-1);
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
   		die("Connection failed: " . $conn->connect_error);
		}
	mysqli_set_charset($conn,"utf8");
	
	if(isset($_GET["id"])){
		//$myrights = [false,false,false,false,false];
		//if(isset($_SESSION['myrights'])){
			//$myrights=$_SESSION['myrights'];
		//}
		profil($_GET['id']);
	}	

function profil($id) {
	$update = 0;
	global $conn;
	$sql3 = "SELECT * FROM users WHERE ldap='".$id."'";
	$result = $conn->query($sql3);
		echo '<div class="mmain">';	
	while($row = $result->fetch_assoc()) {

		if(isset($_POST['hidden'])){
			$update=1;
			echo '<img src="../resources/staff_photo/'.$row['photo'].'" width="200"><br>';
			echo " ".$row['name']." ".$row['surname']."";
			echo "<form action='' method='post'> <table class='mtable' style='text-align: center'>";		
			echo "<p><label for='title1'>Titul:</label><input type='text' name='title1' class='mupdateprof' value='".$row['title1']."' ></p>";
			echo "<p><label for='title2'>Titul:</label><input type='text' name='title2' class='mupdateprof' value='".$row['title2']."' ></p>";
			echo "<p><label for='ldapLogin'>Login:</label><input type='text' name='ldapLogin' class='mupdateprof' value='".$row['ldap']."'></p><br>";
			echo "<p><label for='room'>Miestnosť</label><input type='text' name='room' class='mupdateprof' value='".$row['room']."'></p><br>";
			echo "<p><label for='phone'>Telefón</label><input type='text' name='phone' class='mupdateprof' value='".$row['phone']."'></p><br>";
			echo "<p><label for='department'>Oddelenie</label><input type='text' name='department' class='mupdateprof' value='".$row['department']."' ></p><br>";
			echo "<p><label for='staffRole'>Zamestnanie</label><input type='text' name='staffRole' class='mupdateprof' value='".$row['staffRole']."' ></p><br>";
			echo "<p><label for='function'>Funkcia</label><input type='text' name='function' class='mupdateprof' value='".$row['function']."' ></p><br>";
			echo '<input type="hidden" name="hidden2" id="hidden2" value="edit" >';
			echo "<p><input type='submit' value='Edituj profil'></p><br> </form>";

		}

				else if(isset($_POST['hidden2'])){
				$sql2 = "UPDATE users
				SET title1 = '".$_POST['title1']."',
				title2 = '".$_POST['title2']."',
				ldap = '".$_POST['ldapLogin']."',
				room = '".$_POST['room']."',
				phone = '".$_POST['phone']."',
				department = '".$_POST['department']."',
				staffRole = '".$_POST['staffRole']."',
				function = '".$_POST['function']."' 
				WHERE ldap = '".$id."';";
				$update=1;
				$conn->query($sql2);
				$sql = "SELECT * FROM users WHERE ldap='".$id."'";
				$result2 = $conn->query($sql);
				while($row = $result2->fetch_assoc()) {
					echo '<img src="../resources/staff_photo/'.$row['photo'].'" width="200"><p>Meno: '.$row['title1'].' '.$row['title2'].''.$row['name'].' '.$row['surname'].'<br> Miestnost: '.$row['room'].'<br> Klapka: '.$row['phone'].'</p><br> Popis: '.$row['staffRole'];
					$name = $row['ldap'] ;
					echo "<form action='' method='post'> <table class='mtable' style='text-align: center'>";
					echo '<input type="hidden" name="hidden" id="hidden" value="edit" >';
					echo "<input type='submit' value='Edituj profil'><br> </form>";
				}
			}

		else{
			echo '<img src="../resources/staff_photo/'.$row['photo'].'" width="200"><p>Meno: '.$row['title1'].' '.$row['title2'].''.$row['name'].' '.$row['surname'].'<br> Miestnost: '.$row['room'].'<br> Klapka: '.$row['phone'].'</p><br> Popis: '.$row['staffRole'];
			$name = $row['ldap'] ;
			echo "<form action='' method='post'> <table class='mtable' style='text-align: center'>";
			echo '<input type="hidden" name="hidden" id="hidden" value="edit" >';
			echo "<input type='submit' value='Edituj profil'><br> </form>";
			}

		
		
}
/*
	$sql2 = "SELECT * FROM rights WHERE id_user=".$id."";

	$result2 = $conn->query($sql2);
	
	$rights = [false,false,false,false,false];
		
	while($row2 = $result2->fetch_assoc()) {
				$rights[$row2['id_roles']-1] = true;
	}
	if(isset($_POST["hidden"])&&($myrights[5]==true)){
		echo "<form action='' method='post'> <table class='mtable' style='text-align: center'>
		 <thead> <tr class='mheader'>
		 <th>LDPA</th>
		 <th>User</th>
		 <th>HR</th>
		 <th>Reporter</th>
		 <th>Editor</th>
		 <th>Admin</th></tr>";
		 //PREROB
		echo '<tr><td>'.$name.'</td>
		<td><input type="checkbox" id="user" name="user" value="true"';if($rights[0]==true)echo ' checked>';else echo '>';
		echo '</td>
		<td><input type="checkbox" id="hr" name="hr" value="true"';if($rights[1]==true)echo ' checked>';else echo '>';
		echo '</td>
		<td><input type="checkbox" id="reporter" name="reporter" value="true"';if($rights[2]==true)echo ' checked>';else echo '>';
		echo '</td>
		<td><input type="checkbox" id="editor" name="editor" value="true"';if($rights[3]==true)echo ' checked>';else echo '>';
		echo '</td>
		<td><input type="checkbox" id="admin" name="admin" value="true"';if($rights[4]==true)echo ' checked>';else echo '>';
		echo '</td>
		</tr></table>';
		echo '<input type="hidden" name="hidden2" id="hidden2" value="edit" >';
		echo "<input type='submit' value='Uloz'><br> </form>";
		}
		//verzia dva, treba otestovat
		
		 //$ar=["placeholder","user","hr","reporter","editor","admin"];
		//	 for($i=1;$i<6;$i++){
		//	if($rights[i]==true)
		//	echo '<td><input type="checkbox" id="'.$ar[$i].'" name="user" value="true" checked></td>';
		//	else
		//	echo '<td><input type="checkbox" id="'.$ar[$i].'" name="user" value="true" ></td';

		}


	else if (isset($_POST["hidden2"]))
	{
		$deleteroles = "DELETE FROM rights WHERE id_user=".$id."";
		$conn->query($deleteroles);
		if(isset($_POST['user'])){
			$conn->query("INSERT INTO rights (id_roles, id_user)
			VALUES (1,$id)");
		}
		if(isset($_POST['hr'])){
			$conn->query("INSERT INTO rights (id_roles, id_user)
			VALUES (2,$id)");
		}
		if(isset($_POST['reporter'])){
			$conn->query("INSERT INTO rights (id_roles, id_user)
			VALUES (3,$id)");	
		}
		if(isset($_POST['editor'])){
			$conn->query("INSERT INTO rights (id_roles, id_user)
			VALUES (4,$id)");
		}
		if(isset($_POST['admin'])){
			$conn->query("INSERT INTO rights (id_roles, id_user)
			VALUES (5,$id)");
		}

		$result5 = $conn->query($sql2);
	
		$rights = [false,false,false,false,false];
		
		while($row5 = $result5->fetch_assoc()) {
				$rights[$row5['id_roles']-1] = true;
		}

		echo "<table class='mtable' style='text-align: center'>
		<thead><tr class='mheader'>
		<th>LDPA</th>
		<th>User</th>
		<th>HR</th>
		<th>Reporter</th>
		<th>Editor</th>
		<th>Admin</th></tr>";
		//$_SESSION["rights"]= $rights;
		echo '<tr><td>'.$name.'</td>';//treba zmenit

		for ($i = 0; $i < 5 ; $i++){
			if($rights[$i]==true){
			echo '<td>/</td>';
			}
			else{
			echo '<td>-</td>';
			}
		}
			echo '</tr>';
			echo "</table>";
			echo '<form action="" method="post">
			<input type="hidden" name="hidden" id="hidden" value="edit" >';
			echo "<input type='submit' value='Edituj'><br></form>";

	}
	else {
		echo "<table class='mtable' style='text-align: center'>
		<thead><tr class='mheader'>
		<th>LDPA</th>
		<th>User</th>
		<th>HR</th>
		<th>Reporter</th>
		<th>Editor</th>
		<th>Admin</th></tr>";
		//$_SESSION["rights"]= $rights;
		echo '<tr><td>'.$name.'</td>';//treba zmenit

		for ($i = 0; $i < 5 ; $i++){
			if($rights[$i]==true){
			echo '<td>/</td>';
			}
			else{
			echo '<td>-</td>';
			}
		}
			echo '</tr>';
			echo "</table>";
			echo '<form action="" method="post">
			<input type="hidden" name="hidden" id="hidden" value="edit" >';
			echo "<input type='submit' value='Edituj'><br></form>";
	}*/
	
}


?>
</body>
</html>