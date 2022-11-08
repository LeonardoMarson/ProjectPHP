<?php
    require_once "connect.php"; 

    session_start();

    $userEmail = $_SESSION['email'];
    $trackToInsert = $_SESSION['trackInfoSQl'];
    $trackName = $trackToInsert[1];
    $trackAlbum = $trackToInsert[4];

    if(!empty($trackToInsert[3])){
        $stmt= $connect->prepare("INSERT INTO tracks (track_image, track_name, artist, track_preview, trackAlbum, trackLength) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("ssssss", $trackToInsert[0], $trackToInsert[1], $trackToInsert[2], $trackToInsert[3], $trackToInsert[4], $trackToInsert[5]);
        $stmt->execute();
    }
    else {
        $trackToInsert[3] = 'null';
        $stmt= $connect->prepare("INSERT INTO tracks (track_image, track_name, artist, track_preview, trackAlbum, trackLength) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("ssssss", $trackToInsert[0], $trackToInsert[1], $trackToInsert[2], $trackToInsert[3], $trackToInsert[4], $trackToInsert[5]);
        $stmt->execute();
    }

    // SEARCH THE PLAYLIST OF THE CURRENT USER
    $stmt = $connect->prepare("SELECT playlist_id FROM playlist WHERE user_email = ?");
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $playlistID = $stmt->get_result();
    $playlistID = $playlistID->fetch_assoc();

    // SEARCH THE TRACK SELECTED BY THE CURRENT USER
    $stmt = $connect->prepare("SELECT id FROM tracks WHERE track_name = ? AND trackAlbum = ?");
    $stmt->bind_param("ss", $trackName, $trackAlbum);
    $stmt->execute();
    $trackID = $stmt->get_result();
    $trackID = $trackID->fetch_assoc();

    // SET THE ID'S
    $playlistID = $playlistID['playlist_id'];
    $trackID = $trackID['id'];

    $stmt= $connect->prepare("INSERT INTO relationship (playlist_id, track_id) VALUES (?,?)");
    $stmt->bind_param("ii", $playlistID, $trackID);
    $stmt->execute();

    unset($_SESSION['trackInfoSQL']);
    $connect->close();

    echo "Musica cadastrada com sucesso! Voltando à tela de login.";
    header('Refresh: 2; URL=../pages/main.php');
?>