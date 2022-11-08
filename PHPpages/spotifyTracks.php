<?php
    require '../PHPpages/spotifySession.php';

	session_start();

	$session->requestCredentialsToken();

	if($session == true){
		$clientAPI->setAccessToken($session->getAccessToken());

		$type = [
			"track",
			"artist"
		];
		$options = [
			'limit' => 50,
			'market' => 'US'
		];

		$songSearch = $_POST['search-value'];
		$searchTrack = $clientAPI->search($songSearch, $type, $options);

		$_SESSION['userSearchResult'] = $searchTrack;
		header('Location: ../pages/main.php');
	}
	else {
		echo "Credential error!";
		header('Refresh: 2; URL=../index.html');
	}
?>