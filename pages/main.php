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
         <header>
               <form action="../PHPpages/spotifyTracks.php" method="POST">
                  <input id="search-bar" 
                        type="search" 
                        maxlength="40" 
                        placeholder="O que você quer ouvir?"
                        name="search-value">
               </form>
               
               <?php 
                  echo "
                  <div id='user-section'>
                     <a id='user-info' href='../pages/user.php'>
                        <img src='../images/account-icon.png'>
                        <p id='username'>{$_SESSION['user']}</p>
                     </a>
                     <a href='../PHPpages/destroySession.php'>SAIR</a>
                  </div>
                  ";   
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
               if(isset($_SESSION['userSearchResult'])){
                  $track = $_SESSION['userSearchResult']->tracks->items;

                  for($i = 0; $i < count($track); $i++){
                     $trackImage = $track[$i]->album->images[2]->url;
                     $trackName = $track[$i]->name;
                     $trackArtist = $track[$i]->album->artists[0]->name;
                     $trackAlbum = $track[$i]->album->name;
                     $trackPreview = $track[$i]->preview_url;
                     $trackLength = $track[$i]->duration_ms;

                     // transform ms to minutes
                     $trackMin = $trackLength/60000;
                     $trackMin = explode('.', $trackMin);

                     // transform minutes' decimal in seconds
                     if(count($trackMin)< 2){
                        $trackSeg = $trackMin[0]*60;
                     }else{
                        $trackMin[1] = '0.'.$trackMin[1];
                        $test = $trackMin[1] * 60;

                        if($test < 10){
                           $test = '0'.intval($test);
                        }
                     }
                     
                     // join minutes and seconds
                     $trackLength = $trackMin[0].$test;

                     // explode the string of minutes and seconds to format
                     $trackLength = explode('.', $trackLength);
                     $trackLength = str_split($trackLength[0]);

                     // organize the length string to show on the page as desired
                     $trackLength = $trackLength[0].":".$trackLength[1].$trackLength[2];

                     $trackIndex = $i + 1;

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
                                 <form action='../PHPpages/addSong.php' method='POST'>
                                    <input type='hidden' id='trackImage' name='0' value='$trackImage' />
                                    <input type='hidden' id='trackName' name='1' value='$trackName' />
                                    <input type='hidden' id='trackArtist' name='2' value='$trackArtist' />
                                    <input type='hidden' id='trackPreview' name='3' value='$trackPreview' />               
                                    <input type='hidden' id='trackAlbum' name='4' value='$trackAlbum' />
                                    <input type='hidden' id='trackLength' name='5' value='$trackLength' />
                                    <button id='add-button'>
                                       <img src='../images/loupe.png' alt=''>
                                    </button>
                                 </form>
                              </div>
                           </div>
                        </div>
                     ";
                  }
               }
               
            ?>         
         </section>
      </main>
      <footer>
         <?php
            if(isset($_COOKIE['selectedIndex'])){
               $cookie = $_COOKIE['selectedIndex'];
            
               if(isset($_SESSION['userSearchResult'])){
                  $track = $_SESSION['userSearchResult']->tracks->items;

                  if(isset($cookie)){
                     $trackImage = $track[$cookie]->album->images[2]->url;
                     $trackName = $track[$cookie]->name;
                     $trackArtist = $track[$cookie]->album->artists[0]->name;
                     $trackPreview = $track[$cookie]->preview_url;
                     $trackAlbum = $track[$cookie]->album->name;
                     $trackLength = $track[$cookie]->duration_ms;

                     // transform ms to minutes
                     $trackMin = $trackLength/60000;
                     $trackMin = explode('.', $trackMin);

                     // transform minutes' decimal in seconds
                     if(count($trackMin)< 2){
                        $trackSeg = $trackMin[0]*60;
                     } else {
                        $trackMin[1] = '0.'.$trackMin[1];
                        $test = $trackMin[1] * 60;

                        if($test < 10){
                           $test = '0'.intval($test);
                        }
                     }
                     
                     // join minutes and seconds
                     $trackLength = $trackMin[0].$test;

                     // explode the string of minutes and seconds to format
                     $trackLength = explode('.', $trackLength);
                     $trackLength = str_split($trackLength[0]);

                     // organize the length string to show on the page as desired
                     $trackLength = $trackLength[0].":".$trackLength[1].$trackLength[2];
            
                     // caso o usuário tenha clicado em uma musica de sua playlist, está é agora salva como a última música selecionada
                     $lastTrackClicked = [$trackImage, $trackName, $trackArtist, $trackPreview];
                     $_SESSION['lastTrackClicked'] = $lastTrackClicked;
            
                     echo 
                     "<div class='display-footer'>
                        <img src='$trackImage' alt=''>
                        <div>
                           <span>$trackName</span>
                           <span>$trackArtist</span>
                        </div>
                        <div>
                           <audio id='audio' src='$trackPreview' controls autoplay>
                           </audio>
                        </div>
                     </div>";
                  }
               } else {
                  echo "<div class='display-footer'>
                           <audio src='' controls></audio>
                        </div>";
               }
            } else {
                  if(isset($_SESSION['lastTrackClicked'])){
                     $lastTrack= $_SESSION['lastTrackClicked'];

                     echo 
                     "<div class='display-footer'>
                        <img src='$lastTrack[0]' alt=''>
                        <div>
                           <span>$lastTrack[1]</span>
                           <span>$lastTrack[2]</span>
                        </div>
                        <div>
                           <audio id='audio' src='$lastTrack[3]' controls>
                           </audio>
                        </div>
                     </div>";
                  } else { // mostrar player logo ao entrar
                     echo "<div class='display-footer'>
                              <audio src='' controls></audio>
                           </div>";
                  }
            }
         ?>
      </footer>
   </body>
</html>