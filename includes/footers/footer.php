<!DOCTYPE html>
<html lang="en">

<head>
  <style>
  @media only screen and (max-width: 600px) {
    #stay-in-touch {
      text-align: center;
    }
  }

  @media(max-width:790px) {
    .footer {
      text-align: center;
      list-style-type: none;
    }

    .footer .footer-content .quick-links ul li {
      list-style-type: none;
    }

    #newsletter-text {
      text-align: center;
    }

  }

  #newsletterInputField {
    width: 60%;
    margin-left: 9px;
    padding: 9px;
    border-radius: 5px;
  }

  #newsletter-button {
    padding: 9px;
    border-radius: 5px;
    margin-left: 9px;
    background-color: white;
    cursor: pointer;
    width: 100px;
  }
  </style>

</head>

<body>


  <!-- FOOTER -->
  <div class="footer">
    <div class="footer-content">
      <div class="footer-section about">
        <h2 id="stay-in-touch">Stay in touch</h2>

        <div class="social">
          <a href="<?= $domainUrl;?>" aria-label="Facebook page"><i class="fa fa-facebook"></i></a>
          <a href="<?= $domainUrl;?>" aria-label="Instagram page"><i class="fa fa-instagram"></i></a>
          <a href="<?= $domainUrl;?>" aria-label="Twitter page"><i class="fa fa-twitter"></i></a>
          <a href="<?= $domainUrl;?>" aria-label="Youtube page"><i class="fa fa-youtube-play"></i></a>
        </div>

      </div>

      <div class="footer-section quick-links">
        <h2>Quick Links</h2>
        <ul>
          <li style="list-style-type:none"></li><a href="<?= $domainUrl;?>/privacy.php">Privacy Policy</a></li>
          <li style="list-style-type:none"><a href="<?= $domainUrl;?>/terms.php">Terms of service</a></li>
        </ul>
      </div>

      <div class="footer-section about">
        <h2>Sign in to our newsletter</h2>
        <p id="newsletter-text" style="margin-left:9px">We respect your privacy. PBB uses the information you provide to
          send you only relevant content. You may unsubscribe from the newsletter at any time. For more information,
          check out our <a style="color:#0384fc" href="../../privacy.php">privacy policy</a>.</p>
        <form action="gift.php" method="post">
          <input type="email" name="newsletterInputField" id="newsletterInputField" placeholder="Email address">
          <br> <br>
          <input id="newsletter-button" name="newsletter-submit-button" type="submit" value="Sign In">
        </form>
      </div>

    </div>

    <div class="footer-bottom">
      <p>Copyright © 2022 Personal Business Blog </p>
    </div>
  </div>
  <!-- // FOOTER -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script type="text/javascript" src="<?= $domainUrl;?>/js/scripts.js?5"></script>

</body>

</html>