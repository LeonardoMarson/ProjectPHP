<?php
    require_once 'vendor/autoload.php';

    session_start();

    $googleClient = new Google\Client();
    $googleClient->setAuthConfig('client_secret.json');
    $googleClient->addScope('https://www.googleapis.com/auth/userinfo.profile');
    $googleClient->addScope('https://www.googleapis.com/auth/userinfo.email');

    if(isset($_POST['credential'])){
        $id_token = $_POST['credential'];
        $payload = $googleClient->verifyIdToken($id_token);

        if (isset($payload['email'])) {
            $name = $payload['name'];
            $email = $payload['email'];

            $_SESSION['userName'] = $name;
            $_SESSION['email'] = $email;
        }

        print_r($_SESSION);
    }
    else {
        echo "Credential or user not found!";
        header('Refresh: 2; URL=index.php');
    }
?>