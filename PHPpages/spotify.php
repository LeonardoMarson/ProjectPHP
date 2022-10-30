<?php
	require '../vendor/autoload.php';

	$clientAPI = new SpotifyWebAPI\SpotifyWebAPI();

	$session = new SpotifyWebAPI\Session(
		'a03556098e76425a91081a3b581f3079',
		'c73cbaff9e6f4b4a8bb8964b2875a3a5',
		'localhost/php-project-apis/ProjectPHP/PHPpages/spotify.php'
	);

	$session->requestCredentialsToken();

	if($session == true){
		$clientAPI->setAccessToken($session->getAccessToken());

		$type = "track";
		$options = [
			'limit' => 1,
			'market' => 'US'
		];

		// The L.A. Woman is a song name just for test
		$searchTrack = $clientAPI->search("L.A. Woman", $type, $options);

		echo "<pre>";
		print_r($searchTrack);
		echo "</pre>";
	}
	else {
		echo "Credential error!";
        header('Refresh: 2; URL=index.php');
	}
	
?>