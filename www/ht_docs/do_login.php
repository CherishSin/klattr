<?php
if (isset($_POST["username"]) && isset($_POST["password"])) {
  $username = $_POST["username"];
  $pass = $_POST["password"];
  $sticky = $_POST["stay_signed_in"];
  $expire_time = 0;
  if ($sticky == "yes") {
    $expire_time = time()+2592000;
  }

  include "/data/klattr.com/www/includes/evaluate_password";
  include "/data/klattr.com/www/includes/open_db";
  $username = evaluate_password($username, $pass);
  if ($username != 1) {
//echo $username;
    $sql = "SELECT ID FROM Users WHERE Handle='$username'";
    $sql_result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($sql_result);
    $UID = $row['ID'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $randomData = file_get_contents('/dev/urandom', false, null, 0, 128) . uniqid(mt_rand(), true);
    $randkey = substr(str_replace(array('/','=','+'),'', base64_encode($randomData)),0,128);

    $session_date = date("Y-m-d h:i:s");
    $sql = "INSERT INTO Session (SessionKey, UserID, IP, Date) VALUES ('$randkey','$UID','$ip','$session_date')";
    mysqli_query($con,$sql);
    setcookie ("session_auth", $randkey, $expire_time, "/", ".klattr.com");

    header( 'Location: https://klattr.com' );


  } else {
    header( 'Location: https://klattr.com?up=' . evaluate_password($username, $pass));
  }
} else {
  header( 'Location: https://klattr.com' );
}
?>
