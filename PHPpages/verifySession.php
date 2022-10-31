<?php
    session_start();

	if(empty($_SESSION["email"]) OR empty($_SESSION["user"]))
	{
		header("Location:../index.php");
	}
?>