<?php
require_once("../../includes/config.php");
if($_SESSION['admin'] == 1){
$comment_id = $_GET['id'];

$result = mysqli_query($conn, "UPDATE comments SET approved='1' where id='".$_GET['id']."'");

exit($result);
}