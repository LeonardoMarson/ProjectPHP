<?php
    require_once("connect.php"); 
    require_once '../vendor/autoload.php';

    global $email, $password, $username;

    if(isset($_POST['credential'])){
        
        $googleClient = new Google\Client();
        $googleClient->setAuthConfig('../client_secret.json');
        $googleClient->addScope('https://www.googleapis.com/auth/userinfo.profile');
        $googleClient->addScope('https://www.googleapis.com/auth/userinfo.email');

        $id_token = $_POST['credential'];
        $payload = $googleClient->verifyIdToken($id_token);

        if (isset($payload['email'])) {

             $email = $payload['email'];
             $password = $payload['sub'];
             $username = $payload['name'];
        }
    }
    else{
        
        $email = $_POST["email"];
        $password = $_POST["password"];
        $username = $_POST["username"];
    }

    $stmt= $connect->prepare("INSERT INTO user (email, password, username) VALUES (?,?,?)");
    $stmt->bind_param("sss", $email, $password, $username);

    $stmt->execute();

    $connect->close();
?>