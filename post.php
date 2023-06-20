<?php

$page_dir = '../';

require_once("includes/config.php");

$postresult = [];

if (isset($_GET['title']) && $_GET['title'] != "") {

  $title = $_GET["title"];

  $post_title = str_replace("-", " ", $title);

  $postsql = mysqli_query($conn, "SELECT * FROM posts WHERE title='" . $post_title . "' and published='1'");

  if (mysqli_num_rows($postsql)) {

    while ($row = mysqli_fetch_assoc($postsql)) {

      $postresult = $row;

    }

  }

}

$usernameresult = [];
  $usernamesql = mysqli_query($conn, "SELECT username FROM users JOIN posts ON users.id = posts.user_id WHERE posts.title='" . $postresult['title'] . "' and posts.published='1'");
  if (mysqli_num_rows($usernamesql)) {
    while ($row2 = mysqli_fetch_assoc($usernamesql)) {
      $usernameresult = $row2;
  }
}

$topicsresult = [];
  $topicsql = mysqli_query($conn, "SELECT name FROM topics join posts ON topics.id = posts.topic_id WHERE posts.title = '" . $postresult['title'] . "' and posts.published='1'");
  if (mysqli_num_rows($topicsql)) {
    while ($row3 = mysqli_fetch_assoc($topicsql)) {
      $topicsresult = $row3;
  }
}

if($post_title != strtolower($postresult['title'])){
    header("Location: https://personalbusinessblog.com/404.html");
}

?>

<!DOCTYPE html>

<html lang="en">


<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <link rel="stylesheet" href="../css/font-awesome.min.css" />
  
  <meta name="author" content="<?php echo $usernameresult['username'] ?>">
  
  <link rel="stylesheet" href="<?= $domainUrl;?>/css/style.css">

  <link rel="stylesheet" href="../css/comments.css">
  
  <link rel="canonical" href="<?= $domainUrl;?>/post/<?= $title?>">

  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

  <meta name="description" content="<?= $postresult['meta_description'] ?>">

  <meta name="og:image" property="og:image"
    content="<?= $domainUrl;?>/admin/posts/post_images/<?= $postresult['image']; ?>" />

  <meta name="og:type" property="og:type" content="article" />

  <meta name="og:description" property="og:description" content="<?= $postresult['meta_description'] ?>" />

  <meta name="og:title" property="og:title" content="<?= $postresult['title'] ?> | PersonalBusinessBlog.com" />

  <meta name="twitter:card" property="twitter:card" content="summary" />

  <meta name="twitter:title" property="twitter:title"
    content="<?= $postresult['title'] ?> | PersonalBusinessBlog.com" />

  <meta name="twitter:description" property="twitter:description" content="<?= $postresult['meta_description'] ?>" />

  <meta name="twitter:image" property="twitter:image"
    content="<?= $domainUrl;?>/admin/posts/post_images/<?= $postresult['image']; ?>" />

  <meta property="og:image:width" content="1200" />

  <meta property="og:image:height" content="625" />

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
  
  span::selection{
      color:white;
      background-color:black;
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
          $post_id = $postresult['id'];

        ?>
        
        <p style="font-style:italic;margin-top:-20px;">category: <a style="text-decoration:underline;" href="https://personalbusinessblog.com/topics/<?php echo strtolower($topicsresult['name']) ?>"><?php echo strtolower($topicsresult['name']) ?></a>, last updated: <?php echo $postresult['last_updated']?>, average reading time: <span style="font-style:italic" class="display-reading-time"></span></p>
        
        <span style="margin-top:-31px;margin-left:-40px;">Author: </span><span style="text-decoration:underline" class="show-modal"><?= $usernameresult['username']?></span>
        
      <div class="modal hidden">
            <div style="height:70%;margin-top:20px;" class="modal-author-container">
      <img class="modal-author-picture" style="width:40%" src="https://pullzone1pbb.b-cdn.net/rade-petrovic.webp">
        <div style="margin-left:40px;margin-top:-40px;" class="modal-author-text">
      <h1>Rade Petrovic</h1>
      <span style="margin-left:-30px;">Tech and Business writer</span>
      <p style="margin-top:-10px;">Rade Petrovic is a tech and business writer from Serbia. His work is based on the business startup niche, but he also writes and maintains a Personal Business Blog. Rade has a bachelor’s degree in Information Technology from the University of Kragujevac. </p>
        </div>
      <button class="close-modal">&times;</button>
      </div>
  
    </div>
     
    <div class="overlay hidden"></div>
   
        <h1 style="text-align: center; font-size: 1.75em"><?= $postresult['title']; ?></h1>

        <div style="margin-top:-50px;" class="article-body">
          <?= $postresult['body']; ?>
        </div>
        
        <?php

        }

        ?>
        
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

        <div class="comments"></div>
      </div>

      <script>
      const comments_page_id = <?= $post_id ?>; // This number should be unique on every page
      fetch("../comments.php?post_id=" + comments_page_id).then(response => response.text()).then(data => {
        document.querySelector(".comments").innerHTML = data;
        document.querySelectorAll(".comments .write_comment").forEach((element, index) => {
          if (index == 0) {
            element.style.display = 'block';
          }
        });
        document.querySelectorAll(".comments .write_comment_button, .comments .reply_comment_btn").forEach(
          element => {
            element.onclick = event => {
              event.preventDefault();
              document.querySelectorAll(".comments .write_comment").forEach(element => element.style.display =
                'none');
              document.querySelector("div[data-comment-id='" + element.getAttribute("data-comment-id") + "']")
                .style.display = 'block';
              document.querySelector("div[data-comment-id='" + element.getAttribute("data-comment-id") +
                "'] input[name='name']").focus();
            };
          });
        document.querySelectorAll(".comments .write_comment form").forEach(element => {
          element.onsubmit = event => {
            event.preventDefault();
            fetch("../comments.php?post_id=" + comments_page_id, {
              method: 'POST',
              body: new FormData(element)
            }).then(response => response.text()).then(data => {
              element.parentElement.innerHTML = data;
            });
          };
        });
      });
      </script>

    </div>
    
    <script>
  
const modal = document.querySelector('.modal');
const overlay = document.querySelector('.overlay');
const btnCloseModal = document.querySelector('.close-modal');
const btnsOpenModal = document.querySelectorAll('.show-modal');

const openModal = function () {
  modal.classList.remove('hidden');
  overlay.classList.remove('hidden');
};

for (let i = 0; i < btnsOpenModal.length; i++) {
  btnsOpenModal[i].addEventListener('click', openModal);
}

const closeModal = function () {
  modal.classList.add('hidden');
  overlay.classList.add('hidden');
};

btnCloseModal.addEventListener('click', closeModal); // No ()
overlay.addEventListener('click', closeModal);

document.addEventListener('keydown', function (e) {
  if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
    closeModal();
  }
});


  
  </script>

  </div>

  <?php require_once("includes/footer.php"); ?>

  <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
  <script src="js/calculateReadingTime.js"></script>

</body>

</html>

?>




