<?php require_once("../../includes/config.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../../css/font-awesome.min.css" />
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="../../css/admin.css">
  <title>Admin - Manage Drafts</title>
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
        <a href="index.php" class="btn btn-sm">Manage Drafts</a>
      </div>
      <div class="">
          <br>
        <h2 style="text-align: center;">Manage Drafts</h2>
        <br>
		<?php if($_SESSION['success'] != "") { ?>
		<div class="msg success">
			<li><?php echo $_SESSION['success']; ?></li>
		</div>
		<?php } unset($_SESSION['success']); ?>
        <table>
          <thead>
            <th>N</th>
            <th>Title</th>
            <th>Author</th>
            <th colspan="3">Action</th>
          </thead>
          <tbody>
		  <?php
		$postsql = mysqli_query($conn, "SELECT * FROM posts WHERE user_id = '" . $_SESSION['user_id'] . "' and published='0'");
		$postscount = mysqli_num_rows($postsql);
		if($postscount > 0)
		{
			$count = 1;
			while($postresult = mysqli_fetch_assoc($postsql))
			{
				$authorsql = mysqli_query($conn, "SELECT * from users where id='".$postresult['user_id']."'");
				$authorresult = mysqli_fetch_assoc($authorsql);
			?>
			<tr class="rec">
              <td><?=$count;?></td>
              <td><a href="#"><?=$postresult['title'];?></a></td>
              <td><?=$authorresult['username'];?></td>
              <td><a href="edit.php?id=<?=$postresult['id'];?>" class="edit">Edit</a></td>
              <td><a href="#" class="delete">Delete</a></td>
              <td><a href="publish.php?id=<?=$postresult['id'];?>" class="publish">Publish</a></td>
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