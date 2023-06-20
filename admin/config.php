<?php
session_start();
ini_set("display_errors","off");
$host = 'lorempisum';
$username = 'lorempisum';
$password = 'lorempisum';
$database = 'lorempisum';
$conn = new MySQLi($host, $username, $password, $database);
if($conn->connect_error)
{
	die("Error: " . $conn->connect_error);
}
?>