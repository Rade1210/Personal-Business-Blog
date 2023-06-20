<?php

require_once 'includes/config.php';

$result = mysqli_query($conn, "SELECT * FROM users WHERE id=" . $_SESSION['user_id']);

$username = mysqli_real_escape_string($conn, $_POST["username"]);
$email = mysqli_real_escape_string($conn, $_SESSION["email"]);
$currentPassword = mysqli_real_escape_string($conn, $_POST["currentPassword"]);
$newPassword = mysqli_real_escape_string($conn, $_POST["newPassword"]);
$repeatPassword = mysqli_real_escape_string($conn, $_POST["repeatPassword"]);
$password_hash = password_hash($newPassword, PASSWORD_DEFAULT);

$passwordFromDatabase = "SELECT password FROM users WHERE id=" . $_SESSION['user_id'];

if (isset($_POST['change-info-button'])) {

    if (strlen($currentPassword) > 0) {

        $password_select_query = "SELECT password FROM users WHERE id=" . $_SESSION['user_id'];
        $password_select = mysqli_query($conn, $password_select_query);

        if (mysqli_num_rows($password_select) > 0) {
            $saved_password_row = mysqli_fetch_assoc($password_select);
            $saved_password = $saved_password_row["password"];

            if (password_verify($currentPassword, $saved_password) == false) {
                $errors[] = "Your current password is wrong";
            }
        }
    } else {
        $errors[] = "Current password is empty";
    }

    if (count($errors) == 0) {
        if ($newPassword == 0 && $repeatPassword == 0) {
            mysqli_query($conn, "UPDATE users SET username='" . $username . "', email='" . $email . "' WHERE id=" . $_SESSION['user_id']);
        } else {
            mysqli_query($conn, "UPDATE users SET username='" . $username . "', email='" . $email . "', password='" . $password_hash  . "' WHERE id=" . $_SESSION['user_id']);
        }
    }
}

?>

<?php 

if($_SESSION['user_id'] == null) {
header("location:$domainUrl/404.html");
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" type="text/css" href="css/user_profile.css">
  <title>Personal Business Blog | Edit Profile</title>
</head>

<body>
  <?php include 'includes/headers/header.php' ?>

  <?php
    if (isset($_POST['change-info-button'])) {
        require_once 'includes/show_messages.php';
        require_once 'includes/print_errors.php';
    }

    ?>

  <div class="container">

    <?php if ($result->num_rows > 0) { ?>
    <div class="image-div">
      <?php while ($row = $result->fetch_assoc()) { ?>
      <?php if($row['profile_image'] != null){ ?>
      <img class="user-profile-image"
        src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['profile_image']); ?>" />
      <?php } 
      
      else if($row['google_profile_image'] != null){ ?>

      <?php } 
      
      else {?>
      <img class="user-profile-image" src="https://i.imgur.com/YCBdehQ.png" alt="user placeholder">
      <?php } ?>
      <br><br>
      <h2>User info:</h2>
      <p>Username: <?php echo $_SESSION['username'] ?></p>
       <p>Email: <?php echo $row['email'] ?></p>
      <?php } ?>
    </div>
    <?php } ?>
    <div style="text-align:left" class="user-info-div">
      <form action="user_profile.php" method="post">
        <div><label class="user-profile-labels" for="">Username:</label><input class="user-profile-input" type="text"
            name="username" value="<?php 
                
                if(isset($_POST['change-info-button'])){
                    echo $_POST['username'];
                }

                else {
                    echo $_SESSION['username']; 
                }
                
                ?>"></div>
        <div><label class="user-profile-labels" for="">Current Password:</label><input class="user-profile-input"
            type="password" name="currentPassword"></div>
        <div><label class="user-profile-labels" for="">New Password:</label><input class="user-profile-input"
            type="password" name="newPassword"></div>
        <div><label class="user-profile-labels" for="">Repeat New Password:</label><input class="user-profile-input"
            type="password" name="repeatPassword"></div>
        <input style="margin-left:5%" id="change-info-button" name="change-info-button" type="submit"
          value="Change info">
      </form>
    </div>
  </div>
  <?php include 'includes/footers/footer.php' ?>
  <script src="https://kit.fontawesome.com/ee654fe705.js" crossorigin="anonymous"></script>
</body>

</html>