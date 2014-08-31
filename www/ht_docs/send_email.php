<?php
if ($first_mail !== 1) {
  $activatePage = 1;
  include "/data/klattr.com/www/includes/auth";
}

if ($auth == 1 || $first_mail == 1 ) {
  $emailText = file_get_contents("/data/klattr.com/www/includes/email_template");
  $emailText = str_replace("FULLNAME", $rname, $emailText);
  $randomData = file_get_contents('/dev/urandom', false, null, 0, 64) . uniqid(mt_rand(), true);
  $randkey = substr(str_replace(array('/','=','+'),'', base64_encode($randomData)),0,64);
  $emailText = str_replace("UNIQUEKEY", $randkey, $emailText);
  $headers = "From: Klattr Team <administrator@klattr.com>\r\nReply-To: No Reply\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
  $sql = "UPDATE Users SET Activation_Key='$randkey' WHERE ID='$UID'";
  mysqli_query($con,$sql);
  mail($uEmailAddr, "Welcome to Klattr", $emailText, $headers);
//  shell_exec("echo $emailText | mail -s \"Welcome to Klattr\" -r administrator@klattr.com $uEmailAddr");
  
} else {
  header( 'Location: https://klattr.com' );
}
?>
