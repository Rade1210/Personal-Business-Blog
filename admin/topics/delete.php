<?php
require_once("../../includes/config.php");
session_start();
$topicgetsql = mysqli_query($conn, "SELECT * FROM topics WHERE id='" . $_GET['id'] . "'");
$topicresults = mysqli_fetch_assoc($topicgetsql);
if(isset($_POST['delete-topic']))
{
	if(mysqli_num_rows($topicgetsql) > 0)
	{
		mysqli_query($conn, "DELETE from posts where topic_id='".$_GET['id']."' and user_id='".$_SESSION['user_id']."'");
		mysqli_query($conn, "DELETE from topics where id='".$_GET['id']."'");
		$_SESSION['success'] = "Posts Deleted Successfully.<br/>Topic Deleted Successfully.";
		header("Location: index.php");
		die();
	}
}
if($_SESSION['admin'] == 1){
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../../css/font-awesome.min.css" />
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="../../css/admin.css">
  <title>Admin - Delete Post</title>
</head>
<body>
  <?php require_once("../header.php"); ?>
  <div class="admin-wrapper clearfix">
    <div class="left-sidebar">
      <ul>
        <li><a href="index.php">Manage Posts</a></li>
        <li><a href="../topics/index.php">Manage Topics</a></li>
        <li><a href="../users/index.php">Manage Users</a></li>
      </ul>
    </div>
    <div class="admin-content clearfix">
      <div class="button-group">
        <a href="create.php" class="btn btn-sm">Add Topic</a>
        <a href="index.php" class="btn btn-sm">Manage Topics</a>
      </div>
      <div class="">
        <h2 style="text-align: center;">Delete Topic</h2>
		<?php
			require_once("../print_errors.php");
		?>
		<?php if($_SESSION['success'] != "") { ?>
		<div class="msg success">
			<li><?php echo $_SESSION['success']; ?></li>
		</div>
		<?php } unset($_SESSION['success']); ?>
        <form action="delete.php?id=<?=$_GET['id'];?>" method="post">
          <div class="input-group">
            <label>Name</label>
            <input type="text" name="name" class="text-input" value="<?=$topicresults['name'];?>" disabled="disabled">
          </div>
          <div class="input-group">
            <label>Description</label>
            <textarea class="text-input" name="description" id="description" disabled="disabled"><?=$topicresults['description'];?></textarea>
          </div>
          <div class="input-group">
            <button type="submit" name="delete-topic" class="btn" >Delete Topic</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript" src="../../js/jquery.min.js"></script>
  <script type="text/javascript" src="../../js/slick.min.js"></script>
  <script type="text/javascript" src="../../js/scripts.js"></script>
</body>
</html>
<?php 
}
else{
header("Location:../../404.html");
}?>