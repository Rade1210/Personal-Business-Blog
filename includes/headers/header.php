<!DOCTYPE html>
<?php

require_once './includes/config.php';

$imageQuery = mysqli_query($conn, "SELECT profile_image, google_profile_image FROM users WHERE id=" . $_SESSION['user_id']);

?>

<head>
  <link rel="stylesheet" type="text/css" href="<?= $domainUrl;?>/css/style.css">
  <style>
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

  <header class="clearfix">
    <div class="toggler"><i class="fa fa-reorder menu-toggle"></i></div>
    <div class="logo">
      <a href="<?= $domainUrl;?>/">
        <h2 style="text-align:center" class="logo-text">PBB</h2>
      </a>
    </div>
    <nav>
      <ul>
        <li><a href="<?= $domainUrl;?>/">Home</a></li>

        <?php
        if ($_SESSION['user_id'] == "") {
        ?>
        <li><a href="<?= $domainUrl;?>/about.php">About us</a></li>
        <li><a href="<?= $domainUrl;?>/contact.php">Contact us</a></li>
        <li><a href="<?= $domainUrl;?>/register.php">Sign up</a></li>
        <li><a href="<?= $domainUrl;?>/login.php">Login</a></li>

        <?php } ?>

        <?php
        if ($_SESSION['user_id'] != "" && $_SESSION['verified'] == NULL) {
        ?>
        <li><a href="<?= $domainUrl;?>/about.php">About us</a></li>
        <li><a href="<?= $domainUrl;?>/contact.php">Contact us</a></li>
        <li><a href="<?= $domainUrl;?>/register.php">Sign up</a></li>
        <li><a href="<?= $domainUrl;?>/login.php">Login</a></li>
        <?php } ?>

        <?php
        if ($_SESSION['username'] != "" && $_SESSION['verified'] != NULL) {
        ?>
        <li><a href="<?= $domainUrl;?>/about.php">About us</a></li>
        <li><a href="<?= $domainUrl;?>/contact.php">Contact us</a></li>
        <li>
          <a href="#" class="userinfo">

            <?php if ($imageQuery->num_rows > 0) { ?>
            <?php while ($row = $imageQuery->fetch_assoc()) { ?>
            <?php if($row['profile_image'] != null){ ?>
            <a style="margin-bottom:-15px;margin-top:-52px;margin-right:10px;"
              href="<?= $domainUrl;?>/user_profile.php"><img style="border-radius:50%;" width="40px" height="40px"
                src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['profile_image']); ?>" /></a>
            <?php } else if($row['google_profile_image'] != null) {?>
            <a style="margin-bottom:-15px;margin-top:-52px;margin-right:10px;"
              href="<?= $domainUrl;?>/user_profile.php"><img style="border-radius:50%;" width="40px" height="40px"
                src="<?php echo ($row['google_profile_image']); ?>" /></a>
            <?php } else {?>
            <a style="margin-bottom:-15px;margin-top:-52px;margin-right:10px;"
              href="<?= $domainUrl;?>/user_profile.php"><img style="border-radius:40%;" width="40px" height="40px"
                src="https://i.imgur.com/YCBdehQ.png" alt="user placeholder"></a>
            <?php }}} ?>

          </a>
          <ul class="dropdown">
            <?php if ($_SESSION['admin'] == 1) { ?>
            <li><a href="<?= $domainUrl;?>/admin/posts/index.php">Dashboard</a></li>
            <?php } ?>
            <li><a href="<?= $domainUrl;?>/user_profile.php">Profile</a></li>
            <li><a href="<?= $domainUrl;?>/logout.php" class="logout">Logout</a></li>
          </ul>
        </li>
        <?php } ?>
      </ul>
    </nav>
    <div id="searchBar">
      <i id="searchIcon" class="fa fa-search"></i>
      <div class="search-div">
        <form action="search.php" method="get">
          <div class="search">
            <input type="text" name="query" class="text-input" placeholder="Search...">
            <button type="submit"><i class="fa fa-search"></i></button>
          </div>
        </form>
      </div>
    </div>
  </header>

</body>

</html>