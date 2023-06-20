<!DOCTYPE html>
<html lang="en">

<head>
  <style>
  @media only screen and (max-width: 600px) {
    #stay-in-touch {
      text-align: center;
    }
  }

  h2 {
    display: block;
    font-size: 1.5em;
    margin-block-start: 0.83em;
    margin-block-end: 0.83em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold;
  }
  </style>

</head>

<body>

  <!-- FOOTER -->
  <div class="footer">
    <div class="footer-content">
      <div class="footer-section about">
        <h2 class="font-bold text-3.5xl" id="stay-in-touch">Stay in touch</h2>

        <div class="social">
          <a href="#"><i class="fa fa-facebook"></i></a>
          <a href="#"><i class="fa fa-instagram"></i></a>
          <a href="#"><i class="fa fa-twitter"></i></a>
          <a href="#"><i class="fa fa-youtube-play"></i></a>
        </div>

      </div>

      <div class="footer-section quick-links">
        <h2 class="font-bold text-3.5xl">Quick Links</h2>
        <ul>
          <a href="<?= $domainUrl;?>/terms.php">
            <li>Terms and Conditions</li>
          </a>
          <a href="<?= $domainUrl;?>/privacy.php">
            <li>Privacy Policy</li>
          </a>
        </ul>
      </div>

      <div class="footer-section contact-form-div">

      </div>

    </div>

    <div class="footer-bottom">
      <p>Copyright © 2022 Personal Business Blog </p>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script type="text/javascript" src="<?= $domainUrl;?>/js/scripts.js?5"></script>
  <script src="https://cdn.tailwindcss.com"></script>

</body>

</html>