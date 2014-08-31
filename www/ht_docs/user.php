<?php
include "/data/klattr.com/www/includes/auth";
$profileUname = $_GET["uname"];
$profileUname = substr($profileUname, 1);
if ($auth == 1) {
$page = "user";
?>

<!DOCTYPE html>
<?php include "/data/klattr.com/www/includes/head"; ?>
  <body>
    <?php include "/data/klattr.com/www/includes/header"; ?>
    <?php include "/data/klattr.com/www/includes/user_page" ?>
<?php
} elseif ($auth == 2) {
  header( 'Location: https://klattr.com' );
} elseif ($auth == 0) {
  header( 'Location: https://klattr.com' );
}


?>




    <?php include "/data/klattr.com/www/includes/footer"; ?>
  </body>
</html>

