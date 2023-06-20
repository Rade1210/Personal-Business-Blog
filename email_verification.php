<?php

require_once 'includes/config.php';

if (isset($_POST['verify_email'])) {

    $email = $_POST['email'];
    $verification_code = $_POST['verification_code'];

    $sql = "UPDATE users SET email_verified_at = NOW() WHERE email='" . $email . "' AND verification_code='" . $verification_code . "'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) == 0) {
        die("Verification code failed");
    }

    header("Location: thank_you.php");
    
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify your email</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
        }
        #verify-email{
            text-align: center;
            border: 1px solid black;
            background-color: white;
            border-radius:5px;
            padding:11px 15px;
            cursor:pointer;
            font-size:17px;
        }

        #verify-email:hover{
            background-color: black;
            color:white;
            transition: 0.5s;
        }
        #verification-code-input-field{
            padding:12px;
        }

        h1{
            text-align: center;
        }

        #please-verify{
            text-align: center;
            font-size:17px;
        }

        .container{
            justify-content: center;
        }

    </style>
</head>
<body>
<br>
<h1>Verify your account</h1>

<p id="please-verify">We sent a verification code to your email. Please enter your code below to verify your email address. </p>
<br>
<div style="display:flex;" class="container">

<form method="post">
    <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>" required>
    <input id="verification-code-input-field" type="text" name="verification_code" placeholder="Enter the verification code" required>
    
    <input id="verify-email" type="submit" name="verify_email" value="Verify Email">
</form>

</div>


    
</body>
</html>

