<?php

//PHPMailer globals
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Composer autoloader

require 'vendor/autoload.php';

require_once("includes/config.php");
session_start();

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");
    
  if (isset($_POST['register-btn'])) {
      
    if (!preg_match('/^[\w]{0,10}$/', $_POST['username'])) 
    $errors[] = "Username must contain only numbers and letters and it must be up to 10 characters long";
    
    $pattern8Char = '/^.{8,}$/';
    $patternUppercaseChar = '/^(?=.*[A-Z])/';
    $patternMinOneNumber = '/^(?=.*[0-9])/';
    $patternMinOneSpecialChar = '/[`!%$&^*#]+/';
    
    if (!preg_match($pattern8Char, $_POST['password'])) 
    $errors[] = "Password must be longer than 8 characters";
    
    if (!preg_match($patternUppercaseChar, $_POST['password'])) 
    $errors[] = "Password must contain at least one uppercase character";
    
    if (!preg_match($patternMinOneNumber, $_POST['password'])) 
    $errors[] = "Password must contain at least one number";
    
    if (!preg_match($patternMinOneSpecialChar, $_POST['password'])) 
    $errors[] = "Password must contain at least one special character (!,%,$,&,^,*,#)";
    
    if (empty($_POST['username']))
      $errors[] = "Username is required";
    if (empty($_POST['email']))
      $errors[] = "Email is required";
    if (empty($_POST['password']))
      $errors[] = "Password is required";
    if ($_POST['passwordConf'] !== $_POST['password'])
      $errors[] = "Password and Confirm Password do not match";

    //Exception handling for PHP Mailer
    $mail = new PHPMailer(true);

    try {

      //Using a debug server
      $mail->SMTPDebug = 0;

      //Protocol definition
      $mail->isSMTP();

      //Data

      $mail->Host = 'smtp.domain.com';

      $mail->SMTPAuth = true;

      $mail->Username = 'loremipsum';

      $mail->Password = 'loremipsum';

      //TLS encryption

      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

      //TCP port

      $mail->Port = 587;

      //From

      $mail->setFrom('loremipsum', 'loremipsum');

      //Recipient

      $mail->addAddress($_POST["email"], $_POST["username"]);

      //HTML mail format

      $mail->isHTML(true);

      $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

      $mail->Subject = 'Email verification';

      $mail->Body = '<p>Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></p>';

      $mail->send();

      if (count($errors) == 0) {

        $query = "SELECT * FROM users WHERE username='" . $_POST['username'] . "'";
        $results = mysqli_query($conn, $query);
        if (mysqli_num_rows($results) > 0)
          $errors[] = "Username already exists.";
        else {
          $query = "SELECT * FROM users WHERE email='" . $_POST['email'] . "'";
          $results = mysqli_query($conn, $query);
          if (mysqli_num_rows($results) > 0)
            $errors[] = "Email already exists.";
          else {
            $username = mysqli_real_escape_string($conn, $_POST["username"]);
            $email = mysqli_real_escape_string($conn, $_POST["email"]);
            $password = mysqli_real_escape_string($conn, $_POST["password"]);
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $_SESSION['username'] = $_POST["username"];
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['user_id'] = mysqli_insert_id($conn);

            if (isset($_FILES["userImage"]) && !empty($_FILES["userImage"]["name"])) {
              // Get file info 
              $fileName = basename($_FILES["userImage"]["name"]);
              $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

              // Allow certain file formats 
              $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');
              if (in_array($fileType, $allowTypes)) {
                $image = $_FILES['userImage']['tmp_name'];
                $imgContent = addslashes(file_get_contents($image));

                // Insert image content into database 
                mysqli_query($conn, "INSERT INTO users SET username='" . $username . "', email='" . $email . "', password='" . $password_hash . "', profile_image='" . $imgContent . "', verification_code='" . $verification_code . "'");
              }
            }
            else {
              mysqli_query($conn, "INSERT INTO users SET username='" . $username . "', email='" . $email . "', password='" . $password_hash . "', verification_code='" . $verification_code . "'");
              
            }

            header("Location: email_verification.php?email=" . $email);

            exit();
          }
        }
      }
    } catch (Exception $e) {
      echo "<p style='visibility:hidden'>Message couldn't be sent. Mailer error: {$mail->ErrorInfo}</p>";
    }
  } 

$register_meta_description = "Create an account manually or using email";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="<?php echo $register_meta_description?>">
  <link rel="stylesheet" href="css/font-awesome.min.css" />
  <link rel="stylesheet" href="<?= $domainUrl;?>/css/style.css">
  <title>Personal Business Blog | Register</title>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>

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
  <div class="auth-content">
    <form action="register.php" method="post" onsubmit="return check_captcha_filled()" enctype="multipart/form-data">
      <h1 class="form-title">Join the Personal Business Blog</h1>
      <?php
      require_once("includes/print_errors.php");
      ?>
      <div>
        <label>Username</label>
        <input type="text" name="username" class="text-input" value="<?php echo $_POST['username'] ?>">
      </div>
      <div>
        <label>Email</label>
        <input type="email" name="email" class="text-input" value="<?php echo $_POST['email'] ?>">
      </div>
      <div>
        <label>Password</label>
        <input type="password" name="password" class="text-input" value="<?php echo $_POST['password'] ?>">
      </div>
      <div>
        <label>Confirm Password</label>
        <input type="password" name="passwordConf" class="text-input" value="<?php echo $_POST['passwordConf'] ?>">
      </div>
      <br>
        <!--profile image-->
      <div id="captcha-div">
        <div class="g-recaptcha" style="transform: scale(0.77); 
-webkit-transform: scale(0.77); transform-origin: 0 0;
-webkit-transform-origin: 0 0;" data-callback="captcha_filled" data-expired-callback="captcha_expired"
          data-sitekey="<?= $google_captcha_key;?>"></div>
      </div>
      <p>By clicking "Register", you agree to our <a style="color:blue;" href="<?= $domainUrl;?>/terms.php">terms of
          service</a>, and <a style="color:blue" href="<?= $domainUrl;?>/privacy.php">privacy policy</a></p>
      <br>
      <div>
        <button type="submit" name="register-btn" class="btn">Register</button>
      </div>
      <p class="auth-nav">Or <a href="login.php">Login</a></p>
    </form>
    <br>
    <div class="social-media-login-divider">
      <span>Or</span>
      <br><br>
      <div class="login-with-google-div">
        <a style="width:200px;" class="btn" href="<?php echo $client->createAuthUrl(); ?>"><img
            style="width:22px;height:22px;float:left" src="https://i.imgur.com/klaijv1.png"><span>Sign in with
            Google</span></a>
      </div>
    </div>
    <script type="text/javascript" src="js/jquery.min.js"></script>
</body>

</html>