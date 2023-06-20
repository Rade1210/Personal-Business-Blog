<?php
ini_set('display_errors',1);
require_once("includes/config.php");

$page_description = "Personal Business Blog is a business blog focusing on business, entrepreneurship, self-help, technology, and entertainment.";

if ($_SESSION['verified'] === '0000-00-00 00:00:00') {
  session_unset();
  session_destroy();
}

?>
<!DOCTYPE html>
<html lang="en-US">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="<?= $page_description ?>">
  <meta name="og:image" property="og:image" content="<?=  $domainUrl;?>/logo/personal-business-blog-logo-complex.png" />
  <meta name="og:description" property="og:descripttion" content="<?= $page_description ?>" />
  <meta name="theme-color" content="#ffffff">
  <meta name="og:title" property="og:title" content="Personal Business Blog | Resources to Help Your Business Grow" />
  <meta name="twitter:card" property="twitter:card" content="summary" />
  <meta name="twitter:title" property="twitter:title" content="Personal Business Blog | Resources to Help Your Business Grow" />
  <meta name="twitter:description" property="twitter:description" content="<?= $page_description ?>" />
  <meta name="twitter:image" property="twitter:image"
    content="<?=  $domainUrl;?>/logo/Personal-Business-Blog-Logo-Twitter-Profile.png" />
  <meta property="og:image:width" content="200" />
  <meta name="author" content="<?php echo $usernameresult['username']?>">
  <meta property="og:image:height" content="200" />
  <link rel="stylesheet" href="<?=  $domainUrl;?>/css/style.css?<?= time() ?>" media="all" disabled>
<meta name="google-site-verification" content="sjqg7DN2C7MQk0w8qwpzcIDdCgFBSVHd0ZYE4gYDSG8" />
  <title>Personal Business Blog</title>
  <style>
  @media screen and (max-width: 790px) {

    .paginator {
      margin-bottom: 30px;
      width: max-content;
      text-align: center;
    }

    .first-link,
    .paginator-links {
      padding: 8px;
    }

  }
  </style>
  <meta name="google-site-verification" content="1XiHPI9a1adclZCsK59J0zNZomEYKJ_KPzvoiV31X5s" />
</head>

<body>
  <?php require_once("includes/headers/header.php"); ?>
  <div class="page-wrapper">

    <div class="posts-slider">
      <h1 class="slider-title">Personal Business Blog</h1>
      <div class="posts-wrapper">
        <div class="owl-carousel owl-theme">

          <?php
          
          $topic_name = $_GET['topicid'];
          $stripped_topic = str_replace("-", " ", $topic_name);
          $startPosition= $_GET['start'];
          
          $postsNewQuery="select *  from posts as p ";
          $whereclause = "WHERE published='1' ";
          $trendingClause =  " WHERE published='1' and trending='1' ";
          $orderby ="order by p.id desc ";
          $post_per_page = 7;
          $start = $startPosition!='' ? ($startPosition-1)*$post_per_page:0;
          $limitClause = "limit $start,$post_per_page";
          
          if($stripped_topic!=='') {
            $postsNewQuery.= "inner join topics as t on p.topic_id=t.id where t.name='$stripped_topic' and published='1' ";
            $trendingPostQuery.= $postsNewQuery."and trending='1'";
           
          } else {
            $trendingPostQuery = $postsNewQuery.$trendingClause;
            $postsNewQuery.= $whereclause;
          }
        
          $trendingPostQuery.=$orderby;
          $totalPagesQuery = $postsNewQuery;
          $postsNewQuery.= $orderby.$limitClause;
          $trendingPostQuery = mysqli_query($conn, $trendingPostQuery);
          $postscount = mysqli_num_rows($trendingPostQuery);
          if ($postscount == 0) {
          ?>
          <div style="width: 100%; text-align: center"></div>
          <?php
          }
          
          if ($postscount > 0) {
            while ($postresult = mysqli_fetch_assoc($trendingPostQuery)) {
            $authorsql = mysqli_query($conn, "SELECT * FROM users WHERE id='" . $postresult['user_id'] . "'");
            $authorresult = mysqli_fetch_assoc($authorsql);
            
            $topicsql = mysqli_query($conn, "SELECT name FROM topics join posts ON topics.id = posts.topic_id WHERE posts.id = '" . $postresult['id'] . "' and posts.published='1'");
            $topicresult = mysqli_fetch_assoc($topicsql);
            $topicresult = str_replace(" ", "-", $topicresult);
            
            $post_title = str_replace(" ", "-", $postresult['title']);
            $post_title = strtolower($post_title);
            $encodedTitle = urlencode($post_title);

            ?>
          <div class="post item">
            <div class="inner-post">
             <a href="<?=  $domainUrl;?>/post/<?= $encodedTitle ?>"> <img src="<?= $postresult['image']; ?>"alt="<?= $postresult['alt_text']; ?>" style="width: 100%; border-top-left-radius: 5px; border-top-right-radius: 5px;"></a>
              <div class="post-info">
                <h3><a href="<?=  $domainUrl;?>/post/<?= urlencode($post_title) ?>"><?= $postresult['title']; ?></a>
                </h3>
               <a href="https://personalbusinessblog.com/topics/<?php echo strtolower($topicresult['name'])?>"><p style="text-align:center"><?php echo $topicresult['name']?></p></a>
              </div>
            </div>
          </div>
          <?php
            }
          }
          ?>
        </div>
      </div>
    </div>
    <div class="content clearfix">
      <div class="page-content" style="float: left;">
        <span class="recent-posts-title">Recent Posts</span>

        <div style="display: none" id="page_id"><?php echo isset($_GET["start"]) ? $_GET["start"] : 1 ?></div>
        <?php
        
        /* if (isset($_GET['topicid']) && $_GET['topicid'] != "" && $_GET['start'] == null) {
          $postsql = mysqli_query($conn, "SELECT * FROM posts WHERE topic_id='" . $topic_id . "' and published='1' order by id desc LIMIT 6");
        } elseif (isset($_GET['start']) && $_GET['start'] != "" && $_GET['topicid'] == null) {
          $start_id = $_GET['start'];
          $real_index = $start_id - 1;
          $startpos = $real_index * 6;
          $postsql = mysqli_query($conn, "SELECT * FROM posts WHERE published='1' ORDER BY id DESC LIMIT " . $startpos . ", 6");
        } elseif (isset($_GET['start']) && $_GET['start'] != "" && $_GET['topicid'] != null) {
          $start_id = $_GET['start'];
          $real_index = $start_id - 1;
          $startpos = $real_index * 6;
          $postsql = mysqli_query($conn, "SELECT * FROM posts WHERE published='1' AND topic_id = '$topic_id' ORDER BY id DESC LIMIT " . $startpos . ", 6");
        } else {
          $postsql = mysqli_query($conn, "SELECT * FROM posts WHERE published='1' order by id desc LIMIT 6");
        } */
        $totalPages =  mysqli_query($conn, $totalPagesQuery);
        $postsNewQuery = mysqli_query($conn, $postsNewQuery);
        $postscount = mysqli_num_rows($postsNewQuery);
        $totalPages = mysqli_num_rows($totalPages);
        $totalPosts = $totalPages;
        $total_pages = ceil($totalPages / $post_per_page); 

        if ($postscount == 0) {
        ?>
        <div style="width: 100%; text-align: center; margin-top: 25px;"></div>
        <?php
        }

        if ($postscount > 0) {
          while ($postresult = mysqli_fetch_assoc($postsNewQuery)) {
            $authorsql = mysqli_query($conn, "SELECT * FROM users WHERE id='" . $postresult['user_id'] . "'");
            $authorresult = mysqli_fetch_assoc($authorsql);
           
            $post_title = str_replace(" ", "-", $postresult['title']);
            $post_title = strtolower($post_title);
            
            $topicsql = mysqli_query($conn, "SELECT name FROM topics join posts ON topics.id = posts.topic_id WHERE posts.id = '" . $postresult['id'] . "' and posts.published='1'");
            $topicresult = mysqli_fetch_assoc($topicsql);
            $topicresult = str_replace(" ", "-", $topicresult);
            
          ?>
        <div class="post clearfix">
          <a href="<?=  $domainUrl;?>/post/<?= urlencode($post_title) ?>"><img src="<?= $postresult['image']; ?>" class="post-image" alt="<?= $postresult["alt_text"]; ?>"></a>
          <div class="post-content">
            <h2 class="post-title"><a href="<?=  $domainUrl;?>/post/<?= urlencode($post_title) ?>"><?= $postresult['title']; ?></a>
            </h2>
            <div class="post-info">
            <a href="https://personalbusinessblog.com/topics/<?php echo strtolower($topicresult['name'])?>"><?php echo $topicresult['name']?></a>
              &nbsp;
            </div>
            <p class="post-body"><?= implode(' ', array_slice(explode(' ', strip_tags($postresult['body'])), 0, 30)); ?>
              ...</p>
            <a style="border-radius: 5px;padding: 11px 15px;position:static"
              href="<?=  $domainUrl;?>/post/<?= urlencode($post_title) ?>" class="read-more">Read
              More</a>
          </div>
        </div>
        <?php
          }
        }
        ?>
      </div>
      <div class="sidebar">
        <div class="section topics">
          <h2>Topics</h2>
          <?php
          $topicsql = mysqli_query($conn, "SELECT * FROM topics");
          $topicsqlcount = mysqli_num_rows($topicsql);
          if ($topicsqlcount > 0) {
            echo "<ul>";
            while ($topicresult = mysqli_fetch_assoc($topicsql)) {
              $topicresult = str_replace(" ", "-", $topicresult);
              $link = "$domainUrl/topics/" . strtolower($topicresult['name']);
          ?>
          <a href="<?= $link; ?>">
            <li><?= $topicresult['name']; ?></li>
          </a>
          <?php
            }
            echo "</ul>";
          }
          ?>
        </div>
      </div>
      <div style="justify-content:center;margin-bottom:40px;" class="paginator">
        <?php include "includes/paginator.php"; ?>
      </div>
    </div>
  </div>
  <?php require_once("includes/footers/footer.php"); ?>
 

  <script>
  $(document).ready(function() {

    $('.owl-carousel').owlCarousel({
      loop: true,
      margin: 10,
      nav: true,
      autoplay: true,
      autoplayTimeout: 4000,
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 2
        },
        1000: {
          items: 3
        },
        1500: {
          items: 4
        }
      }
    });
  })

  var page_id = document.getElementById("page_id").innerHTML;
  var index = parseInt(page_id) - 1;
  var links = document.getElementsByClassName("paginator-number");
  links[index].classList.add("activated");

  /*
      (function() {
          var css = document.createElement('link');
          css.href = '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css';
          css.rel = 'stylesheet';
          css.property = 'stylesheet';
          css.type = 'text/css';
           var head =  document.getElementsByTagName('head')[0];
         head.insertBefore(css, head.firstChild);

      })();*/

  /*  (function() {
        var css2 = document.createElement('link');
        css2.href = '//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css';
        css2.rel = 'stylesheet';
        css2.property = 'stylesheet';
        css2.integrity = "sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==";
        css2.crossOrigin = "anonymous";
        var head2 =  document.getElementsByTagName('head')[0];
        head2.appendChild(css2, head.firstChild);

    })();*/
  </script>
  
  <script>
        
        function readingTime() {
        
        const text = document.querySelector(".article-body").innerText;
        const wpm = 250;
        const words = text.trim().split(/\s+/).length;
        const time = Math.ceil(words / wpm);
        document.querySelector(".display-reading-time").innerText = time + " min";
            
        }
        
        readingTime();
      
  </script>
  
  <script>
  window.dataLayer = window.dataLayer || [];

  function gtag() {
    dataLayer.push(arguments);
  }
  gtag('js', new Date());

  gtag('config', 'UA-135119183-6');
  </script>

  <script src="https://kit.fontawesome.com/ee654fe705.js" crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
</body>

</html>