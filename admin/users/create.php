<?php
require_once("../../includes/config.php");
session_start();
if(isset($_POST['save-user']))
{
	if(empty($_POST['username']))
        $errors[] = "Username required";
    if(empty($_POST['email']))
        $errors[] = "Email Address required";
	if(empty($_POST['password']))
        $errors[] = "Password required";
	if(empty($_POST['passwordConf']))
        $errors[] = "Confirm Password required";
	if($_POST['password'] != $_POST['passwordConf'])
        $errors[] = "Password and Confirm Password should match";
	if(count($errors) == 0)
	{
		$usersresults = mysqli_query($conn, "SELECT * FROM users WHERE username='" . $_POST['username'] . "'");
		if(mysqli_num_rows($usersresults) > 0)
			$errors[] = "Username already exists.";
		else
		{
            $role = mysqli_real_escape_string($conn, $_POST["role"]);
            $username = mysqli_real_escape_string($conn, $_POST["username"]);
		    $password = mysqli_real_escape_string($conn, $_POST["password"]);
            $email = mysqli_real_escape_string($conn, $_POST["email"]);
		    $password_hash = password_hash($password,  PASSWORD_DEFAULT);
			mysqli_query($conn, "INSERT INTO users SET admin='".$role."', username='".$username."', email='".$email."', password='".$password_hash."'");
			$_SESSION['success'] = "User Created Successfully.";
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
  <link rel="stylesheet" href="../../css/admin.css">
  <title>Admin - Create Admin User</title>
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
        <a href="create.php" class="btn btn-md">Add User</a>
        <a href="index.php" class="btn btn-md">Manage Users</a>
      </div>
      <div class="">
        <h2 style="text-align: center;">Create User</h2>
		<?php
			require_once("../print_errors.php");
			require_once("../show_messages.php");
		?>
        <form action="create.php" method="post">
          <div class="input-group">
            <label>Username</label>
            <input type="text" name="username" class="text-input">
          </div>
          <div class="input-group">
            <label>Email</label>
            <input type="email" name="email" class="text-input">
          </div>
          <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" class="text-input">
          </div>
          <div class="input-group">
            <label>Confirm Password</label>
            <input type="password" name="passwordConf" class="text-input">
          </div>
          <div class="input-group">
            <label>Role</label>
            <select class="text-input" name="role">
              <option value="0">User</option>
              <option value="1">Admin</option>
            </select>
          </div>
          <div class="input-group">
            <button type="submit" name="save-user" class="btn">Save User</button>
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