<?php
//session_start();
ini_set('display_errors',1);
require_once 'vendor/autoload.php';
require_once("includes/config.php");  
   
// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");
$client->setApprovalPrompt("force");

if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

  if(array_key_exists('error', $token)) {
    echo "Invalid Code";
    die;
  }
  if(array_key_exists('access_token', $token)) {
    $client->setAccessToken($token['access_token']);
    
    // get profile info
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $email =  $google_account_info->email;
    $username = explode("@",$email);
    $profile_image = $google_account_info->picture;
    $name =  $google_account_info->name;
    $checkexistence = "SELECT * FROM users WHERE email = '$email'";
    $user_select = mysqli_query($conn, $checkexistence);
    //check if user exists in database or not
    if (!mysqli_num_rows($user_select)) {
      $password = strand(6);
      $password_hash = password_hash($password, PASSWORD_DEFAULT);
      $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
      $result = mysqli_query($conn, "INSERT INTO users SET 
        username='" . $username[0] . "', google_profile_image='" . $profile_image . "', email='" . $email . "', password='" . $password_hash . "',
        verification_code='" . $verification_code . "', email_verified_at=NOW()");
    }
    $user = mysqli_query($conn, $checkexistence);
    $user = mysqli_fetch_assoc($user);
    if (count($user) > 0 && array_key_exists('username', $user)) {
      $_SESSION['username'] = $user['username'];
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['admin'] = $user['admin'];
      $_SESSION['verified'] = $user['email_verified_at'];
      header("Location: index.php");
      exit();
    }
  }
}

function strand($length){
  if($length > 0)
    return chr(rand(33, 126)) . strand($length - 1);
}

?>