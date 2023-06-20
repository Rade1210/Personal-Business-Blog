<?php
require_once("../../includes/config.php");
session_start();
$userssql = mysqli_query($conn, "SELECT * FROM users WHERE id='" . $_GET['id'] . "'");
$usersresults = mysqli_fetch_assoc($userssql);
if(isset($_POST['delete-user']))
{
	if(mysqli_num_rows($userssql) > 0)
	{
		mysqli_query($conn, "DELETE from users where id='".$_GET['id']."'");
		$_SESSION['success'] = "User Deleted Successfully.";
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
  <title>Admin - Delete User</title>
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
        <a href="create.php" class="btn btn-sm">Add User</a>
        <a href="index.php" class="btn btn-sm">Manage Users</a>
      </div>
      <div class="">
        <h2 style="text-align: center;">Delete User</h2>
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
            <label>Username</label>
            <input type="text" name="username" class="text-input" value="<?=$usersresults['username'];?>" disabled="disabled">
          </div>
          <div class="input-group">
            <label>Email</label>
            <input type="email" name="email" class="text-input" value="<?=$usersresults['email'];?>" disabled="disabled">
          </div>
          <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" class="text-input" value="<?=$usersresults['password'];?>" disabled="disabled">
          </div>
          <div class="input-group">
            <label>Role</label>
            <select class="text-input" name="role" id="role" disabled="disabled">
              <option value="0">User</option>
              <option value="1">Admin</option>
            </select>
			<script>document.getElementById("role").value='<?=$usersresults["admin"]?>';</script>
          </div>
          <div class="input-group">
            <button type="submit" name="delete-user" class="btn">Delete User</button>
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
header("Location:../../404.html");
?>