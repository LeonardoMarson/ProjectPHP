<?php
    require_once("connect.php"); 
    require_once '../vendor/autoload.php';

    global $email, $password, $username;

    if(isset($_POST['credential'])){
         
        $googleClient = new Google_Client();
        $googleClient->setAuthConfig('../client_secret.json');

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

    // VERIFY THE EMAIL EXISTANCE IN THE DATABASE
    $stmt= $connect->prepare("SELECT email FROM user WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $userEmail = $result->fetch_assoc();

    if (isset($userEmail)){
        echo "<p>Email já existente</p>";
        header('Refresh: 2; URL=../pages/signup.html');
    }
    else {
        // VERIFY THE USERNAME EXISTANCE IN THE DATABASE
        $stmt= $connect->prepare("SELECT username FROM user WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $userName = $result->fetch_assoc();
        
        if (isset($userName)){
            echo "<p>Nome de usuário ja registrado</p>";
            header('Refresh: 2; URL=../pages/signup.html');
        }
        else {
            // AFTER ALL THE ABOVE TESTS, THE USER IS FINALLY INSERTED IN THE DATABASE
            $stmt= $connect->prepare("INSERT INTO user (email, password, username) VALUES (?,?,?)");
            $stmt->bind_param("sss", $email, $password, $username);
            $stmt->execute();

            $stmt= $connect->prepare("INSERT INTO playlist (user_email) VALUES (?)");
            $stmt->bind_param("s", $email);
            $stmt->execute();

            $connect->close();

            echo "Usuário cadastro com sucesso! Voltando à tela de login.";
            header('Refresh: 2; URL=../index.html');
        }
    }
?>