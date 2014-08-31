<?php
include "/data/klattr.com/www/includes/auth";

if ($auth == 1) {
//  echo print_r($_FILES);
//  echo $_FILES['file']['tmp_name'];

  $senduname = $_POST["senduname"];
  $type = $_FILES['file']['type'];
  $type = substr($type, 0, 5);
  if ($_FILES['file']['tmp_name'] != "" && $type === "image") {
    $image = new Imagick($_FILES['file']['tmp_name']);
    $image->resizeImage(150,150, imagick::FILTER_LANCZOS, 0.9, false);
    $image->setImageFormat('jpeg');
    $image = addslashes($image);
    $sql = "UPDATE Users SET Avatar='$image' WHERE ID='$UID'";
    mysqli_query($con,$sql);
  }
  header( "Location: https://klattr.com/$senduname" );

//  header('Content-type: image/jpeg');
//  echo $image;

} else {
  header( 'Location: https://klattr.com' );
}

?>
