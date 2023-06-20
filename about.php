<?php
require_once("includes/config.php");
$page_description = "Personal Business Blog helps you to achieve financial freedom through a financial education. We're always struggling to provide the best value to our readers."
?>

<!DOCTYPE html>
<html lang="en-US">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="<?= $page_description ?>">
  <meta name="og:image" property="og:image" content="<?= $domainUrl;?>/logo/personal-business-blog-logo-complex.png" />
  <meta name="og:description" property="og:description" content="<?= $page_description ?>" />
  <meta name="og:title" property="og:title" content="Personal Business Blog" />
  <meta name="twitter:card" property="twitter:card" content="summary" />
  <meta name="twitter:title" property="twitter:title" content="Personal Business Blog" />
  <meta name="twitter:description" property="twitter:description" content="<?= $page_description ?>" />
  <meta name="twitter:image" property="twitter:image"
    content="<?= $domainUrl;?>/logo/Personal-Business-Blog-Logo-Twitter-Profile.png" />
  <meta property="og:image:width" content="200" />
  <meta property="og:image:height" content="200" />
  <link rel="stylesheet" href="css/style.css?<?= time() ?>" media="all">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
  <!-- CSS only -->

  <title>Personal Business Blog | About Us</title>

  <style>
  .owl-nav,
  .owl-dots {
    display: block !important;
  }

  @media(max-width:790px) {
    .footer {
      text-align: center;
    }
  }

  .title {
    text-align: center;
  }
  </style>

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-135119183-6"></script>
  <script>
  window.dataLayer = window.dataLayer || [];

  function gtag() {
    dataLayer.push(arguments);
  }
  gtag('js', new Date());

  gtag('config', 'UA-135119183-6');
  </script>

  <!-- Facebook Pixel Code -->
  <script>
  ! function(f, b, e, v, n, t, s) {
    if (f.fbq) return;
    n = f.fbq = function() {
      n.callMethod ?
        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
    };
    if (!f._fbq) f._fbq = n;
    n.push = n;
    n.loaded = !0;
    n.version = '2.0';
    n.queue = [];
    t = b.createElement(e);
    t.async = !0;
    t.src = v;
    s = b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t, s)
  }(window, document, 'script',
    'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '507241037348710');
  fbq('track', 'PageView');
  </script>
  <noscript><img height="1" width="1" style="display:none"
      src="https://www.facebook.com/tr?id=507241037348710&ev=PageView&noscript=1" /></noscript>
  <!-- End Facebook Pixel Code -->
  <script type="text/javascript">
  (function(c, l, a, r, i, t, y) {
    c[a] = c[a] || function() {
      (c[a].q = c[a].q || []).push(arguments)
    };
    t = l.createElement(r);
    t.async = 1;
    t.src = "https://www.clarity.ms/tag/" + i;
    y = l.getElementsByTagName(r)[0];
    y.parentNode.insertBefore(t, y);
  })(window, document, "clarity", "script", "6iqp7jf93f");
  </script>
</head>

<body>
  <?php require_once("includes/headers/header.php"); ?>
  <div style="width:70%;margin: 0 auto" class="page-wrapper about">

    <div class="about-main">

      <br><br>
      <h1 class="title">About Personal Business Blog</h1><br>
      <p>
        Personal Business Blog is a business blog created in December 2020. As a business blog, we cover all business
        topics, including marketing, self-help, and technology.</p>
      <br>
      <h2 class="title">Why Personal Business Blog?</h2><br>

      <p>Personal Business Blog is created as a school project of the founder, Rade Petrovic, but became a stable
        community of writers after just one year.
      </p>

      <br><br>
      <h2 class="title">Our team</h2>
      <br><br>
      <div class="about-us-figures">
        <figure class="about-us-figure">
          <img src="https://i.imgur.com/0GuIHrX.jpg" alt="rade petrovic" />
          <figcaption class="inner-figcaption">
            <h3 class="figure-title">Rade Petrovic</h3><br>
            <p style="font-size:18px" class="figure-text"><span>IT engineer</span> <br><br>IT and business geek
              passionate in writing.</p>
          </figcaption>
        </figure>

        <figure class="about-us-figure">
          <img src="https://i.imgur.com/MiWCJo5.jpg" alt="Shyla Chabra" />
          <figcaption class="inner-figcaption">
            <h3 class="figure-title">Shyla Chabra</h3><br>
            <p style="font-size:18px" class="figure-text"><span>Bachelor of psychology</span><br><br>Highly motivated
              and passionate writer highly experienced in self-help niche.</p>
          </figcaption>
        </figure>
        <figure class="about-us-figure">
          <img src="https://i.imgur.com/2peaIf7.jpg" alt="David Hill" />
          <figcaption class="inner-figcaption">
            <h3 class="figure-title">David Hill</h3><br>
            <p style="font-size:18px" class="figure-text"><span>MBA</span><br><br>"My favorite topic are sales because
              to sell is human."</p>
          </figcaption>
        </figure>
      </div>
    </div>
  </div>

  <br><br> <br><br>

  <?php require_once("includes/footers/footer.php"); ?>

  <script src="https://kit.fontawesome.com/ee654fe705.js" crossorigin="anonymous"></script>

</body>

</html>