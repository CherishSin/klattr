<?php
include "/data/klattr.com/www/includes/auth";
include "/data/klattr.com/www/includes/evaluate_signup";
if ($auth == 1) {
  if (isset($_POST['password']) && isset($_POST['password2'])) {
    if (evaluate_pass($_POST['password']) == 0) {
      if ($_POST['password'] == $_POST['password2']) {
        $password = $_POST["password"];
        $enc_password = urlencode($password);
        $password_hash = crypt($enc_password);

        $sql = "UPDATE Users SET Password_hash='$password_hash' WHERE ID='$UID'";
        mysqli_query($con,$sql);

        $randomData = file_get_contents('/dev/urandom', false, null, 0, 128) . uniqid(mt_rand(), true);
        $randkey = substr(str_replace(array('/','=','+'),'', base64_encode($randomData)),0,128);
        $ip = $_SERVER['REMOTE_ADDR'];
        $session_date = date("Y-m-d h:i:s");
        $sql = "INSERT INTO Session (SessionKey, UserID, IP, Date) VALUES ('$randkey','$UID','$ip','$session_date')";
        mysqli_query($con,$sql);
        echo "Password Reset";
      } else {
        echo "Your Passwords don't match!";
      }
    } else {
      echo "Your password isn't long enough!";
    }
  }
} elseif ($auth == 0) {
//echo $_POST['key'];
  if (isset($_POST['key']) && isset($_POST['password']) && isset($_POST['password2'])){
    if ($_POST['password'] == $_POST['password2']) {
      $password = $_POST["password"];
      $key = addslashes($_POST['key']);
      $key = str_replace(";", "", $key);
//echo $key;
      include "/data/klattr.com/www/includes/open_db";
      $enc_password = urlencode($password);
      $password_hash = crypt($enc_password);

      $sql = "SELECT ID FROM Users WHERE Activation_Key='$key'";
      $sql_result = mysqli_query($con,$sql);
      $row = mysqli_fetch_array($sql_result);
//echo $row['ID'];
      if (isset($row['ID'])) {
        $UID = $row['ID'];
//echo $UID;
        $sql = "UPDATE Users SET Password_hash='$password_hash' WHERE ID='$UID'";
        mysqli_query($con,$sql);

        $randomData = file_get_contents('/dev/urandom', false, null, 0, 128) . uniqid(mt_rand(), true);
        $randkey = substr(str_replace(array('/','=','+'),'', base64_encode($randomData)),0,128);
        $ip = $_SERVER['REMOTE_ADDR'];
        $session_date = date("Y-m-d h:i:s");
        $sql = "INSERT INTO Session (SessionKey, UserID, IP, Date) VALUES ('$randkey','$UID','$ip','$session_date')";
        mysqli_query($con,$sql);
        setcookie ("session_auth", $randkey, $expire_time, "/", ".klattr.com");
        header( 'Location: https://klattr.com' );

      } else {
        header( 'Location: https://klattr.com' );
      }
    } else {
      header( 'Location: https://klattr.com' );
    }
  } else {
    header( 'Location: https://klattr.com' );
  }
}
?>
