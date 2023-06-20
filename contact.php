<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Business Blog | Contact Us</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>

        .container{
            width:25%;
            margin:0 auto;
        }

        @media(max-width:1100px){
            .container{
            width:30%;
            margin:0 auto;
            }
        }

        @media(max-width:769px){
            .container{
            width:40%;
            margin:0 auto;
            }
        }

        @media(max-width:600px){
            .container{
            width:50%;
            margin:0 auto;
            }
        }

        @media(max-width:500px){
            .container{
            width:60%;
            margin:0 auto;
            }
        }
        
        #contact-form-container{
            justify-content: center;

        }
        #contactSendBtn{
            border: 1px solid black;
            background-color: white;
            border-radius:5px;
            padding:11px 15px;
            cursor:pointer;
            font-size:17px;
            margin-left:-6px;
         }
         #contactSendBtn:hover{
          background-color: black;
          color:white;
          transition: 0.5s;
         }

        </style>
</head>
<body>
<?php require_once 'includes/headers/header.php'?>
<div class="footer-section contact-form-div">
<br><br>
<h1 style="text-align:center">Send us a message</h1>
<div id="contact-form-container" class="container">
<br>
<form action="contact.php" method="post" id="contactForm">
<br><br> <input type="text" name="email_address" class="text-input contact-input" id="contactEmail" placeholder="Your email address"><br><br>
  <textarea name="message" cols="30" rows="3" class="text-input contact-input" id="contactMessage" placeholder="Message..."></textarea>
  <br><br><button type="submit" name="send-msg-btn" class="send-msg-btn">
  <span id="contactSendBtn">Send</span>
  </button>
</form>
</div>
</div>
<br><br><br><br><br><br><br>
<?php require_once 'includes/footers/footer.php'?>

<script src="https://kit.fontawesome.com/ee654fe705.js" crossorigin="anonymous"></script>

</body>
</html>