<?php
include "/data/klattr.com/www/includes/auth";
if ($auth == 1) {
$page = "Feed";
?>

<!DOCTYPE html>
<?php include "/data/klattr.com/www/includes/m.head"; ?>
  <body>
    <?php include "/data/klattr.com/www/includes/m.header"; ?>
    <?php include "/data/klattr.com/www/includes/m.logged_in"; ?>

<?php
} elseif ($auth == 0) {
?>

<!DOCTYPE html>
<?php include "/data/klattr.com/www/includes/m.head"; ?>
  <body>
    <?php include "/data/klattr.com/www/includes/m.header"; ?>
    <?php include "/data/klattr.com/www/includes/m.login"; ?>

<?php
}


?>




    <?php include "/data/klattr.com/www/includes/m.footer"; ?>
  </body>
</html>
