<!DOCTYPE html>
<html>
	<head>
		<title>Intranet/Profil</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
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
    font-size: 18px;
}

li {
    float: left;
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
	.msubmit{
	background-color: #419641;
	border: none;
	color: white;
	padding: 7px 17px;
	text-align: center;
	text-decoration: none;
	display: inline-block;
	font-size: 16px;
	border-radius: 3px;
}
.mmain{

margin-left: 58px;
}
.mname{
	font-size: 40px;
}
img{
	margin-bottom: 20px;
}

</style>

	</head>
	<body>
	<ul>
  <li><a class="active" href="/webte_2/intranet/client/intranet.html">Intranet</a></li>

  <li style="float:right"><a href="index.php">Domov</a></li>
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
		
		$prava=array();
		$skuska = $_SESSION['roles'];
		$iam = $_SESSION['username'];
		//var_dump($skuska);
		foreach ($skuska as $key) {
			array_push($prava, $key['roles_id']);
			# code...
		}

		profil($_GET['id'],$iam,$prava);
	}	



function profil($id,$iam,$skuska) {

	$update = 0;
	global $conn;
	
	
	$sql3 = "SELECT * FROM staff WHERE ldapLogin='".$id."'";

	$result = $conn->query($sql3);

		
		echo '<div class="mmain">';	

	while($row = $result->fetch_assoc()) {
		
		if(isset($_POST['hidden'])){
			$update=1;
			echo "<p class='mname'> ".$row['name']." ".$row['surname']."</p class='mname'><br>";
			echo '<img src="resources/staff_photo/'.$row['photo'].'" width="250"><br>';
			
			echo "<form action='' method='post'> <table class='mtable' style='text-align: center'>";		
			echo "<p><label for='title1'>Titul:</label><input type='text' name='title1' class='mupdateprof' value='".$row['title1']."' ></p><br>";
			echo "<p><label for='title2'>Titul:</label><input type='text' name='title2' class='mupdateprof' value='".$row['title2']."' ></p><br>";
			echo "<p><label for='ldapLogin'>Login:</label><input type='text' name='ldapLogin' class='mupdateprof' value='".$row['ldap']."'></p><br>";
			echo "<p><label for='room'>Miestnosť</label><input type='text' name='room' class='mupdateprof' value='".$row['room']."'></p><br>";
			echo "<p><label for='phone'>Telefón</label><input type='text' name='phone' class='mupdateprof' value='".$row['phone']."'></p><br>";
			echo "<p><label for='department'>Oddelenie</label><input type='text' name='department' class='mupdateprof' value='".$row['department']."' ></p><br>";
			echo "<p><label for='staffRole'>Zamestnanie</label><input type='text' name='staffRole' class='mupdateprof' value='".$row['staffRole']."' ></p><br>";
			echo "<p><label for='function'>Funkcia</label><input type='text' name='function' class='mupdateprof' value='".$row['function']."' ></p><br>";
			echo '<input type="hidden" name="hidden2" id="hidden2" value="edit" >';
			echo "<p><input type='submit' class='btn btn-success' value='Edituj profil'></p><br> </form>";

		}

				else if(isset($_POST['hidden2'])){
				$sql2 = "UPDATE users
				SET title1 = '".$_POST['title1']."',
				title2 = '".$_POST['title2']."',
				ldapLogin = '".$_POST['ldapLogin']."',
				room = '".$_POST['room']."',
				phone = '".$_POST['phone']."',
				department = '".$_POST['department']."',
				staffRole = '".$_POST['staffRole']."',
				function = '".$_POST['function']."' 
				WHERE ldapLogin = '".$id."';";
				
				$update=1;
				$conn->query($sql2);
				$sql = "SELECT * FROM staff WHERE ldapLogin='".$id."'";
				$result2 = $conn->query($sql);
				while($row = $result2->fetch_assoc()) {
					echo "<p class='mname'> ".$row['name']." ".$row['surname']."</p class='mname'><br></p>";
					echo '<img src="resources/staff_photo/'.$row['photo'].'" width="250"><br>
					<p><b>Meno:</b> '.$row['title1'].' '.$row['name'].' '.$row['title2'].' '.$row['surname'].'</p><br>
					<p><b>Miestnost:</b> '.$row['room'].'</p><br> 
					<p><b>Klapka:</b> '.$row['phone'].'</p><br>
					<p><b>Oddelenie:</b> '.$row['department'].'</p><br> 
					<p><b>Popis:</b> '.$row['staffRole'].'<br></p>';
					$name = $row['ldap'] ;
					echo "<form action='' method='post'> <table class='mtable' style='text-align: center'>";
					echo '<input type="hidden" name="hidden" id="hidden" value="edit" >';
					echo "<input type='submit' class='btn btn-success' value='Edituj profil'><br> </form>";
				}
			}

		else{
			echo " <p class='mname'>".$row['name']." ".$row['surname']."</p class='mname'><br></p>";
			echo '<img src="resources/staff_photo/'.$row['photo'].'" width="250">
			<br><p><b>Meno:</b> '.$row['title1'].' '.$row['name'].' '.$row['surname'].' '.$row['title2'].'</p> <br>
			<p><b>Miestnost:</b> '.$row['room'].'</p><br> 
			<p><b>Klapka:</b> '.$row['phone'].'</p><br>
			<p><b>Oddelenie:</b> '.$row['department'].'</p><br> 
			<p><b>Popis:</b> '.$row['staffRole'].'</p><br>';
			$name = $row['ldap'];
			echo "<form action='' method='post'> <table class='mtable' style='text-align: center'>";
			echo '<input type="hidden" name="hidden" id="hidden" value="edit" >';
			//print_r($skuska[1]['roles_id']);
			//var_dump(in_array(5,$skuska));
			if(($id==$iam)||in_array(5,$skuska)||in_array(2,$skuska)) {
				echo "<input type='submit' class='btn btn-success' value='Edituj profil'><br>";
			}
			else
			 echo "</form>";
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