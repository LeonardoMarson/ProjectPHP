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
      <script src="../pages/script.js" defer></script>

      <aside>
         <h1>Title</h1>

         <a href="main.php" class="links" id="homeButton">
            <img src="../images/home.png" alt="home">
            Início
         </a>
         <a href="main.php" class="links" id="searchButton">
            <img src="../images/lupa.png" alt="">
            Buscar
         </a>
         <hr id="separator-aside">
         <a href="../pages/playlistPage.php" class="links playlist" id="playlistButton" >
            <img src="../images/loupe.png" alt="">
            Minha playlist
         </a>
      </aside>
       
      <main>
        <section id="main-area" class="user-main">
            <h1>
               Dados do usuário
            </h1>

            <form action="../PHPpages/changeUsername.php" method="post" id="change-name-form">
                <div>
                     <label for="">Nome atual de usuário</label>
                     <input type="text" value="<?php echo $_SESSION['user']?>" disabled>
                </div>
                <div>
                     <label for="">Digite o novo nome de usuário</label>
                     <input type="text" name="newUsername">
                </div>
                <button>ENVIAR</button>
            </form>
        </section>
      </main>
   </body>
</html>