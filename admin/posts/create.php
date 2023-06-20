<?php
require_once("../../includes/config.php");
session_start();

date_default_timezone_set('Europe/Belgrade');
$date = date('Y-m-d H:i:s');

if (isset($_POST['save-post'])) {
  if (empty($_POST['title']))
    $errors[] = "Title is required";
  if (empty($_POST['body']))
    $errors[] = "Body is required";
  if (count($errors) == 0) {
    $poststitlesql = "SELECT * FROM posts WHERE title='" . $_POST['title'] . "'";
    $posttitleresults = mysqli_query($conn, $poststitlesql);

    if (mysqli_num_rows($posttitleresults) > 0)
      $errors[] = "Post Title already exists.";

    else {
      if ($_POST['publish'] != "") {
        $published = 1;
      } else {
        $published = 0;
      }
      if ($_POST['trending'] != "") {
        $trendingpost = 1;
      } else {
        $trendingpost = 0;
      }

      $body = mysqli_real_escape_string($conn, $_POST["body"]);
      $title = mysqli_real_escape_string($conn, $_POST["title"]);
      $alt_text = mysqli_real_escape_string($conn, $_POST["alt_text"]);
      $image_url = mysqli_real_escape_string($conn, $_POST["image_url"]);
      $meta_description = mysqli_real_escape_string($conn, $_POST["meta_description"]);

      mysqli_query($conn, "INSERT INTO posts (`user_id`, `topic_id`,  `title`, `image`, `body`, `trending`, `published`, `alt_text`, `meta_description`, `last_updated`) VALUES ('" . $_SESSION['user_id'] . "','" . $_POST['topic'] . "', '" . $title . "', '" .$image_url. "', '" . $body . "', '" . $trendingpost . "', '" . $published . "','" . $alt_text . "', '" . $meta_description . "', '" . $date . "')");
      $p_id = mysqli_insert_id($conn);
      $_SESSION['success'] = "Post Created Successfully.";
    }
  }
}
if ($_SESSION['admin'] == 1) {
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../css/font-awesome.min.css" />
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Admin - Create Post</title>
  </head>

  <body>
    <?php require_once("../header.php"); ?>
    <div class="admin-wrapper clearfix">
      <div class="left-sidebar">
        <ul>
          <li><a href="index.php">Manage Posts</a></li>
          <li><a href="../topics/index.php">Manage Topics</a></li>
          <li><a href="../users/index.php">Manage Users</a></li>
        </ul>
      </div>
      <div class="admin-content clearfix">
        <div class="button-group">
          <a href="create.php" class="btn btn-md">Add Post</a>
          <a href="index.php" class="btn btn-md">Manage Posts</a>
          <a href="drafts.php" class="btn btn-md">Manage Drafts</a>
        </div>
        <div class="">
            <br>
          <h2 style="text-align: center;">Create Post</h2>
          <?php
          require_once("../print_errors.php");
          require_once("../show_messages.php");
          ?>
          <form action="create.php" method="post" enctype="multipart/form-data">
            <div class="input-group">
              <label>Title</label>
              <input type="text" name="title" class="text-input">
            </div>
            <div class="input-group">
              <label>Body</label>
              <div id="editor">

              </div>
              <div style="display: none" id="content"></div>
              <input type="hidden" value="" name="body" id="post-body">
            </div>
            <div class="input-group">
              <label>Topic</label>
              <select class="text-input" name="topic">
                <?php
                $topicssql = mysqli_query($conn, "SELECT * FROM topics");
                while ($topicsresult = mysqli_fetch_assoc($topicssql)) { ?>
                  <option value="<?= $topicsresult['id']; ?>"><?= $topicsresult['name']; ?></option>
                <?php } ?>
              </select>
            </div>
           
            <div class="input-group">
              <label>ImageURL</label>
              <input type="text" name="image_url" class="text-input">
            </div>  

            <div class="input-group">
              <label>
                <input type="checkbox" name="publish" /> Publish
              </label>
            </div>
            <div class="input-group">
              <label>
                <input type="checkbox" name="trending" /> Trending Post
              </label>
            </div>

            <div class="input-group">
              <label>Image Alt Text</label>
              <input type="text" name="alt_text" class="text-input">
            </div>

            <div class="input-group">
              <label>Meta Description (155-160 characters)</label>
              <textarea name="meta_description" class="text-input" rows="4"></textarea>
            </div>

            <div class="input-group">
              <button type="submit" name="save-post" class="btn" id="save-post">Save Post</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script type="text/javascript" src="../../js/jquery.min.js"></script>
    <!-- <script type="text/javascript" src="../../js/ckeditor.js"></script> -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script type="text/javascript" src="../../js/scripts.js"></script>
    <script type="text/javascript" src="../../js/editor.js"></script>

  </body>

  </html>
<?php
} else {
  header("Location:../../404.html");
}
?>