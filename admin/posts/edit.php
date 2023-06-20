<?php

require_once("../../includes/config.php");

session_start();

date_default_timezone_set('Europe/Belgrade');
$date = date('Y-m-d H:i:s');

$postgetsql = mysqli_query($conn, "SELECT * FROM posts WHERE id='" . $_GET['id'] . "'");
$postresults = mysqli_fetch_assoc($postgetsql);

if (isset($_POST['update-post'])) {
  if (empty($_POST['title']))
    $errors[] = "Title is required";
  if (empty($_POST['body']))
    $errors[] = "Body is required";


  /*if(empty($_FILES['postimage']['name']))
        $errors[] = "Post Image is required";*/

  if (count($errors) == 0) {

    $title = mysqli_real_escape_string($conn, $_POST["title"]);
    $meta_description = mysqli_real_escape_string($conn, $_POST["meta_description"]);
    $alt_text = mysqli_real_escape_string($conn, $_POST["alt_text"]);
    $image_url = mysqli_real_escape_string($conn, $_POST["image_url"]);
    $posttitleresults = mysqli_query($conn, "SELECT * FROM posts WHERE title='" . $title . "' and id != '" . $_GET['id'] . "'");
    
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

     
      $body = $_POST["body"];
      $escaped_body = mysqli_real_escape_string($conn, $body);

        $post_id = $_GET["id"];
        mysqli_query($conn, "UPDATE posts SET user_id='" . $_SESSION['user_id'] . "', topic_id='" . $_POST['topic'] . "', title='" . $title . "', image = '" . $image_url . "', body='" . $escaped_body . "', trending='" . $trendingpost . "', published='" . $published . "', alt_text='" . $alt_text . "' , meta_description='" . $meta_description . "', last_updated='" . $date . "' WHERE id = '" . $_GET['id'] . "'");
      } 
     
      $_SESSION['success'] = "Post Updated Successfully.";
      header("Location: edit.php?id=" . $_GET['id']);
      die();
    }
  }

if($_SESSION['admin'] == 1){
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  <link rel="stylesheet" href="../../css/font-awesome.min.css" />
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="../../css/admin.css">
  <title>Admin - Edit Post</title>
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
        <a href="create.php" class="btn btn-sm">Add Post</a>
        <a href="index.php" class="btn btn-sm">Manage Posts</a>
        <a href="drafts.php" class="btn btn-sm">Manage Drafts</a>
      </div>
      <div class="">
        <h2 style="text-align: center;">Edit Post</h2>
        <?php
        require_once("../print_errors.php");
        ?>
        <?php if ($_SESSION['success'] != "") { ?>
          <div class="msg success">
            <li><?php echo $_SESSION['success']; ?></li>
          </div>
        <?php }
        unset($_SESSION['success']); ?>
        <form action="edit.php?id=<?= $_GET['id']; ?>" method="post" enctype="multipart/form-data">
          <div class="input-group">
            <label>Title</label>
            <input type="text" name="title" class="text-input" value="<?= $postresults['title']; ?>">
          </div>
          <div class="input-group">
            <label>Body</label>
            <div id="editor">

            </div>
            <div style="display: none" id="content"><?php echo $postresults["body"]; ?></div>
            <input type="hidden" value="" name="body" id="post-body">
          </div>
          
            <div class="input-group">
              <label>ImageURL</label>
              <input type="text" name="image_url" class="text-input" value="<?php echo $postresults['image']?>">
            </div>  
          
          <div class="input-group">
            <label>Topic</label>
            <select class="text-input" name="topic" id="topic">
              <?php
              $topicssql = mysqli_query($conn, "SELECT * FROM topics");
              while ($topicsresult = mysqli_fetch_assoc($topicssql)) { ?>
                <option value="<?= $topicsresult['id']; ?>"><?= $topicsresult['name']; ?></option>
              <?php } ?>
            </select>
            <script>
              document.getElementById("topic").value = '<?= $postresults["topic_id"] ?>';
            </script>
          </div>
          
          <div class="input-group">
            <label>
              <?php if ($postresults['published'] != "0") { ?>
                <input type="checkbox" name="publish" checked="checked" /> Publish
              <?php } else { ?>
                <input type="checkbox" name="publish" /> Publish
              <?php } ?>
            </label>
          </div>
          <div class="input-group">
            <label>
              <?php if ($postresults['trending'] != "0") { ?>
                <input type="checkbox" name="trending" checked="checked" /> Trending Post
              <?php } else { ?>
                <input type="checkbox" name="trending" /> Trending Post
              <?php } ?>
            </label>
          </div>

          <div class="input-group">
            <label>Image Alt Text</label>
            <input type="text" name="alt_text" class="text-input" value="<?= $postresults['alt_text'] ?>">
          </div>

          <div class="input-group">
            <label>Meta Description (155-160 characters)</label>
            <textarea name="meta_description" class="text-input" rows="4"><?= $postresults['meta_description'] ?></textarea>
          </div>

          <div class="input-group">
            <button type="submit" name="update-post" class="btn">Update Post</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript" src="../../js/jquery.min.js"></script>
  <script src="../../js/summernote-lite.min.js"></script>
  <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
  <!-- <script type="text/javascript" src="../../js/ckeditor.js"></script> -->
  <script type="text/javascript" src="../../js/scripts.js"></script>
  <script type="text/javascript" src="../../js/editor.js"></script>
</body>
</html>
<?php
}
else{
header("Location:../../404.html");
}
?>