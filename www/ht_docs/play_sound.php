<?php 
include "/data/klattr.com/www/includes/auth";
if ($auth == 1) {
  
  $sound_name = $_GET["sound"];
  $sound_type = substr($sound_name, -3);
  $sound_name = substr($sound_name, 1, -4);
  $sound_path = "/data/klattr.com/www/povs/" . $sound_name . "." . $sound_type;
  $sound = file_get_contents($sound_path);
  $sound_content = "Content-type: audio/" . $sound_type;
  //echo $sound_type;
  //echo $sound_name;
  header($sound_content);
  header('Accept-Ranges: bytes');
  echo $sound;
} else {
  header( 'Location: https://klattr.com' );
}
?>
