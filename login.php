<?php

//Admin must have id = 1 to be able do access the dashboard

require_once("includes/config.php");
require_once 'vendor/autoload.php';


// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

if (isset($_POST['login-btn'])) {

    if (isset($_POST['email']))
        $email = mysqli_real_escape_string($conn, trim($_POST['email']));

    if (isset($_POST['password']))
        $password = mysqli_real_escape_string($conn, trim($_POST['password']));

    if (strlen($email) == 0)
        $errors[] = "Please enter your email";

    if (strlen($password) == 0)
        $errors[] = "Please enter your Password";

    if (strlen($email) > 0) {

        $_SESSION["email"] = $email;
        $user_select_query = "SELECT password FROM users WHERE email = '$email'";
        $user_select = mysqli_query($conn, $user_select_query);

        if (mysqli_num_rows($user_select) == 0) {
            $errors[] = "Incorrect email or password";
        }
    }

    if (strlen($password) > 0) {
        $_SESSION["password"] = $password;
        $password_select_query = "SELECT password FROM users WHERE email = '$email'";
        $password_select = mysqli_query($conn, $password_select_query);

        if (mysqli_num_rows($password_select) > 0) {
            $saved_password_row = mysqli_fetch_assoc($password_select);
            $saved_password = $saved_password_row["password"];

            if (!password_verify($password, $saved_password)) {
                $errors[] = "Incorrect email or password";
            }
        }
    }

    if (count($errors) == 0) {

        $emailquery = "SELECT * FROM users WHERE email='" . $_POST['email'] . "'";
        $emailresults = mysqli_query($conn, $emailquery);
       
        if (mysqli_num_rows($emailresults) == 1) {
            $emailrow = mysqli_fetch_assoc($emailresults);
            if ($emailrow['admin'] == "1") {
                $_SESSION['admin'] = $emailrow['id'];
                $_SESSION['username'] = $emailrow['username'];
                $_SESSION['user_id'] = $emailrow['id'];
            }
            
            $_SESSION['username'] = $emailrow['username'];
            $_SESSION['user_id'] = $emailrow['id'];
            $_SESSION['verified'] = $emailrow['email_verified_at'];
        }
        

        if ($_SESSION['verified'] == '0000-00-00 00:00:00' || $_SESSION['verified'] == null
          || $_SESSION['verified']=="" || empty($_SESSION['verified'])){
            header("Location: email_verification.php?email=$email");die;
          }
            
            
        header("Location: index.php");

        exit();
    }
}

$login_page_description = "Login to your profile manually or with Google";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="<?php echo $login_page_description?>">
  <link rel="stylesheet" href="<?= $domainUrl;?>/css/style.css">
  <link rel="stylesheet" href="css/font-awesome.min.css" />
  <title>Personal Business Blog | Login</title>
</head>

<body>


  <div class="auth-content">

    <form id="login-form" action="login.php" method="post" onsubmit="return check_captcha_filled()">
      <h1 class="form-title">Login</h1>
      <?php require_once 'includes/print_errors.php' ?>

      <div>
        <label>Email</label>
        <input type="text" name="email" class="text-input" value="<?php isset($_SESSION["email"]) ? $_SESSION["email"] : null;
                                                                            echo $_SESSION['email'] ?>">
      </div>
      <div>
        <label>Password</label>
        <input type="password" name="password" class="text-input" value="<?php isset($_SESSION["password"]) ? $_SESSION["password"] : null;
                                                                                    echo $_POST['password'] ?>">
      </div>
      <div id="captcha-div">
        <div class="g-recaptcha" style="transform: scale(0.80); 
-webkit-transform: scale(0.80); transform-origin: 0 0;
-webkit-transform-origin: 0 0;" data-callback="captcha_filled" data-expired-callback="captcha_expired"
          data-sitekey="<?= $google_captcha_key;?>"></div>
      </div>
      <br>
      <div>
        <button type="submit" name="login-btn" class="btn">Login</button>
      </div>
      <p class="auth-nav">Or <a href="register.php">Register</a></p>
    </form>
    <br>
    <div class="social-media-login-divider">
      <span>Or</span>
      <br><br>
      <div class="login-with-google-div">
        <a style="width:200px" class="btn" href="<?php echo $client->createAuthUrl(); ?>"><img
            style="width:22px;height:22px;float:left" src="https://i.imgur.com/klaijv1.png"><span>Login With
            Google</span></a>
      </div>


    </div>
  </div>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <script src="https://kit.fontawesome.com/ee654fe705.js" crossorigin="anonymous"></script>
</body>

<script>
var allow_submit = false

function captcha_filled() {

  allow_submit = true
}

function captcha_expired() {

  allow_submit = false
}

function check_captcha_filled(e) {
  console.log('captcha-verified')

  if (!allow_submit) {

    alert('ERROR: Please verify you are human by filling out the captcha')

    return false
  }
  captcha_expired()
  return true
}
</script>

</html>