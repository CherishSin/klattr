<?php
include "/data/klattr.com/www/includes/auth";
if ($auth == 1) {
  $cookie_key = $_COOKIE['session_auth'];
  $sql = "DELETE FROM Session WHERE SessionKey='$cookie_key'";
  mysqli_query($con,$sql);
  unset($_COOKIE['session_auth']);
  setcookie("session_auth", "", time()-3600, "", ".klattr.com");

  $sql = "UPDATE Users SET Password_hash='' WHERE ID='$UID'";
  mysqli_query($con,$sql);
  $sql = "UPDATE Users SET Activated='0' WHERE ID='$UID'";
  mysqli_query($con,$sql);
  $sql = "UPDATE Users SET Activation_Key='' WHERE ID='$UID'";
  mysqli_query($con,$sql);

  header( 'Location: https://klattr.com' );
} elseif ($auth == 0) {
  header( 'Location: https://klattr.com' );
}
?>
