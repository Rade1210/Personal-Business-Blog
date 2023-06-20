<?php 
require_once("includes/config.php");

$postresult = [];
if(isset($_GET['id']) && $_GET['id'] != "") {
  $postsql = mysqli_query($conn, "SELECT * FROM posts WHERE id='".$_GET['id']."' and published='1'");
  if(mysqli_num_rows($postsql)){
    while($row = mysqli_fetch_assoc($postsql)){
      $postresult = $row;
    }
  }
}

$usernameresult = [];
if(isset($_GET['id']) && $_GET['id'] != "") {
  $usernamesql = mysqli_query($conn, "SELECT username FROM users JOIN posts ON users.id = posts.user_id WHERE posts.id='".$_GET['id']."' and posts.published='1'");
  if(mysqli_num_rows($usernamesql)){
    while($row2 = mysqli_fetch_assoc($usernamesql)){
      $usernameresult = $row2;
    }
  }
}

$topicsresult = [];
if(isset($_GET['id']) && $_GET['id'] != "") {
  $topicsql = mysqli_query($conn, "SELECT name FROM topics join posts ON topics.id = posts.topic_id WHERE posts.id = '".$_GET['id']."' and posts.published='1'");
  if(mysqli_num_rows($topicsql)){
    while($row3 = mysqli_fetch_assoc($topicsql)){
      $topicsresult = $row3;
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
  <link rel="stylesheet" href="<?= $domainUrl;?>css/font-awesome.min.css" />
  <link rel="stylesheet" href="<?= $domainUrl;?>css/style.css">
  <meta name="description" content="<?=$postresult['meta_description']?>">
  <meta name="author" content="<?php echo $usernameresult['username']?>">
  <title>Personal Business Blog</title>
  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-135119183-6"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-135119183-6');
</script>

<script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "6iqp7jf93f");
</script>

  <style>
  
    .footer .footer-content .quick-links a{
        text-decoration:none;
    }
    
   @media only screen and(max-width: 560px) {
  .content .page-content.single{
      width:30% !important;
  }
 
  nav ul {
    margin-right: 30px !important;
  }

  #searchBar {
    position: absolute;
    right: 12px;
    top: 23px;
    cursor: pointer;
  }

  .search-div {
    position: absolute;
    right: 0;
    top: 46px;
    width: 300px;
    z-index: 9999;
    display: none;
  }

  header {
    background: #060606;
    color: #fff;
  }
  
</style>
</head>
<body>
     <?php require_once("includes/header.php"); ?>
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
 
  <div class="page-wrapper">
    <div class="content clearfix">
      <div class="page-content single">
         
		<?php
			if(!empty($postresult)){
				?>
				 <span>Category:<?php echo $topicsresult['name']?></span>
        <h2 style="text-align: center;"><?=$postresult['title'];?></h2>
        <br>
        <?=$postresult['body'];?>
        <?php
			}
		?>
      </div>
    </div>
  </div>
  <script src="<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>"></script>
  <script src="js/slick.min.js"></script>
</body>
</html>