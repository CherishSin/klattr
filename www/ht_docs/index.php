<?php
include "/data/klattr.com/www/includes/auth";
if ($auth == 1) {
$page = "Feed";
?>

<!DOCTYPE html>
<?php include "/data/klattr.com/www/includes/head"; ?>
  <body>
    <?php include "/data/klattr.com/www/includes/header"; ?>
    <?php include "/data/klattr.com/www/includes/logged_in"; ?>

<?php
} elseif ($auth == 0) {
?>

<!DOCTYPE html>
<?php include "/data/klattr.com/www/includes/head"; ?>
  <body>
    <?php include "/data/klattr.com/www/includes/header"; ?>
    <?php include "/data/klattr.com/www/includes/login"; ?>

<?php
}


?>




    <?php include "/data/klattr.com/www/includes/footer"; ?>
  </body>
</html>
