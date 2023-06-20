<?php
require_once("../config.php");
session_start();
if($_GET['id'])
{
	$postsql = "SELECT * FROM posts WHERE id='".$_GET['id']."' and published='0'";
	$postresults = mysqli_query($conn, $postsql);
	if(mysqli_num_rows($postresults) > 0)
	{
		mysqli_query($conn, "UPDATE posts SET published='1' where id='".$_GET['id']."'");
		$_SESSION['success'] = "Post Published Successfully.";
		header("Location: index.php");
		die();
	}
}
?>