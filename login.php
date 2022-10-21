<?php
    require_once 'vendor/autoload.php';

    $googleClient = new Google\Client();
    $googleClient->setAuthConfig('client_secret.json');
    $googleClient->addScope('https://www.googleapis.com/auth/userinfo.profile');
    $googleClient->addScope('https://www.googleapis.com/auth/userinfo.email');

    if(isset($_POST['credential'])){
        echo "ENTERED!";
    }
    else {
        header('Refresh: 2; URL=index.php');
    }

    $id_token = $_POST['credential'];
    $payload = $googleClient->verifyIdToken($id_token);
    if (isset($payload['email'])) {
        echo '<pre>';
        print_r($payload);
        echo '</pre>';
    }
?>