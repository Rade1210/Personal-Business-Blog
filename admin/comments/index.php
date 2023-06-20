<?php 
require_once("../../includes/config.php"); 
if($_SESSION['admin'] == 1){
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../../css/font-awesome.min.css" />
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="../../css/admin.css">
  <title>Admin - Manage Users</title>
</head>
<body>
  <?php require_once("../header.php"); ?>
  <div class="admin-wrapper clearfix">
    <div class="left-sidebar">
      <ul>
        <li><a href="../posts/index.php">Manage Posts</a></li>
        <li><a href="../topics/index.php">Manage Topics</a></li>
        <li><a href="../users/index.php">Manage Users</a></li>
        <li><a href="../comments/index.php">Manage Comments</a></li>
      </ul>
    </div>
    <div class="admin-content clearfix">
      <div class="button-group">
        <!-- <a href="create.php" class="btn btn-md">Add User</a>
        <a href="index.php" class="btn btn-md">Manage Users</a> -->
      </div>
      <div class="">
              <br>
        <h2 style="text-align: center;">Manage Comments</h2>
        <br>
		<?php if($_SESSION['success'] != "") { ?>
		<div class="msg success">
			<li><?php echo $_SESSION['success']; ?></li>
		</div>
		<?php } unset($_SESSION['success']); ?>
    
        <table id="datatable" class="stripe">
          <thead>
            <th>#</th>
            <th>Username</th>
            <th>Comment</th>
            <th>Status</th>
            <th>Action</th>
          </thead>
          <tbody>
		  <?php
			$userssql = mysqli_query($conn, "SELECT * FROM comments ORDER BY id DESC");
			$userscount = mysqli_num_rows($userssql);
			if($userscount > 0)
			{
				$count = 1;
				while($usersresult = mysqli_fetch_assoc($userssql))
				{ 
          if($usersresult['approved'] == 0){
            $status = 'Pending';
          }else{
            $status = 'Approved';
          }
          ?>
					<tr class="rec">
					  <td><?=$count;?></td>
					  <td><?=$usersresult['name'];?></td>
					  <td><?=$usersresult['content'];?></td>
					  <td><?=$status?></td>
					  <td>
              <?php
                if($usersresult['approved'] == 0){?>
                  <button type="button" class="edit" onclick="approve_comment(this,<?=$usersresult['id']?>)">Approve</button>
                <?php }else{
                }
              ?>
              <button type="button" class="edit delete" onclick="delete_comment(this,<?=$usersresult['id']?>)">Delete</button>
            </td>
					</tr>
				<?php
				$count++;
				} 
			}
			else
			{ ?>
				<tr class="rec">
					<td colspan="4" style="text-align: center;"><b>No comments for approval yet.</b></td>
				</tr>
			<?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <style>
    .edit{
      color: #fff;
      padding: 3px 8px;
      border-radius: 15px;
      cursor: pointer;
      background: #0064d7;
    }
    .delete{
      background: #e22c2cd6;
    }
    .Unapproved {
      background: #373737;
    }
    .Approved {
      background: #019b48;
    }
    #datatable{
      padding-top: 20px;
      padding-bottom: 25px;
      border-bottom: none;
      font-size: 10pt;
    }
    #datatable th {
    font-size: 11pt;
    }
    .row {
      font-size: 11pt;
    }
  </style>
  
   <script type="text/javascript" src="../../js/jquery.min.js"></script>
  <script type="text/javascript" src="../../js/slick.min.js"></script>
  <script type="text/javascript" src="../../js/scripts.js"></script>

  <script>
    function approve_comment(element,comment_id){
      fetch("./approve.php?id=" + comment_id, {
        method: 'GET',
      }).then(response => response.text()).then(data => {
          if(data == 1){
            $(element).parent().prev().html('Approved');
            // $(element).parent().prev().find('.approval').addClass('Approved');
            $(element).css('display','none');
          }else{
            element.innerHTML = 'Approve failed!';
            element.style.background = '#e22c2cd6';
          }
          
      });
    }
    function delete_comment(element,comment_id){
      var content = confirm("Is it okay to delete this comment?"); // The "hello" means to show the following text
      if (content === true) {
        fetch("./delete.php?id=" + comment_id, {
        method: 'GET',
        }).then(response => response.text()).then(data => {
            if(data == 1){
              element.parentElement.parentElement.style.display = 'none';
            }else{
              alert('Delete failed! Please try again');
            }
            
        });
      } else {
      }
      
    }
</script>
</body>
</html>
<?php
}
else{
header("Location:../../404.html");
}?>