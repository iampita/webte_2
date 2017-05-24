<?php

#pozriet do dbs a vziat nazov zlozky kde su fotky
#pre kazdy zlozku
    #pozriet do zlozky a vziat nazvy obrazkov
    #urobit <div class="row">
        #pre kazdy obrazok:
            #<img src="'".$folderName."/".$imgName."' class="bthumbnail" ...
    #</div>
#done

function connect(){     //zatial miesto configu a bez osetrenia to riesim takto... kym nemame spolocnu db
    $servername = "localhost";
    $username = "xjahodnikovab";
    $password = "martin";
    $dbname = "event_db";

    $conn = new mysqli($servername, $username, $password, $dbname);
    mysqli_set_charset($conn,"utf8");
    $conn->set_charset("utf8");
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
                $thelist .= '<div class="bthumbnail"> <img src="'.$folder."/".$file.'" onclick="openModal(\''.$folder."/".$file.'\')"> </div>';
                //onclick="funk(\''.$file .'\')"
            }
        }
        closedir($handle);
    }
    return $thelist;
}

function makeRowSK(){
    $conn = connect();
    $sql = "SELECT * FROM event";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) { // output data of each row
        while($row = $result->fetch_assoc()) {
            $niceDate = date('d.m.Y', strtotime($row['Date']));
            echo '<div class="bnavi">';
            echo '<p>'.$row['Title-SK'].', '.$niceDate.'</p>';
            echo '<div class="brow">';

            echo getPhotos($row['Folder']);

            echo '</div></div>';
        }
    }
    $conn->close();
}

function makeRowEN(){
    $conn = connect();
    $sql = "SELECT * FROM event";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) { // output data of each row
        while($row = $result->fetch_assoc()) {
            $niceDate = date('d.m.Y', strtotime($row['Date']));
            echo '<div class="bnavi">';
            echo '<p>'.$row['Title-EN'].', '.$niceDate.'</p>';
            echo '<div class="brow">';

            echo getPhotos($row['Folder']);

            echo '</div></div>';
        }
    }
    $conn->close();
}