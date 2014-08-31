<?php
include "/data/klattr.com/www/includes/auth";
if ($auth == 1) {
$page = "Forme";
?>

<!DOCTYPE html>
<?php include "/data/klattr.com/www/includes/head"; ?>
  <body>
    <?php include "/data/klattr.com/www/includes/header"; ?>
    <?php include "/data/klattr.com/www/includes/forme"; ?>

<?php
} else {
  header( 'Location: https://klattr.com' );
}
?>
    <?php include "/data/klattr.com/www/includes/footer"; ?>
  </body>
</html>

