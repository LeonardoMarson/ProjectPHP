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

    $stmt= $connect->prepare("SELECT email FROM user WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $userEmail = $result->fetch_assoc();

    if (isset($userEmail)){
        echo "<p>email ja registrado</p>";
        header('Refresh: 2; URL=../pages/signup.html');
    }

    $stmt= $connect->prepare("SELECT username FROM user WHERE username=?");
    $stmt->bind_param("s", $username);
    
    $stmt->execute();

    $result = $stmt->get_result();

    $userName = $result->fetch_assoc();
    
    if (isset($userName)){
        echo "<p>username ja registrado</p>";
        header('Refresh: 2; URL=../pages/signup.html');
    }

    $stmt= $connect->prepare("INSERT INTO user (email, password, username) VALUES (?,?,?)");
    $stmt->bind_param("sss", $email, $password, $username);

    $stmt->execute();

    $connect->close();

    header('Refresh: 2; URL=../index.html');
?>