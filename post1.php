<?php
$page_dir = '../';
require_once("includes/config.php");
$postresult = [];
if (isset($_GET['title']) && $_GET['title'] != "") {
  $title = urldecode($_GET["title"]);
  $post_title = str_replace("-", " ", $title);
  $postsql = mysqli_query($conn, "SELECT * FROM posts WHERE title='" . $post_title . "' and published='1'");
  if (mysqli_num_rows($postsql)) {
    while ($row = mysqli_fetch_assoc($postsql)) {
      $postresult = $row;
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../css/font-awesome.min.css" />
  <link rel="stylesheet" href="https://personalbusinessblog.com/css/style.css">
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  <meta name="description" content="<?= $postresult['meta_description'] ?>">
  <meta name="og:image" property="og:image"
    content="https://personalbusinessblog.com/admin/posts/post_images/<?= $postresult['image']; ?>" />
  <meta name="og:type" property="og:type" content="article" />
  <meta name="og:description" property="og:description" content="<?= $postresult['meta_description'] ?>" />
  <meta name="og:title" property="og:title" content="<?= $postresult['title'] ?> | PersonalBusinessBlog.com" />
  <meta name="twitter:card" property="twitter:card" content="summary" />
  <meta name="twitter:title" property="twitter:title"
    content="<?= $postresult['title'] ?> | PersonalBusinessBlog.com" />
  <meta name="twitter:description" property="twitter:description" content="<?= $postresult['meta_description'] ?>" />
  <meta name="twitter:image" property="twitter:image"
    content="https://personalbusinessblog.com/admin/posts/post_images/<?= $postresult['image']; ?>" />
  <meta property="og:image:width" content="1200" />
  <meta property="og:image:height" content="625" />
  <meta name="url" content="<?= $postresult['meta_url'] ?>">
  <title><?= $postresult['title'] ?> | PersonalBusinessBlog.com</title>
  <style>
  .ql-font-arial {
    font-family: 'Arial', sans-serif !important;
  }

  .ql-font-candal {
    font-family: 'Arial', sans-serif !important;
  }

  h1 {
    font-family: Arial;
    font-weight: bold;
  }

  .ql-editor h1 {
    color: #444444;
  }

  @media screen and (max-width: 650px) {

    .footer .footer-content .contact-form-div h2,
    .page-content h2,
    h4 {
      text-align: center !important;
    }
  }
  </style>
</head>

<body>
  <div id="fb-root"></div>
  <script>
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src =
      'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.2&appId=285071545181837&autoLogAppEvents=1';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
  </script>
  <?php require_once("includes/headers/header.php"); ?>
  <div class="page-wrapper">
    <div class="content clearfix">
      <div class="page-content single ql-editor">
        <?php
        if (!empty($postresult)) {
        ?>
        <h1 style="text-align: center; font-size: 1.75em"><?= $postresult['title']; ?></h1>
        <?= $postresult['body']; ?>
        <?php
        }
        ?>
      </div>
    </div>
  </div>
  <?php require_once("includes/footer.php"); ?>

  <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
  <!--<script src="https://personalbusinessblog.com/js/font.js"></script>-->
</body>

</html>