<?php
require_once("../../includes/config.php");
session_start();
$topicgetsql = mysqli_query($conn, "SELECT * FROM topics WHERE id='" . $_GET['id'] . "'");
$topicresults = mysqli_fetch_assoc($topicgetsql);
if(isset($_POST['update-topic']))
{
	if(empty($_POST['name']))
        $errors[] = "Topic Name required";
    if(empty($_POST['description']))
        $errors[] = "Topic Description required";
	if(count($errors) == 0)
	{
		$topicnameresults = mysqli_query($conn, "SELECT * FROM topics WHERE name='".$_POST['name']."' and id != '".$_GET['id']."'");
		if(mysqli_num_rows($topicnameresults) > 0)
			$errors[] = "Topic Name already exists.";
		else
		{
			mysqli_query($conn, "UPDATE topics SET name='".$_POST['name']."', description='".$_POST["description"]."' where id='".$_GET['id']."'");
			$_SESSION['success'] = "Topic Updated Successfully.";
			header("Location: edit.php?id=".$_GET['id']);
			die();
		}
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
  <link href="../../css/summernote-lite.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../css/admin.css">
  <title>Admin - Update Topic</title>
</head>
<body>
  <?php require_once("../header.php"); ?>
  <div class="admin-wrapper clearfix">
    <div class="left-sidebar">
      <ul>
        <li><a href="../posts/index.php">Manage Posts</a></li>
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
        <h2 style="text-align: center;">Update Topic</h2>
		<?php require_once("../print_errors.php"); ?>
		<?php if($_SESSION['success'] != "") { ?>
		<div class="msg success">
			<li><?php echo $_SESSION['success']; ?></li>
		</div>
		<?php } unset($_SESSION['success']); ?>
        <form action="edit.php?id=<?=$_GET['id'];?>" method="post">
          <div class="input-group">
            <label>Name</label>
            <input type="text" name="name" class="text-input" value="<?=$topicresults['name'];?>">
          </div>
          <div class="input-group">
            <label>Description</label>
            <textarea class="text-input" name="description" id="body"><?=$topicresults['description'];?></textarea>
          </div>
          <div class="input-group">
            <button type="submit" name="update-topic" class="btn" >Update Topic</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript" src="../../js/jquery.min.js"></script>
  <script src="../../js/summernote-lite.min.js"></script>
  <!-- <script type="text/javascript" src="../../js/ckeditor.js"></script> -->
  <script type="text/javascript" src="../../js/scripts.js"></script>
</body>
</html>
<?php 
}
else{
header("Location:../../404.html");
}
?>