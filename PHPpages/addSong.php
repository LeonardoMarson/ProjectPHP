<?php
    require_once "connect.php"; 

    session_start();

    $trackToInsert = $_SESSION['trackInfoSQl'];
    if(!empty($trackToInsert[3])){
        $stmt= $connect->prepare("INSERT INTO tracks (track_image, track_name, artist, track_preview) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $trackToInsert[0], $trackToInsert[1], $trackToInsert[2], $trackToInsert[3]);
        $stmt->execute();
    }
    else {
        $trackToInsert[3] = 'null';
        $stmt= $connect->prepare("INSERT INTO tracks (track_image, track_name, artist, track_preview) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $trackToInsert[0], $trackToInsert[1], $trackToInsert[2], $trackToInsert[3]);
        $stmt->execute();
    }

    print_r($trackToInsert);
    unset($_SESSION['trackInfoSQl']);

    $connect->close();

    echo "Musica cadastrada com sucesso! Voltando à tela de login.";
    header('Refresh: 2; URL=../pages/main.php');
?>