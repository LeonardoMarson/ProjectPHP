<?php
	require_once 'verifySession.php';
	require '../vendor/autoload.php';

	$clientAPI = new SpotifyWebAPI\SpotifyWebAPI();

	$session = new SpotifyWebAPI\Session(
		'a03556098e76425a91081a3b581f3079',
		'c73cbaff9e6f4b4a8bb8964b2875a3a5',
		'localhost/php-project-apis/ProjectPHP/PHPpages/playlist.php'
	);	
?>