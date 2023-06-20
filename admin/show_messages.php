<?php if(isset($_SESSION['success'])): ?>
  <div class="msg success">
  <li><?php echo $_SESSION['success']; ?></li>
  </div>
    <?php unset($_SESSION['success']); ?>
  <?php endif;?>