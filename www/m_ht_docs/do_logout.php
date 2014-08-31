<?php

if (isset($_COOKIE['session_auth'])) {
  include "/data/klattr.com/www/includes/open_db";
  $cookie_key = $_COOKIE['session_auth'];
  $sql = "DELETE FROM Session WHERE SessionKey='$cookie_key'";
  mysqli_query($con,$sql);
  unset($_COOKIE['session_auth']);
  setcookie("session_auth", "", time()-3600, "", ".klattr.com");
  header( 'Location: https://klattr.com' );
} else {
  header( 'Location: https://klattr.com' );
}


?>
