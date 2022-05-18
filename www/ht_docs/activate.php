<?php
$activatePage = 1;
include "/data/klattr.com/www/includes/auth";
if ($auth == 1) {
  if (isset($_GET['key'])) {
    $sql = "SELECT Activation_Key FROM Users WHERE ID='$UID'";
    $sql_result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($sql_result);

    if ($_GET['key'] === $row['Activation_Key']) {
      $sql = "UPDATE Users SET Activated='1' WHERE ID='$UID'";
      mysqli_query($con,$sql);
      header( 'Location: https://klattr.com' );
    } else {
      header( 'Location: https://klattr.com' );
    }

  } else {
?>
<!DOCTYPE html>
<?php include "/data/klattr.com/www/includes/head"; ?>
  <body>
    <?php include "/data/klattr.com/www/includes/header"; ?>

<div id="body">
  <div class="body_center">
    <div class="welcome" style="padding:10px; top:-70px;height:120px">
<h1 style="padding:0px;margin:0px;">Thank you for signing up with Klattr.</h1><br> An eMail has been sent with instructions to activate your account.<br>
If you have not recieved an eMail, please click <span class="fake-link" onclick="send_email()" >here</span> to have a new one sent out.<br><br>
The Klattr Team.
    </div>
  </div>
</div>


    <?php include "/data/klattr.com/www/includes/footer"; ?>
  </body>
</html>
<?php
  }  
} else {
  header( 'Location: https://klattr.com' );
}

?>
