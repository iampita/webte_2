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

function getPhotos($folder){
    $thelist = "";
    if ($handle = opendir("aktivity/".$folder."/")) {
        while (false !== ($file = readdir($handle)))
        {
            $format = strtolower(substr($file, strrpos($file, '.') + 1));
            if ($file != "." && $file != "..")
                if($format == 'jpg' || $format == 'png' || $format == 'gif')
                {
                    $thelist .= '<div class="bthumbnail"> <img src="aktivity/'.$folder."/".$file.'" onclick="openModal(\'aktivity/'.$folder."/".$file.'\')"> </div>';
                }
        }
        closedir($handle);
    }
    return $thelist;
}

function makeMediaContent(){
    $conn = connect();
    $sql = "SELECT * FROM media";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) { // output data of each row
        echo '<div class="bMediaTable"><table>';
        while($row = $result->fetch_assoc()) {
            $niceDate = date('d.m.Y', strtotime($row['date']));
            $link = $row['url'];
            if($link == "") $link = './aktivity/media/'.$row['pdf'];

            echo '<tr class="bmedia">';
                echo '<td>'.$row['media'].'</td>';
                echo '<td>'.$niceDate.'</td>';
            echo '</tr><tr>';
                echo'<td class="bTableTitle" colspan="2"><a href="'.$link.'">'.$row['title'].'</a></td>';
            echo '</tr><tr style="height: 25px;">';
            echo '</tr>';
        }
        echo '</table></div>';
    }
    $conn->close();
}
