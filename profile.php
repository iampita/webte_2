<!DOCTYPE html>
<html>
	<head>
		<title>Zadanie 6</title>
		<meta charset="utf-8">
		<!-- <link rel="stylesheet" type="text/css" href="stylesheet.css"> -->
	</head>
	<body>
<?php
session_start() ;
	include_once('config.php');
	error_reporting(-1);
	
	if(isset($_GET["id"])){

		$myrights = [false,false,false,false,false];
		if(isset($_SESSION['myrights'])){
			$myrights=$_SESSION['myrights'];
		}

		profil($_GET['id'],$myrights);
	}	

function profil($id,$myrights) {
	global $conn;
	$sql3 = "SELECT * FROM users WHERE id_user=".$id."";
	$result = $conn->query($sql3);
			
	while($row = $result->fetch_assoc()) {
		echo '<img src="../images/'.$row['photo'].'" width="200"><p>Meno: '.$row['title1'].' '.$row['title2'].''.$row['name'].' '.$row['surname'].' Miestnost: '.$row['room'].' Klapka: '.$row['phone'].'</p> Popis: '.$row['staffRole'];
		$name = $row['ldap'] ;
	}

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
		/*
		 $ar=["placeholder","user","hr","reporter","editor","admin"];
			 for($i=1;$i<6;$i++){
			if($rights[i]==true)
			echo '<td><input type="checkbox" id="'.$ar[$i].'" name="user" value="true" checked></td>';
			else
			echo '<td><input type="checkbox" id="'.$ar[$i].'" name="user" value="true" ></td';

		}*/


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
	}
	
}


?>
</body>
</html>