<?php

    $image = $_FILES['image']['tmp_name'];
    $path = $_FILES['image']['name'];
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $filename = rand().".".$ext;
    $db_file = "uploads/".$filename;
    move_uploaded_file($image, $db_file);
    echo $db_file;

?>