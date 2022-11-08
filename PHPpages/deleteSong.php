<?php
    require_once 'connect.php';
    session_start();

    $userEmail = $_SESSION['email'];
    $trackToDelete = $_POST;

    $trackName = $trackToDelete[0];
    $trackArtist = $trackToDelete[1];
    
    $stmt = $connect->prepare(
        "SELECT relationship.id
            FROM relationship 
                INNER JOIN playlist ON playlist.playlist_id = relationship.playlist_id
                INNER JOIN tracks ON tracks.id = relationship.track_id
                INNER JOIN user ON playlist.user_email = user.email
            WHERE user_email = ? AND track_name = ? AND artist= ?
            LIMIT 1");
    $stmt->bind_param("sss", $userEmail, $trackName, $trackArtist);
    $stmt->execute();
    $result = $stmt->get_result();
    $result = $result->fetch_row();

    $relationshipID = $result[0];

    $stmt = $connect->prepare(
        "DELETE 
            FROM relationship
            WHERE id = ?");
    $stmt->bind_param("i", $relationshipID);
    $stmt->execute();

    $connect->close();

    echo "Musica deletada com sucesso! Voltando à tela de playlist.";
    header('Refresh: 2; URL=../pages/playlistPage.php');
?>