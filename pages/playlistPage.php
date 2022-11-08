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

      <aside>
         <h1>Title</h1>
         <a href="../pages/main.php" class="links" id="homeButton">
            <img src="../images/home.png" alt="home">
            Início
         </a>
         <a href="../pages/main.php" class="links" id="searchButton">
            <img src="../images/lupa.png" alt="">
            Buscar
         </a>
         <hr id="separator-aside">
         <a href="playlistPage.php" class="links playlist" id="playlistButton">
            <img src="../images/loupe.png" alt="">
            Minha playlist
         </a>
      </aside>
       
      <main>
         <header id="playlist-header">
               <?php 
                  echo "
                  <div id='user-section'>
                     <a id='user-info' href='../pages/user.php'>
                        <img src='../images/account-icon.png'>
                        <p id='username'>{$_SESSION['user']}</p>
                     </a>
                     <a href='../PHPpages/destroySession.php'>SAIR</a>
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
                  "SELECT track_image, track_name, artist, track_preview, trackAlbum, trackLength
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
               
                  $trackImage = $playlistTracks[$i][0];
                  $trackName =  $playlistTracks[$i][1];
                  $trackArtist= $playlistTracks[$i][2];
                  $trackLink =  $playlistTracks[$i][3];
                  $trackAlbum=  $playlistTracks[$i][4];
                  $trackLength= $playlistTracks[$i][5];
                  $trackIndex = $i + 1;

                  $_SESSION['userPlaylist'] = $playlistTracks;
                  echo 
                  "
                     <div id='tracks' value='{$i}'>
                        <div id='track-info'>
                           <span id='click'>$trackIndex</span>
                           <img src='$trackImage' alt=''>
                           <div id='track-name-artist'>
                              <span>$trackName</span>
                              <span>$trackArtist</span>
                           </div>
                        </div>
                        
                        <div id='track-length'>
                           <span id='album-name'>$trackAlbum</span>
                           <div id='track-length-and-add'>
                              <span>$trackLength</span>
                              <form action='../PHPpages/deleteSong.php' method='POST'>
                                 <input type='hidden' id='trackName' name='0' value='$trackName' />
                                 <input type='hidden' id='trackArtist' name='1' value='$trackArtist' />
                                 <button id='add-button'>
                                    <img src='../images/minus.png' alt=''>
                                 </button>
                              </form>
                           </div>
                        </div>
                     </div>
                  ";
               }
            ?>         
         </section>
      </main>
      <footer>
         <?php
            if(isset($_COOKIE['selectedIndex'])){
               $cookie = $_COOKIE['selectedIndex'];

               if(isset($_SESSION['userPlaylist'])){
                  $track = $_SESSION['userPlaylist'];

                  if(isset($cookie)){
                     $trackImage = $track[$cookie][0];
                     $trackName = $track[$cookie][1];
                     $trackArtist = $track[$cookie][2];
                     $trackPreview = $track[$cookie][3];

                     // caso o usuário tenha clicado em uma musica de sua playlist, está é agora salva como a última música selecionada
                     $_SESSION['lastTrackClicked'] = [$trackImage, $trackName, $trackArtist, $trackPreview];
            
                     echo 
                     "
                        <div>
                           <img src='$trackImage' alt=''>
                           <div>
                              <span>$trackName</span>
                              <span>$trackArtist</span>
                           </div>
                           <div>
                              <audio src='$trackPreview' controls autoplay>
                              </audio>
                           </div>
                        </div>     
                     ";
                  }
               } else {
                  echo 
                  "
                  <div class='displayfooter'>
                     <audio src='' controls autoplay></audio>
                  </div>
                  ";
               }
            } else {
               if(isset($_SESSION['lastTrackClicked'])){

                  $lastTrack= $_SESSION['lastTrackClicked'];
                  echo 
                  "
                  <div>
                     <img src='$lastTrack[0]' alt=''>
                     <div>
                        <span>$lastTrack[1]</span>
                        <span>$lastTrack[2]</span>
                     </div>
                     <div class='displayfooter'>
                        <audio id='audio' src='$lastTrack[3]' controls>
                        </audio>
                     </div>
                  </div> ";

                  } else {
                     echo 
                     "
                     <div class='displayfooter'>
                        <audio src='' controls></audio>
                     </div>
                     ";
                  }
            }
         ?>
      </footer>
   </body>
</html>