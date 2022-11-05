<?php
   require_once '../PHPpages/verifySession.php';
   require '../PHPpages/connect.php'; 
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
      <script src="../pages/test.js"></script>

      <aside>
         <h1>Title</h1>
         <a href="../pages/main.php" class="links">
            <img src="../images/home.png" alt="home">
            Início
         </a>
         <a href="" class="links">
            <img src="../images/lupa.png" alt="">
            Buscar
         </a>
         <hr id="separator-aside">
         <a href="" class="links playlist">
            <img src="../images/loupe.png" alt="">
            Minha playlist
         </a>
      </aside>
       
      <main>
         <header id="playlist-header">
               <?php 
                  echo "
                  <div id='user-info'>
                     <img src='../images/account-icon.png'>
                     <p id='username'>{$_SESSION['user']}</p>
                  </div>";
               ?>
         </header>

         <section id="main-area">

            <div id="tracks-info">
               <div id="left-side">
                  <span>#</span>
                  <span>Title</span>
               </div>
               <div id="right-side">
                  <span>Album</span>
                  <img src="../images/clock.png" alt="" id="timestamp-icon">
               </div>
            </div>

            <hr id="separator-songs">
            <?php
               $userEmail = $_SESSION['email'];

               // SEARCH FOR THE USER PLAYLIST_ID
               $stmt = $connect->prepare("SELECT playlist_id FROM playlist WHERE user_email = ?");
               $stmt->bind_param("s", $userEmail);
               $stmt->execute();
               $userPlaylistID = $stmt->get_result();
               $userPlaylistID = $userPlaylistID->fetch_assoc();
               $userPlaylistID = $userPlaylistID['playlist_id'];

               // SEARCH FOR TRACKS INSIDE USER PLAYLIST
               $stmt = $connect->prepare(
                  "SELECT track_image, track_name, artist, track_preview
                     FROM playlist 
                        INNER JOIN relationship ON playlist.playlist_id = relationship.playlist_id
                        INNER JOIN tracks ON tracks.id = relationship.track_id
                     WHERE relationship.playlist_id = ?");
               $stmt->bind_param("i", $userPlaylistID);
               $stmt->execute();
               $result = $stmt->get_result();

               // PUTS ALL THE TRACKS INSIDE AN ARRAY
               for($i = 0; $i < $result->num_rows; $i++){
                  $row[$i] = $result->fetch_row();
                  $playlistTracks[$i] = $row[$i];
               }

               echo "<pre>";
               print_r($playlistTracks);
               echo "</pre>";

               unset($_SESSION['userSearchResult']);
            ?>         
         </section>
      </main>
      <footer>
         <?php
            echo 
            "
            <div>
               <audio src='' controls autoplay></audio>
            </div>
            ";
         ?>
      </footer>
   </body>
</html>