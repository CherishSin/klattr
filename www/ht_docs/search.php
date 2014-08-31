<?php
include "/data/klattr.com/www/includes/auth";

$searchTerm = $_GET['search'];
if ($_GET['type'] == "people") {
  $page = "peopleSearch";
  $ps = 1; 
}
$searchTerm = substr($searchTerm, 0, 30);
$searchQuery = urlencode($searchTerm);
$searchTerm = str_replace(array('/','=',',',';','\\','+',' '),'|', $searchTerm);

if ($auth == 1) {
  ?>
<!DOCTYPE html>
<?php include "/data/klattr.com/www/includes/head"; ?>
  <body>
    <script>var search_term = "<?php echo $searchTerm?>"; </script>
    <?php include "/data/klattr.com/www/includes/header"; ?>
    <?php include "/data/klattr.com/www/includes/search"; ?>

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
