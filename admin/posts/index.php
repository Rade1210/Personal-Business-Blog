<?php require_once("../../includes/config.php"); ?>
<?php

session_start();

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
  <title>Admin - Manage Posts</title>
</head>

<body>
  <?php require_once("../header.php"); ?>
  <div class="admin-wrapper clearfix">
    <div class="left-sidebar">
      <ul>
        <li><a href="index.php">Manage Posts</a></li>
        <li><a href="../topics/index.php">Manage Topics</a></li>
        <li><a href="../users/index.php">Manage Users</a></li>
        <li><a href="../comments/index.php">Manage Comments</a></li>
      </ul>
    </div>
    <div class="admin-content clearfix">
      <div class="button-group">
        <a href="create.php" class="btn btn-md">Add Post</a>
        <a href="drafts.php" class="btn btn-md">Manage Drafts</a>
      </div>
      <div class="">
          <br>
        <h2 style="text-align:center">Manage Posts</h2>
             <br>
        <?php if($_SESSION['success'] != "") { ?>
        <div class="msg success">
          <li><?php echo $_SESSION['success']; ?></li>
        </div>
        <?php } unset($_SESSION['success']); ?>
        <table class="table">
          <thead>
            <th>#</th>
            <th>Title</th>
            <th>Topic</th>
            <th>Author</th>
            <th colspan="3">Action</th>
          </thead>
          <tbody>
            <?php
		$postsql = mysqli_query($conn, "SELECT * FROM posts WHERE user_id = '" . $_SESSION['user_id'] . "' and published='1'");
		$postscount = mysqli_num_rows($postsql);
		if($postscount > 0)
		{
			$count = 1;
			while($postresult = mysqli_fetch_assoc($postsql))
			{
				$topicsql = mysqli_query($conn, "SELECT * FROM topics WHERE id = '".$postresult['topic_id']."'");
				$topicresult = mysqli_fetch_assoc($topicsql);
			?>
            <tr class="rec">
              <td><?=$count;?></td>
              <td><a href="edit.php?id=<?=$postresult['id'];?>"><?=$postresult['title'];?></a></td>
              <td><?=$topicresult['name'];?></td>
              <td><?=$_SESSION['username'];?></td>
              <td><a href="edit.php?id=<?=$postresult['id'];?>" class="edit">Edit</a></td>
              <td><a href="delete.php?id=<?=$postresult['id'];?>" class="delete">Delete</a></td>
              <td><a href="unpublish.php?id=<?=$postresult['id'];?>" class="unpublish">Unpublish</a></td>
            </tr>
            <?php
			$count++;
			}
		}
		else
		{ ?>
            <tr class="rec">
              <td colspan="6" style="text-align: center;"><b>No Posts yet.</b></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
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