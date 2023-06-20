<?php require_once 'includes/config.php' ?>

<?php

if (isset($_POST['newsletter-submit-button'])) {

    $newsletterEmail = $_POST['newsletterInputField'];

    if ($_SESSION['user_id'] != null && $_SESSION['verified'] != '0000-00-00 00:00:00') {
        mysqli_query($conn, "UPDATE users SET newsletter = 1 WHERE id=" . $_SESSION['user_id']);
    } else if ($_SESSION['user_id'] != null && $_SESSION['verified'] == '0000-00-00 00:00:00') {
        mysqli_query($conn, "UPDATE users SET newsletter = 1 WHERE id=" . $_SESSION['user_id']);
    } else {
        $stmt = $conn->prepare("INSERT INTO newsletter_emails(`newsletter_email`) VALUES (?)");
        $stmt->bind_param("s", $newsletterEmail);
        $stmt->execute();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Business Blog | Gift</title>
</head>

<body>

    <h1>Thank you for signing in</h1>

</body>

</html>