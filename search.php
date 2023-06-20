<?php require_once("includes/config.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="<?= $domainUrl;?>/css/font-awesome.min.css" />
  <link rel="stylesheet" href="<?= $domainUrl;?>/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" />
  <title>Personal Business Blog</title>
  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-W6XDBNCJKX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'loremipsum');
</script>
<style>h1{font-family:Arial;}</style>
</head>

<body>
  <?php require_once("includes/header.php"); ?>
  <div class="page-wrapper">
    <div class="content clearfix">
      <div class="page-content">
        <h1 class="recent-posts-title" style="text-align: center;font-family:Arial;font-weight:bold">Search Results</h1>
        <?php
        if (isset($_GET['query']) && $_GET['query'] != "")
          $postsql = mysqli_query($conn, "SELECT * FROM posts WHERE title LIKE '%" . $_GET['query'] ."%' and published='1' order by id desc");
        else
          $postsql = mysqli_query($conn, "SELECT * FROM posts WHERE published='1' order by id desc");
        $postscount = mysqli_num_rows($postsql);
        if ($postscount > 0) {
          while ($postresult = mysqli_fetch_assoc($postsql)) {
            $authorsql = mysqli_query($conn, "SELECT * FROM users WHERE id='" . $postresult['user_id'] . "'");
            $authorresult = mysqli_fetch_assoc($authorsql);
            
            $post_title = str_replace(" ", "-", $postresult['title']);
              $post_title = strtolower($post_title);
        ?>
            <div class="post clearfix">
              <img src="admin/posts/post_images/<?= $postresult['image']; ?>" class="post-image" alt="">
              <div class="post-content">
                <h2 class="post-title"><a href="post/<?= $post_title ?>"><?= $postresult['title']; ?></a></h2>
                <div class="post-info">
                  <i class="fa fa-user-o"></i> <?= $authorresult['username']; ?>
                  &nbsp;
                  <i class="fa fa-calendar"></i> <?= date("M d, Y", strtotime($postresult['created_at']));; ?>
                </div>
                <p class="post-body"><?= implode(' ', array_slice(explode(' ', strip_tags($postresult['body'])), 0, 50)); ?>...</p>
                <a href="post/<?= $post_title ?>" class="read-more">Read More</a>
              </div>
            </div>
        <?php
          }
        }
        ?>
      </div>
    </div>
  </div>
  <?php require_once("includes/footer.php"); ?>

</body>

</html>