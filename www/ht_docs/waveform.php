<?php 
include "/data/klattr.com/www/includes/auth";
if ($auth == 1) {
  $png_name = $_GET["id"];
  //$png_name = substr($png_name, 1);
  $sql = "SELECT Waveform FROM Povs WHERE ID='$png_name'";
  $sql_result = mysqli_query($con,$sql);
  $row = mysqli_fetch_array($sql_result);
  header('Content-type: image/png');
  echo $row['Waveform'];
} else {
  header( 'Location: https://klattr.com' );
}
?>
