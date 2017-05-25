<?php

function connect(){
    $conn = new mysqli(HOSTNAME, USERNAME, PASSWORD, DBNAME);
    //$conn = new mysqli($servername, $username, $password, $dbname);
    mysqli_set_charset($conn,"utf8mb4");
    $conn->set_charset("utf8mb4");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function makeVideoContent(){
    $conn = connect();
    $sql = "SELECT * FROM video";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) { // output data of each row
        echo '<div class="bMediaTable"><table>';
        while($row = $result->fetch_assoc()) {
            $link = $row['url'];
            /*if($link == "") $link = './aktivity/media/'.$row[''];*/ //zo suboru

            echo '<tr class="bmedia">';
            echo'<td class="bTableTitle"><p><a href="'.$link.'">'.$row['name'].'</a></p></td>';
            echo '</tr><tr>';
            $link = str_replace("watch?v=", "/embed/",$link);
            $link = str_replace("youtu.be","youtube.com/embed",$link);
            echo '<td style="text-align: center;"><div class="bvideo"><iframe class="biframe" src="'.$link.'"></iframe></div></td>';
            echo '</tr><tr style="height: 25px;">';
            echo '</tr>';
        }
        echo '</table></div>';
    }
    $conn->close();
}
