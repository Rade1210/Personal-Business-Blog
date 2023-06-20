<?php 
require_once("../../includes/config.php"); 
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
  <title>Admin - Manage Users</title>
</head>

<body>
  <?php require_once("../header.php"); ?>
  <div class="admin-wrapper clearfix">
    <div class="left-sidebar">
      <ul>
        <li><a href="../posts/index.php">Manage Posts</a></li>
        <li><a href="../topics/index.php">Manage Topics</a></li>
        <li><a href="../users/index.php">Manage Users</a></li>
        <li><a href="../comments/index.php">Manage Comments</a></li>
      </ul>
    </div>
    <div class="admin-content clearfix">
      <div class="button-group">
        <a href="https://personalbusinessblog.com/admin/users/create.php" class="btn btn-md">Add User</a>
        <a href="https://personalbusinessblog.com/admin/users/index.php" class="btn btn-md">Manage Users</a>
      </div>
      <div class="">
          <br>
        <h2 style="text-align: center;">Manage Users</h2>
           <br>
        <?php if($_SESSION['success'] != "") { ?>
        <div class="msg success">
          <li><?php echo $_SESSION['success']; ?></li>
        </div>
        <?php } unset($_SESSION['success']); ?>
        <table class="table">
          <thead>
            <th>#</th>
            <th>Username</th>
            <th colspan="3">Action</th>
          </thead>
          <tbody>
            <?php
			$userssql = mysqli_query($conn, "SELECT * FROM users where admin='0'");
			$userscount = mysqli_num_rows($userssql);
			if($userscount > 0)
			{
				$count = 1;
				while($usersresult = mysqli_fetch_assoc($userssql))
				{ ?>
            <tr class="rec">
              <td><?=$count;?></td>
              <td><a href="edit.php?id=<?=$usersresult['id'];?>"><?=$usersresult['username'];?></a></td>
              <td><a href="edit.php?id=<?=$usersresult['id'];?>" class="edit">Edit</a></td>
              <td><a href="delete.php?id=<?=$usersresult['id'];?>" class="delete">Delete</a></td>
            </tr>
            <?php
				$count++;
				} 
			}
			else
			{ ?>
            <tr class="rec">
              <td colspan="4" style="text-align: center;"><b>No Users yet.</b></td>
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
}?>