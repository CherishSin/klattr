<?php
include "/data/klattr.com/www/includes/auth";
$parentId = $_POST['parent_id'];
$nestLevel = $_POST['nest_level'];

$page = "replies";
if (is_numeric($parentId) && is_numeric($nestLevel)) {
  include "/data/klattr.com/www/includes/klattr_retrieve_queries";
  include "/data/klattr.com/www/includes/render_klattrs";
}
?>
