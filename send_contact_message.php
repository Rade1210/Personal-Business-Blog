<?php

$to = "loremipsum";
$subject = "New message";

ob_start();

?>

<p>
  <b>Email Address:</b> <?=$_POST['email_address']?>
</p>

<p>
  <b>Message:</b> <?=$_POST['message']?>
</p>

<?php
$message = ob_get_clean();

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <loremipsum>' . "\r\n";

if(mail($to,$subject,$message,$headers)) echo 'sent';

?>