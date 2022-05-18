<?php
include "/data/klattr.com/www/includes/auth";

if ($auth == 1) {


  $klattr_name = $_POST['klattr'];
  $klattr_path_ogg = "/data/klattr.com/www/povs/" . $klattr_name . ".ogg";
  $klattr_path_mp3 = "/data/klattr.com/www/povs/" . $klattr_name . ".mp3";

  $sql = "SELECT Parent_ID FROM Povs WHERE Data='$klattr_name' AND Poster='$UID'";
  $sql_result = mysqli_query($con,$sql);
  $row = mysqli_fetch_array($sql_result);
  if ($row['Parent_ID'] != "") {
    $parent = $row['Parent_ID'];
    $sql = "UPDATE Povs Set Num_Replies = Num_Replies - 1 WHERE ID='$parent' ";
    mysqli_query($con,$sql);
  }

  $sql = "DELETE FROM Povs WHERE Data='$klattr_name' AND Poster='$UID'";

  mysqli_query($con,$sql);
  $error = mysqli_error($con);
  file_put_contents('/tmp/error', $error);
  unlink($klattr_path_ogg);
  unlink($klattr_path_mp3);
} else {
  header( 'Location: https://klattr.com' );
}
?>
