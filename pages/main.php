<?php
   require_once '../PHPpages/verifySession.php';
?>

<!DOCTYPE html>
   <html lang="en">
   <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
   </head>
   
   <body>
      <header>
         <input type="text" placeholder="O que você quer ouvir?">
         <hr>
         <?php 
         echo "<p>Olá {$_SESSION['user']}</p>";
         ?>
      </header>
      <aside style="background-color: black;">
         <h1>Title</h1>
         <a href="">
            <img src="../images/home.png" alt="home">
            Início
         </a>
         <a href="">
            <img src="../images/lupa.png" alt="">
            Buscar
         </a>
         <a href="">
            <img src="../images/loupe.png" alt="">
            Criar playlist
         </a>
      </aside>
       
      <main>
         
      </main>
   </body>
</html>
