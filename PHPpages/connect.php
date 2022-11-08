<?php
    require_once 'verifySession.php';
    
    $connect = new mysqli("localhost", "root","","projetophp");
    
    if($connect->connect_error){
        echo "Erro ao conectar";
    }
?>