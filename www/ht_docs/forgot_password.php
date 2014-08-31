<?php
include "/data/klattr.com/www/includes/auth";
if ($auth == 1) {
  header( 'Location: https://klattr.com' );
} elseif ($auth == 0) {
  if (isset($_POST['eoru'])) {
    $eoru = addslashes($_POST['eoru']);
    $eoru = str_replace(";", "", $eoru);

    include "/data/klattr.com/www/includes/open_db";
    $sql = "SELECT Email_Addr, ID, Name FROM Users WHERE Email_Addr='$eoru' OR Handle='$eoru'";
    $sql_result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($sql_result);
    
    if ($row['Email_Addr'] != "") {
      
      $rname = $row['Name'];
      $uEmailAddr = $row['Email_Addr'];
      $UID = $row['ID'];

      $emailText = file_get_contents("/data/klattr.com/www/includes/password_email_template");
      $emailText = str_replace("FULLNAME", $rname, $emailText);
      $randomData = file_get_contents('/dev/urandom', false, null, 0, 64) . uniqid(mt_rand(), true);
      $randkey = substr(str_replace(array('/','=','+'),'', base64_encode($randomData)),0,64);
      $emailText = str_replace("UNIQUEKEY", $randkey, $emailText);
      $headers = "From: Klattr Team <administrator@klattr.com>\r\nReply-To: No Reply\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
      $sql = "UPDATE Users SET Activation_Key='$randkey' WHERE ID='$UID'";
      mysqli_query($con,$sql);
      mail($uEmailAddr, "Reset Password", $emailText, $headers);

?>
<!DOCTYPE html>
<?php include "/data/klattr.com/www/includes/head"; ?>
  <body>
    <?php include "/data/klattr.com/www/includes/header"; ?>
<div id="body">
  <div class="body_center">
    <div class="welcome" style="padding:10px; top:-70px;">
      Email sent. Please check your email for instructions.
    </div>
  </div>
</div>
    <?php include "/data/klattr.com/www/includes/footer"; ?>
  </body>
</html>
<?php
    }
  } elseif (isset($_GET['key'])) {
    include "/data/klattr.com/www/includes/open_db";
    $recieved_key = addslashes($_GET['key']);
    $recieved_key = str_replace(";", "", $recieved_key);    
    $sql = "SELECT ID, Name, Handle, Activation_Key FROM Users WHERE Activation_Key='$recieved_key'";
    $sql_result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($sql_result);
?>
<!DOCTYPE html>
<?php include "/data/klattr.com/www/includes/head"; ?>
  <body onload="validatePasswordReset(Exists)">
    <script>
      Exists = 0;
    </script>
    <?php include "/data/klattr.com/www/includes/header"; ?>
<div id="body">
  <div class="body_center">
    <div class="welcome" style="padding:10px; top:-70px; height:200px">
      <h1>Reset password for <?php echo $row['Handle']; ?>.</h1>
      <form name="SignUp" method="POST" action="/reset_password.php">
      <div>
      <div class="form_line"><div class="form_text">Password:</div>
      <div class="form_val" id="val_pass"></div>
      <input type="password" class="gen_input" name="password" onkeyup="validatePasswordReset(Exists)" onblur="validatePasswordReset(Exists)"></div>
      <div class="form_line"><div class="form_text">Retype password:</div>
      <div class="form_val" id="val_pass2"></div>
      <input type="password" class="gen_input" name="password2" onkeyup="validatePasswordReset(Exists)" onblur="validatePasswordReset(Exists)"></div>
      </div>
      <div class="form_line">
        <div class="form_val">&nbsp;</div>
        <div id="sub_div"><input type="submit" class="submit_signup" style="width:200px;" value="Reset Password!"></div>
      </div>
      <input type="hidden" name="key" value="<?php echo $recieved_key; ?>">
      </form>
    </div>
  </div>
</div>
    <?php include "/data/klattr.com/www/includes/footer"; ?>
  </body>
</html>
<?php    
  } else {
?>

<!DOCTYPE html>
<?php include "/data/klattr.com/www/includes/head"; ?>
  <body>
    <?php include "/data/klattr.com/www/includes/header"; ?>
<div id="body">
  <div class="body_center">
    <div class="welcome" style="padding:10px; top:-70px;height:150px">
<h1 style="padding:0px;margin:0px;">Retrieve Password.</h1><br> Please enter your eMail address or your username below and we'll send you an eMail with further instructions for resetting your password.<br><br>
<form name="retrieve_form" method="POST" action="/forgot_password.php">
<div class="form_line">
<div class="form_text">Username/eMail Address:</div>
<input type="submit" class="submit_signup" style="width:200px;margin-left:10px;" value="Submit!">
<input type="text" class="gen_input" style="width:300px" name="eoru">

</div></form>
    </div>
  </div>
</div>
    <?php include "/data/klattr.com/www/includes/footer"; ?>
  </body>
</html>
<?php
  }
}
?>
