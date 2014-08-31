<?php
include "/data/klattr.com/www/includes/auth";
if ($auth == 1) {
  $profileID = $_GET['user'];
  if ($profileID == "") {
    header( 'Location: https://klattr.com' );
  }
  $page = "subscribed_to";
  $ps = 1;
  ?>
<!DOCTYPE html>
<?php include "/data/klattr.com/www/includes/head"; ?>
  <body>
    <?php include "/data/klattr.com/www/includes/header"; ?>
  <div class="body_center">
    <div class="feed">
      <?php include "/data/klattr.com/www/includes/user_panel"; ?>
<div class="feed_inner"  id="klattr_parent" style="margin-bottom:10px;">
<h5><?php echo $profileID; ?> is subscribed to:</h5>
<?php
  include "/data/klattr.com/www/includes/klattr_retrieve_queries";
  include "/data/klattr.com/www/includes/render_people";

  if ($pcount == 0) {
?>

<div class="klattr_div">
  <center>Sorry. No results found.</center>
</div>

<?php
  } else {
    if ($ps == 1) {
      include "/data/klattr.com/www/includes/do_scroll"; 
    } else {

    }
?>
    </div>
  </div>
</div>
<?php
  }


} else {
    header( 'Location: https://klattr.com' );
}
?>

    <?php include "/data/klattr.com/www/includes/footer"; ?>
  </body>
</html>
