<?php 
include "/data/klattr.com/www/includes/auth";
if ($auth == 1) {
  $jpeg_name = $_GET["jpeg"];
  $jpeg_name = substr($jpeg_name, 1, -5);
  $sql = "SELECT Avatar FROM Users WHERE Handle='$jpeg_name' AND BINARY(Handle) = BINARY('$jpeg_name')";
  $sql_result = mysqli_query($con,$sql);
  $row = mysqli_fetch_array($sql_result);
  if ($row['Avatar'] != "") {
    header('Content-type: image/jpeg');
    echo $row['Avatar'];
  } else {
    $img = file_get_contents('/data/klattr.com/www/ht_docs/gfx/default_user.png');
    header('Content-type: image/png');
    echo $img;
  }
} else {
  header( 'Location: https://klattr.com' );
}
?>
