<?php
require_once("../../includes/config.php");
session_start();
$postgetsql = mysqli_query($conn, "SELECT * FROM posts WHERE id='" . $_GET['id'] . "'");
$postresults = mysqli_fetch_assoc($postgetsql);
if(isset($_POST['delete-post']))
{
	if(mysqli_num_rows($postgetsql) > 0)
	{
		$p_img = $postresults["image"];
		unlink("post_images/".$p_img);
		mysqli_query($conn, "DELETE from posts where id='".$_GET['id']."'");
		$_SESSION['success'] = "Post Deleted Successfully.";
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
        <a href="create.php" class="btn btn-sm">Add Post</a>
        <a href="index.php" class="btn btn-sm">Manage Posts</a>
		<a href="drafts.php" class="btn btn-sm">Manage Drafts</a>
      </div>
      <div class="">
        <h2 style="text-align: center;">Delete Post</h2>
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
            <label>Title</label>
            <input type="text" name="title" class="text-input" value="<?=$postresults['title'];?>" disabled="disabled">
          </div>
          <div class="input-group">
            <label>Body</label>
            <textarea class="text-input" name="body" id="body" disabled="disabled"><?=$postresults['body'];?></textarea>
          </div>
          <div class="input-group">
            <label>Topic</label>
            <select class="text-input" name="topic" id="topic" disabled="disabled">
              <?php
					$topicssql = mysqli_query($conn, "SELECT * FROM topics");
					while($topicsresult = mysqli_fetch_assoc($topicssql)) { ?>
					<option value="<?=$topicsresult['id'];?>"><?=$topicsresult['name'];?></option>
				<?php } ?>
            </select>
			<script>document.getElementById("topic").value='<?=$postresults["topic_id"]?>';</script>
          </div>
		  <div class="input-group">
            <label>
			<?php if($postresults["image"] != "") { ?>
              <input type="file" name="Image" id="Image" /><br/><br/>
			  <img src="post_images/<?=$postresults["image"]?>" width="100" />
			<?php } else { ?>
				<input type="file" name="Image" id="Image" />
			<?php } ?>
            </label>
          </div>
          <div class="input-group">
            <label>
			<?php if($postresults['published'] != "0") { ?>
              <input type="checkbox" name="publish" checked="checked" disabled="disabled" /> Publish
			  <?php } else { ?>
				<input type="checkbox" name="publish" disabled="disabled" /> Publish
			  <?php } ?>
            </label>
          </div>
		  <div class="input-group">
            <label>
			<?php if($postresults['trending'] != "0") { ?>
              <input type="checkbox" name="trending" checked="checked" disabled="disabled" /> Trending Post
			  <?php } else { ?>
				<input type="checkbox" name="trending" disabled="disabled" /> Trending Post
			  <?php } ?>
            </label>
          </div>
          <div class="input-group">
            <button type="submit" name="delete-post" class="btn" >Delete Post</button>
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
}
?> 