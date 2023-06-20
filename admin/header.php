<!-- header -->
  <header class="clearfix">
    <div class="logo">
      <a href="index.php">
        <h1 class="logo-text">PBB</h1>
      </a>
    </div>
    <div class="fa fa-reorder menu-toggle"></div>
    <nav>
      <ul>
        <li><a href="../../index.php">Home</a></li>
        <li>
          <a href="#" class="userinfo">
            <i class="fa fa-user"></i> <?=$_SESSION['username'];?> <i class="fa fa-chevron-down"></i>
          </a>
          <ul class="dropdown">
            <li><a href="../posts/index.php">Dashboard</a></li>
            <li><a href="../logout.php" class="logout">logout</a></li>
          </ul>
        </li>
      </ul>
    </nav>
  </header>
  <!-- // header -->