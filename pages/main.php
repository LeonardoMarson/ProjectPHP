<?php
   require_once '../PHPpages/verifySession.php';
?>

<!DOCTYPE html>
   <html lang="en">
   <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <link rel="stylesheet" href="../css/main.css">

        <title>Document</title>
   </head>
   
   <body>
      <aside>
         <h1>Title</h1>
         <a href="" class="links">
            <img src="../images/home.png" alt="home">
            Início
         </a>
         <a href="" class="links">
            <img src="../images/lupa.png" alt="">
            Buscar
         </a>
         <a href="" class="links">
            <img src="../images/loupe.png" alt="">
            Criar playlist
         </a>
      </aside>
       
      <main>
         <header>
            <input id="search-bar" type="text" placeholder="O que você quer ouvir?">
            <?php 
               echo "
               <div id='user-info'>
                  <img src='../images/account-icon.png'>
                  <p id='username'>{$_SESSION['user']}</p>
               </div>";
            ?>
         </header>
      </main>
   </body>
</html>
