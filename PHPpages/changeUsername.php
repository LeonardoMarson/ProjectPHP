<?php
    require_once 'verifySession.php';
    require_once 'connect.php';
    session_start();

    $actualUser = $_SESSION['email'];
    $newUsername = $_POST['newUsername'];

    $stmt = $connect->prepare(
        "UPDATE user
            SET username = ?
            WHERE email = ?
        ");
    $stmt->bind_param("ss", $newUsername, $actualUser);
    $stmt->execute();

    $_SESSION['user'] = $newUsername;
    
    echo "Nome alterado com sucesso!";
    header('Refresh: 2; URL=../pages/main.php');
?>