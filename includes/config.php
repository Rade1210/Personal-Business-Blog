<?php
session_start();
ini_set("display_errors","off");
$google_captcha_key = "lorempisum";
	$host = 'lorempisum';
	$username = 'lorempisum';
	$password = 'lorempisum';
	$database = 'lorempisum';
	$clientID = 'lorempisum';
	$clientSecret = 'lorempisum';
	$redirectUri = 'lorempisum';
	$domainUrl = 'lorempisum';
$conn = new MySQLi($host, $username, $password, $database);
if($conn->connect_error)
{
	die("Error: " . $conn->connect_error);
}