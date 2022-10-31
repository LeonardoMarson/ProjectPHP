<?php
    require_once("connect.php"); 
    require_once '../vendor/autoload.php';

    global $email, $password;

    session_start();

    if(isset($_POST['credential'])){
        
        $googleClient = new Google\Client();
        $googleClient->setAuthConfig('../client_secret.json');
        $googleClient->addScope('https://www.googleapis.com/auth/userinfo.profile');
        $googleClient->addScope('https://www.googleapis.com/auth/userinfo.email');

        $id_token = $_POST['credential'];
        $payload = $googleClient->verifyIdToken($id_token);

        if (isset($payload['email'])) {
            $password = $payload['sub'];

            $stmt= $connect->prepare("SELECT password FROM user WHERE password=?");
            $stmt->bind_param("s", $password);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
         
            if (isset($user)){
                $_SESSION['email'] = $payload['email'];
                $_SESSION['user'] = $payload['name'];
                echo "<p>Usuário autenticado com sucesso pelo Google!</p>";
                header('Refresh: 2; URL=../pages/main.php');
            }
        }
    }
    else {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $stmt= $connect->prepare("SELECT email, password, username FROM user WHERE email=? AND password=?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if (isset($user)){
            $_SESSION['email'] = $email;
            $_SESSION['user'] = $user['username'];
            echo "<p>Usuário autenticado com sucesso!</p>";
            header('Refresh: 2; URL=../pages/main.php');
        }
    
    }

    $connect->close();
?>