<?php
require_once("../config.php");
session_start();
if($_GET['id'])
{
	$postsql = "SELECT * FROM posts WHERE id='".$_GET['id']."' and published='1'";
	$postresults = mysqli_query($conn, $postsql);
	if(mysqli_num_rows($postresults) > 0)
	{
		mysqli_query($conn, "UPDATE posts SET published='0' where id='".$_GET['id']."'");
		$_SESSION['success'] = "Post Unpublished Successfully.";
		header("Location: drafts.php");
		die();
	}
}
?>