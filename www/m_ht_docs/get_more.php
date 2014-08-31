<?php
include "/data/klattr.com/www/includes/auth";
if ($auth == 1) {
  if (isset($_POST['oldest'])) {
    $oldest = $_POST['oldest'];
    $page = $_POST['page'];
    if (isset($_POST['profile_id'])) {
      $profileID = $_POST['profile_id'];
    }
    $get_more = 1;
// echo $page;
    $searchTerm = $_POST['search'];
    include "/data/klattr.com/www/includes/klattr_retrieve_queries";

    if ($page == "peopleSearch" ||  $page == "subscribed_to") {
//    echo "A";
      include "/data/klattr.com/www/includes/render_people";
    } else {
//    echo "B";
      include "/data/klattr.com/www/includes/render_klattrs";
    }
  }
} else {
  header( 'Location: https://klattr.com' );
}

?>
